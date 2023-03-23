<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\ProfileRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Jobs\SMSNotifications;
use App\Models\Country;
use App\Models\PostalCode;
use App\Models\User;
use App\Models\UsersProfile;
use App\Notifications\TeacherCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Returns the users data for listing
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserData(Request $request)
    {
        $userRoles = User::USER_TYPE;

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


        $users = User::with('profile')
            ->where('user_type', '<>', User::USER_TYPE['student'])
            ->where(function ($query) use ($searchValue) {
                $query->whereHas('profile', function ($query) use ($searchValue) {
                    return $query->where("first_name", "LIKE", "%{$searchValue}%")
                        ->orWhere("surname", "LIKE", "%{$searchValue}%");
                });
            })
            ->orderBy($sortByColumn, $sortOrder)
            ->paginate($length);

        if ($request->expectsJson()) {
            return response()->json(['users' => $users, 'roles' => $userRoles], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $userRoles = User::USER_TYPE;
        $postalCodes = PostalCode::all();
        $countries = Country::all();

        return view('users.create', compact('userRoles', 'postalCodes', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request)
    {
        $random_password = Str::random(8);

        DB::beginTransaction();

        $user = User::create([
            'email' => $request->get('email'),
            'password' => Hash::make($random_password),
            'country_code' => $request->get('country_code'),
            'phone_number' => $request->get('phone_number'),
            'user_type' => User::USER_TYPE['teacher'],
            'email_verified_at' => \Illuminate\Support\Facades\Date::now()
        ]);

        $profile = UsersProfile::create(
            array_merge($request->only([
                'first_name', 'surname', 'middle_name', 'country_id', 'city', 'private_mail_po_number',
                'org_po_number',
                'designation',
                'postal_code_id'
            ]), ['user_id' => $user->id, 'date_enrolled' => \Illuminate\Support\Facades\Date::now()])
        );

        DB::commit();

        $user->notify(new TeacherCreated($random_password));

        $message = 'You are added to Truth Bible app. Here is your credentials to login into the system. Email:'.$user->email.' Password:'.$random_password.' Site URL:'.config('app.url');

        $this->dispatch(new SMSNotifications($user, $message));

        return response()->json([
            'status' => true,
            'user' => $user,
            'message' => 'Teacher created successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $userRoles = User::USER_TYPE;
        $postalCodes = PostalCode::all();
        $countries = Country::all();

        return view('users.edit', compact('user', 'userRoles', 'postalCodes', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, User $user)
    {
        DB::beginTransaction();

        $update = $user->update($request->only(['user_type', 'country_code', 'phone_number']));

        $profile = UsersProfile::updateOrCreate(['user_id' => $user->id], $request->only([
            'first_name', 'surname', 'middle_name', 'country_id', 'city', 'private_mail_po_number', 'org_po_number',
            'designation',
            'postal_code_id'
        ]));

        DB::commit();

        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();

        $user->delete();

        DB::commit();

        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * Show user profile
     *
     * @param  User  $user
     * @return \Illuminate\View\View
     */
    public function profile(User $user)
    {
        return view('users.editProfile', compact('user'));
    }

    /**
     * Update user profile
     *
     * @param  ProfileRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveProfile(ProfileRequest $request, User $user)
    {
        if ($request->input('password')) {
            $data = [
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ];
        } else {
            $data = [
                'email' => $request->input('email'),
            ];
        }

        $update = $user->update($data);

        $profile = UsersProfile::updateOrCreate(['user_id' => $user->id], $request->only([
            'first_name', 'middle_name', 'surname'
        ]));

        return response()->json([
            'status' => true,
        ]);
    }
}
