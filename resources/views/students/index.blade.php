@extends('layouts.app')

@section('pageTitle','Students Listing')

@section('content')

    <div class="container-fluid">
        <student-index
            :canEdit='{{ (\Illuminate\Support\Facades\Auth::user()->user_type !== \App\Models\User::USER_TYPE['teacher']) ? 1 : 0 }}'></student-index>

    </div>
@endsection
