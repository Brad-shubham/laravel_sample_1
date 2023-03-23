@extends('layouts.app')

@section('pageTitle','Courses Listing')

@section('content')
    <div class="container-fluid">
        <course-index
            :canEdit='{{ (\Illuminate\Support\Facades\Auth::user()->user_type !== \App\Models\User::USER_TYPE['teacher']) ? 1 : 0 }}'></course-index>

    </div>
@endsection
