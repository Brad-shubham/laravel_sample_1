<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $total_students = User::where([
            ['user_type', '=', '3'],
        ])->count();

        $total_students_app_registered = User::where([
            ['user_type', '=', '3'],
            ['is_old', '=', '0'],
        ])->count();

        $total_students_paper_registered = User::where([
            ['user_type', '=', '3'],
            ['is_old', '=', '1'],
        ])->count();

        $total_active_students = User::with('profile')
            ->where('user_type', '=', '3')
            ->whereHas('profile', function ($query) {
                $query->where('activity_status', '=', 'active');
            })->count();

         $total_candidate_students = User::with('profile')
            ->where('user_type', '=', '3')
            ->whereHas('profile', function ($query) {
                $query->where('activity_status', '=', 'candidate');
            })->count();

        $total_inactive_students = User::with('profile')
            ->where('user_type', '=', '3')
            ->whereHas('profile', function ($query) {
                $query->where('activity_status', '=', 'inactive');
            })->count();

        $total_unresponsive_students = User::with('profile')
            ->where('user_type', '=', '3')
            ->whereHas('profile', function ($query) {
                $query->where('activity_status', '=', 'unresponsive');
            })->count();

        $total_tests_to_grade = TestResult::where('status', '=', '1')
            ->count();

        $dashboard_data = compact('total_students', 'total_students_app_registered', 'total_students_paper_registered',
            'total_active_students', 'total_candidate_students', 'total_inactive_students', 'total_unresponsive_students','total_tests_to_grade');

        return view('dashboard', ['dashboard_data'=>$dashboard_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
