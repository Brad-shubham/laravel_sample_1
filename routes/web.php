<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Reserve home page for future use
Route::redirect('/', 'login', 302)->name('/');

Route::get('/verify_status', function () {
    return view('emails.status');
});

Route::get('user/verify/{token}', 'VerificationController@verifyEmail')->name('email.verification');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Certificates Route
Route::get('students/{user}/certificates/level-one',
    'CertificateController@levelOne')->name('certificate.levelOne');

Route::get('students/{user}/certificates/level-two',
    'CertificateController@levelTwo')->name('certificate.levelTwo');

Route::get('students/{user}/certificates/level-three',
    'CertificateController@levelThree')->name('certificate.levelThree');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('profile/{user}', 'UserController@profile')->name('user.profile')->middleware('role:super admin,admin,teacher');
    Route::put('profile/{user}/update', 'UserController@saveProfile')->name('user.profile.update')->middleware('role:super admin,admin,teacher');

    // Students Route
    Route::get('students/list',
        'StudentController@getStudentData')->name('students.list')->middleware('role:super admin,admin,teacher');

    Route::get('students/export',
        'StudentController@export')->name('students.export')->middleware('role:super admin,admin,teacher');

    Route::get('students/export/list',
        'StudentController@exportListing')->name('students.exportListing')->middleware('role:super admin,admin,teacher');

    Route::get('students/export/pdf',
        'StudentController@exportPDF')->name('students.exportPDF')->middleware('role:super admin,admin,teacher');

    Route::resource('students', 'StudentController')
        ->only(['index', 'create', 'store', 'edit', 'update', 'show'])->middleware('role:super admin,admin,teacher');

    Route::resource('students', 'StudentController')
        ->only(['destroy'])->middleware('role:super admin,admin');

    Route::get('students/{student}/report',
        'StudentController@report')->name('students.report')->middleware('role:super admin,admin,teacher');

    Route::get('students/{student}/course/list',
        'StudentController@getCourseListing')->name('students.course.list')->middleware('role:super admin,admin,teacher');

    Route::get('students/{student}/test-results/list',
        'StudentController@getTestResultListing')->name('students.testResult.list')->middleware('role:super admin,admin,teacher');

    Route::get('students/{student}/courses/{course}',
        'StudentController@courseDetails')->name('students.course.details')->middleware('role:super admin,admin,teacher');

    Route::patch('students/{student}/courses/{course}',
        'StudentController@updateGiftSent')->name('students.update.giftSent')->middleware('role:super admin,admin,teacher');

    //Users Route
    Route::get('users/list', 'UserController@getUserData')->name('users.list')->middleware('role:super admin,admin,teacher');

    Route::resource('users', 'UserController')
        ->only(['create', 'edit', 'update', 'destroy', 'store'])->middleware('role:super admin,admin');

    Route::resource('users', 'UserController')
        ->only(['index', 'show'])->middleware('role:super admin,admin,teacher');

    //Courses Route
    Route::get('courses/list',
        'CourseController@getCourseData')->name('courses.list')->middleware('role:super admin,admin,teacher');

    Route::resource('courses', 'CourseController')
        ->only(['create', 'edit', 'update', 'destroy', 'store'])->middleware('role:super admin,admin');

    Route::resource('courses', 'CourseController')
        ->only(['index', 'show'])->middleware('role:super admin,admin,teacher');

    //Tests Route
    Route::get('tests/list', 'TestController@getTestData')->name('tests.list')->middleware('role:super admin,admin,teacher');

    Route::resource('tests', 'TestController')
        ->only(['create', 'edit', 'update', 'destroy', 'store'])->middleware('role:super admin,admin');

    Route::resource('tests', 'TestController')
        ->only(['index', 'show'])->middleware('role:super admin,admin,teacher');

    Route::delete('tests/{test}/questions/{testQuestion}/delete',
        'TestController@deleteQuestion')->name('tests.question.delete')->middleware('role:super admin,admin');

    Route::delete('tests/{test}/questions/{testQuestion}/options/{testQuestionOption}/delete',
        'TestController@deleteOption')->name('tests.questions.option.delete')->middleware('role:super admin,admin');

    Route::get('offline-test-entry',
        'TestController@offlineTestEntry')->name('offline.test.entry')->middleware('role:super admin,admin,teacher');

    Route::post('offline-test-entry',
        'TestController@saveOfflineTestEntry')->name('offline.test.entry')->middleware('role:super admin,admin,teacher');

    //Books Route
    Route::get('books/list', 'BookController@getBooksData')->name('books.list')->middleware('role:super admin,admin,teacher');

    Route::resource('books', 'BookController')
        ->only(['create', 'edit', 'update', 'destroy', 'store'])->middleware('role:super admin,admin');

    Route::resource('books', 'BookController')
        ->only(['index', 'show'])->middleware('role:super admin,admin,teacher');

    //Lessons Route
    Route::get('lessons/list',
        'LessonController@getlessonsData')->name('lessons.list')->middleware('role:super admin,admin,teacher');

    Route::resource('lessons', 'LessonController')
        ->only(['create', 'edit', 'update', 'destroy', 'store'])->middleware('role:super admin,admin');

    Route::resource('lessons', 'LessonController')
        ->only(['index', 'show'])->middleware('role:super admin,admin,teacher');

    //Test Answers Route
    Route::get('test-answers/list',
        'TestAnswerController@getTestAnswerData')->name('testAnswers.list')->middleware('role:super admin,admin,teacher');

    Route::resource('test-answers', 'TestAnswerController')
        ->only(['index', 'edit', 'update'])->middleware('role:super admin,admin,teacher');

    Route::delete('book-sections/{id}',
        'BookSectionController@destroy')->name('bookSections.destroy')->middleware('role:super admin,admin');

    Route::delete('paragraphs/{id}',
        'ParagraphController@destroy')->name('paragraphs.destroy')->middleware('role:super admin,admin');

    Route::delete('paragraph-questions/{id}',
        'ParagraphQuestionController@destroy')->name('paragraphQuestions.destroy')->middleware('role:super admin,admin');

    // Gift Sent Routes
    Route::get('gift-reminder',
        'StudentController@giftReminder')->name('gift.reminder')->middleware('role:super admin,admin,teacher');

    Route::get('gift-reminder/list',
        'StudentController@getGiftReminderListing')->name('gift.reminder.list')->middleware('role:super admin,admin,teacher');

    Route::post('students/{student}/courses/{course}/lessons/{lesson}',
        'StudentController@unlockLesson')->name('lesson.unlock')->middleware('role:super admin,admin,teacher');

    Route::post('students/{student}/courses/{course}/unlock',
        'StudentController@unlockCourse')->name('course.unlock')->middleware('role:super admin,admin,teacher');

    Route::post('students/{student}/courses/{course}/books/{book}',
        'StudentController@unlockBook')->name('book.unlock')->middleware('role:super admin,admin,teacher');

    Route::post('students/{student}/courses/{course}/unlockbooks',
        'StudentController@unlockAllBooks')->name('book.unlockAll')->middleware('role:super admin,admin,teacher');
});
