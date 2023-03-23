<?php

namespace App\Http\Controllers;

use App\Jobs\SMSNotifications;
use App\Mail\StudentReport;
use App\Models\Country;
use App\Http\Requests\Student\CreateRequest;
use App\Http\Requests\Student\UpdateRequest;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\Language;
use App\Models\LessonStatus;
use App\Models\Book;
use App\Models\PostalCode;
use App\Models\TestProgress;
use App\Models\User;
use App\Models\UsersProfile;
use App\Notifications\StudentCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('students.index');
    }

    /**
     * Returns the users data for listing
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentData(Request $request)
    {
        $sortByColumn = 'id';
        $sortOrder = 'desc';
        $length = 10;
        $searchValue = '';

        if ($request->filled(['length'])) {
            $length = $request->input('length');
        }

        if ($request->filled(['dir'])) {
            $sortOrder = $request->input('dir');
        }

        if ($request->filled(['column'])) {
            $sortByColumn = $request->input('column');
        }

        if ($request->filled(['search'])) {
            $searchValue = $request->input('search');
        }

        $students = User::where('user_type', User::USER_TYPE['student'])
            ->where(function ($query) use ($searchValue) {
                $query->where("student_id", "LIKE", "%{$searchValue}%")
                    ->orWhere("old_student_id", "LIKE", "%{$searchValue}%")
                    ->orWhere("phone_number", "LIKE", "%{$searchValue}%")
                    ->orWhereHas('profile', function ($query) use ($searchValue) {
                        return $query->where("first_name", "LIKE", "%{$searchValue}%")
                            ->orWhere("surname", "LIKE", "%{$searchValue}%");
                    });
            })
            ->orderBy($sortByColumn, $sortOrder)
            ->paginate($length);

        if ($request->expectsJson()) {
            return response()->json($students, 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $userRoles = \App\Models\User::USER_TYPE;
        $userGender = \App\Models\User::GENDER;
        $userMartialStatus = \App\Models\User::MARTIAL_STATUS;
        $userReligion = \App\Models\User::RELIGION_TYPE;
        $userActivityStatus = \App\Models\User::ACTIVITY_STATUS;
        $postalCodes = PostalCode::all();
        $countries = Country::all();
        $languages = Language::all();

        return view('students.create',
            compact('userRoles', 'userMartialStatus', 'userGender', 'userReligion',
                'userActivityStatus', 'postalCodes', 'countries', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request)
    {
        $student_id = $this->generateStudentId();
        $random_password = Str::random(8);
        $status = empty($request->activity_status) ? 'candidate' : $request->activity_status;

        DB::beginTransaction();

        $student = User::create([
            'student_id' => $student_id,
            'email' => $request->get('email'),
            'password' => Hash::make($random_password),
            'country_code' => $request->get('country_code'),
            'phone_number' => $request->get('phone_number'),
            'user_type' => User::USER_TYPE['student'],
            'is_old' => $request->get('is_old'),
            'old_student_id' => $request->get('old_student_id'),
            'email_verified_at' => \Illuminate\Support\Facades\Date::now()
        ]);

        $profile = UsersProfile::create(
            array_merge($request->only([
                'first_name', 'surname', 'middle_name', 'country_id', 'address', 'city', 'private_mail_po_number',
                'birth_year',
                'org_po_number', 'designation', 'postal_code_id', 'date_enrolled',
                'encouragement_card_sent',
                'prisoner', 'gender', 'marital_status', 'religion', 'course_language_id', 'comment'
            ]), [
                'user_id' => $student->id, 'activity_status' => $status,
                'date_enrolled' => \Illuminate\Support\Facades\Date::now()
            ])
        );

        $firstCourse = Course::all()->first();
        if ($firstCourse) {
            CourseProgress::create([
                'course_id' => $firstCourse->getKey(),
                'student_id' => $student->getKey(),
                'status' => CourseProgress::STATUS['unlock'],
            ]);

            $firstLesson = $firstCourse->lessons()->first();
            if ($firstLesson) {
                LessonStatus::create([
                    'lesson_id' => $firstLesson->getKey(),
                    'student_id' => $student->getKey(),
                    'is_unlocked' => 1,
                ]);

                $firstTest = $firstLesson->test()->first();
                if ($firstTest) {
                    TestProgress::create([
                        'test_id' => $firstTest->getKey(),
                        'student_id' => $student->getKey(),
                        'is_unlocked' => 0,
                    ]);
                }
            }
        }

        DB::commit();

        if ($student->email) {
            $student->notify(new StudentCreated($random_password));
        }

        $message = 'You are invited to Truth Bible app. Here is your credentials to login into the system. StudentID:'.$student->student_id.' Password:'.$random_password;

        $this->dispatch(new SMSNotifications($student, $message));

        return response()->json([
            'status' => true,
            'student' => $student,
            'message' => 'Student added successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $student
     * @return View
     */
    public function show(User $student)
    {
        $userRoles = \App\Models\User::USER_TYPE;
        $userGender = \App\Models\User::GENDER;
        $userMartialStatus = \App\Models\User::MARTIAL_STATUS;
        $userReligion = \App\Models\User::RELIGION_TYPE;
        $userActivityStatus = \App\Models\User::ACTIVITY_STATUS;

        return view('students.view',
            compact('student', 'userRoles', 'userGender', 'userMartialStatus', 'userReligion', 'userActivityStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $student
     * @return View
     */
    public function edit(User $student)
    {
        $userRoles = \App\Models\User::USER_TYPE;
        $userGender = \App\Models\User::GENDER;
        $userMartialStatus = \App\Models\User::MARTIAL_STATUS;
        $userReligion = \App\Models\User::RELIGION_TYPE;
        $userActivityStatus = \App\Models\User::ACTIVITY_STATUS;
        $postalCodes = PostalCode::all();
        $countries = Country::all();
        $languages = Language::all();

        return view('students.edit',
            compact('student', 'userRoles', 'userMartialStatus', 'userGender', 'userReligion',
                'userActivityStatus', 'postalCodes', 'countries', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $student
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, User $student)
    {
        DB::beginTransaction();

        $update = $student->update($request->only(['email', 'country_code', 'phone_number', 'is_old', 'old_student_id']));

        $profile = UsersProfile::updateOrCreate(['user_id' => $student->id], $request->only([
            'first_name', 'surname', 'middle_name', 'country_id', 'city', 'private_mail_po_number', 'birth_year',
            'org_po_number', 'designation', 'postal_code_id', 'date_enrolled', 'encouragement_card_sent',
            'prisoner', 'gender', 'marital_status', 'religion', 'course_language_id', 'activity_status', 'comment'
        ]));

        DB::commit();

        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $student
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $student)
    {
        DB::beginTransaction();

        $student->profile()->delete();
        if ($student->testResults()) {
            $student->testResults()->delete();
        }
        $student->delete();

        DB::commit();

        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * To generate random student id for invited students
     *
     * @return int
     */
    public function generateStudentId()
    {
        $lastEnrolledStudent = User::withTrashed()
            ->where('user_type', User::USER_TYPE['student'])
//            ->where('is_old', false)
            ->get()
            ->last();

        if (is_null($lastEnrolledStudent)) {
            $studentID = 1000000; // 7 digit number
        } else {
            $studentID = $lastEnrolledStudent->student_id + 1;
        }

        return $studentID;
    }

    /**
     * Check student exists
     *
     * @param $number
     * @return mixed
     */
    public function studentIdExists($number)
    {
        return User::where('student_id', $number)->exists();
    }

    /**
     * Detailed information of student activities
     *
     * @param  User  $student
     *
     * @return View
     */
    public function report(User $student)
    {
        $student->loadMissing('certificates');

        return view('students.report', compact('student'));
    }

    /**
     * Reflexive questions details within course
     *
     * @param  User  $student
     * @param  Course  $course
     *
     * @return View
     */
    public function courseDetails(User $student, Course $course)
    {
        $course->loadMissing([
            'lessons',
            'lessons.lessonStatus' => function ($query) use ($student) {
                $query->where('student_id', $student->getKey());
            },
            'lessons.paragraphAnswers' => function ($query) use ($student) {
                $query->where('user_id', $student->getKey());
            },
            'lessons.paragraphAnswers.paragraphQuestion',
        ]);

        return view('students.courseDetails', compact('student', 'course'));
    }

    /**
     * Listing of course details related to student
     *
     * @param  Request  $request
     * @param  User  $student
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCourseListing(Request $request, User $student)
    {
        $sortByColumn = 'id';
        $sortOrder = 'desc';
        $length = 10;
        $searchValue = '';

        if ($request->filled(['length'])) {
            $length = $request->input('length');
        }

        if ($request->filled(['dir'])) {
            $sortOrder = $request->input('dir');
        }

        if ($request->filled(['column'])) {
            $sortByColumn = $request->input('column');
        }

        if ($request->filled(['search'])) {
            $searchValue = $request->input('search');
        }

        $courses = CourseProgress::with('course')
            ->where('student_id', $student->id)
            ->whereHas('course', function ($query) use ($student, $searchValue) {
                $query->where("name", "LIKE", "%{$searchValue}%");
            })
            ->orderBy($sortByColumn, $sortOrder)
            ->paginate($length);

        $lastCourseUnlocked = CourseProgress::where('student_id', $student->id)
                        ->orderBy('course_id', 'DESC')->first();

        $nextCourseToUnlock = Course::where('id', '>', $lastCourseUnlocked->course_id)->orderBy('id', 'asc')->first();

        if ($request->expectsJson()) {
            return response()->json([
                'courses'   =>  $courses,
                'nextCourseToUnlock'=>  $nextCourseToUnlock
            ], 200);
        }
    }

    /**
     * Listing of test result details related to student
     *
     * @param  Request  $request
     * @param  User  $student
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTestResultListing(Request $request, User $student)
    {
        $sortByColumn = 'status';
        $sortOrder = 'asc';
        $length = 10;
        $searchValue = '';

        if ($request->filled(['length'])) {
            $length = $request->input('length');
        }

        if ($request->filled(['dir'])) {
            $sortOrder = $request->input('dir');
        }

        if ($request->filled(['column'])) {
            $sortByColumn = $request->input('column');
        }

        if ($request->filled(['search'])) {
            $searchValue = $request->input('search');
        }

        $testResults = $student->testResults()
            ->with('answer', 'test')
            ->whereHas('test', function ($query) use ($searchValue) {
                $query->where("title", "LIKE", "%{$searchValue}%");
            })
            ->orderBy($sortByColumn, $sortOrder)
            ->orderBy('created_at', 'desc')
            ->paginate($length);

        if ($request->expectsJson()) {
            return response()->json($testResults, 200);
        }
    }

    /**
     * Update gift sent status for student
     *
     * @param  User  $student
     * @param  Course  $course
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateGiftSent(Request $request, User $student, Course $course)
    {
        CourseProgress::where('student_id', $student->getKey())->where('course_id',
            $course->getKey())->update(['gift_sent' => $request->input('gift_sent')]);

        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * Gift Reminder listing
     */
    public function giftReminder()
    {
        return view('students.giftReminderListing');
    }

    /**
     *
     */
    public function getGiftReminderListing(Request $request)
    {
        $sortByColumn = 'id';
        $sortOrder = 'desc';
        $length = 10;
        $searchValue = '';

        if ($request->filled(['length'])) {
            $length = $request->input('length');
        }

        if ($request->filled(['dir'])) {
            $sortOrder = $request->input('dir');
        }

        if ($request->filled(['column'])) {
            $sortByColumn = $request->input('column');
        }

        if ($request->filled(['search'])) {
            $searchValue = $request->input('search');
        }

        $giftSent = CourseProgress::with(['student', 'course'])
            ->where('status', CourseProgress::STATUS['completed'])
            ->where('gift_status', true)
            ->where(function ($query) use ($searchValue) {
                $query->whereHas('student', function ($query) use ($searchValue) {
                    $query->where("student_id", "LIKE", "%{$searchValue}%")
                        ->orWhere("phone_number", "LIKE", "%{$searchValue}%")
                        ->orWhereHas('profile', function ($query) use ($searchValue) {
                            return $query->where("first_name", "LIKE", "%{$searchValue}%")
                                ->orWhere("surname", "LIKE", "%{$searchValue}%");
                        });
                });
            })
            ->orderBy($sortByColumn, $sortOrder)
            ->paginate($length);

        if ($request->expectsJson()) {
            return response()->json($giftSent, 200);
        }
    }

    /**
     * list of export student
     */
    public function export()
    {
        return view('students.export');
    }

    public function exportListing(Request $request)
    {
        $sortByColumn = 'id';
        $sortOrder = 'desc';
        $length = 10;
        $searchValue = '';

        if ($request->filled(['length'])) {
            $length = $request->input('length');
        }

        if ($request->filled(['dir'])) {
            $sortOrder = $request->input('dir');
        }

        if ($request->filled(['column'])) {
            $sortByColumn = $request->input('column');
        }

        if ($request->filled(['search'])) {
            $searchValue = $request->input('search');
        }

        $students = User::where('user_type', User::USER_TYPE['student'])
            ->where(function ($query) use ($searchValue) {
                $query->where("student_id", "LIKE", "%{$searchValue}%")
                    ->orWhere("phone_number", "LIKE", "%{$searchValue}%")
                    ->orWhereHas('profile', function ($query) use ($searchValue) {
                        return $query->where("first_name", "LIKE", "%{$searchValue}%")
                            ->orWhere("surname", "LIKE", "%{$searchValue}%");
                    });
            })
            ->whereHas('profile', function ($query) {
                return $query->where("activity_status", "=", "inactive")
                    ->orWhere("activity_status", "=", "unresponsive")
                ->orWhere("activity_status", "=", "active");
            })
            ->orderBy($sortByColumn, $sortOrder)
            ->paginate($length);

        if ($request->expectsJson()) {
            return response()->json($students, 200);
        }
    }

    function exportPDF(Request $request)
    {
        $user = User::find(\auth()->user()->id);

        $type = $request->filled(['type']) ? $request->input('type') : false;

        if ($type) {
            $students = User::where('user_type', User::USER_TYPE['student'])
                ->whereHas('profile', function ($query) use ($type) {
                    return $query->where("activity_status", "=", $type);
                })
                ->get();
        } else {
            $students = User::where('user_type', User::USER_TYPE['student'])
                ->whereHas('profile', function ($query) {
                    return $query->where("activity_status", "=", "inactive")
                        ->orWhere("activity_status", "=", "unresponsive")
                    ->orWhere("activity_status", "=", "active");
                })
                ->get();
        }

        Mail::to($user->email)->send(new StudentReport($user, $students));
    }

    public function unlockLesson($studentId, $courseId, $lessonId)
    {
        $lessonStatus = LessonStatus::create([
            'lesson_id' => $lessonId,
            'student_id' => $studentId,
            'is_unlocked' => 1,
        ]);
        $lessonStatus->save();

        $course = Course::where('id', $courseId)->first();
        $student = User::where('id', $studentId)->first();

        // @todo can remove this becoz for now whole page is reloading, else can use component rendering in vue component
        $course->loadMissing([
            'lessons',
            'lessons.lessonStatus' => function ($query) use ($student) {
                $query->where('student_id', $student->id);
            },
            'lessons.paragraphAnswers' => function ($query) use ($student) {
                $query->where('user_id', $student->id);
            },
            'lessons.paragraphAnswers.paragraphQuestion',
        ]);
        return response()->json([
           'student' => $student,
           'course' => $course
        ]);

    }

    public function unlockCourse(User $student, $courseToUnlockId)
    {
        $course = CourseProgress::updateOrCreate([
            'course_id' => $courseToUnlockId,
            'student_id' => $student->id,
        ], [
            'course_id' => $courseToUnlockId,
            'student_id' => $student->id,
            'status' => CourseProgress::STATUS['unlock'],
        ]);

        return response()->json($course,200);
    }

    public function unlockBook($studentId, $courseId, $bookId)
    {
        $book = Book::where('id', $bookId)->with('lessons')->first();
        $lessonsId = $book->lessons->map(function ($lesson, $key) {
            return $lesson->id;
        });

        $lessonsId->each(function ($lessonId, $key) use  ($studentId) {
            $lessonStatus = LessonStatus::where('lesson_id', $lessonId)
               ->where('student_id', $studentId)->first();
            if (!$lessonStatus) {
                LessonStatus::create([
                    'lesson_id' => $lessonId,
                    'student_id' => $studentId,
                    'is_unlocked' => 1,
                ]);
            }
        });
        return response()->json('success',200);
    }

    public function unlockAllBooks($studentId, $courseId)
    {
        $books = Book::where('course_id', $courseId)->with('lessons')->get();

        $lessonsId = collect();
        $books->each(function ($book) use ($lessonsId) {
            $lessonsId[] = $book->lessons->map(function ($lesson) {
                return $lesson->id;
            });
        });

        $lessonsId->flatten()->each(function ($lessonId, $key) use  ($studentId) {
            $lessonStatus = LessonStatus::where('lesson_id', $lessonId)
                ->where('student_id', $studentId)->first();
            if (!$lessonStatus) {
                LessonStatus::create([
                    'lesson_id' => $lessonId,
                    'student_id' => $studentId,
                    'is_unlocked' => 1,
                ]);
            }
        });
        return response()->json('success',200);
    }

}
