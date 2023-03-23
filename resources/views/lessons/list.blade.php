@extends('layouts.app')

@section('pageTitle','Lessons Listing')

@section('content')
    <div class="container-fluid">
        <lesson-index
            :canEdit='{{ (\Illuminate\Support\Facades\Auth::user()->user_type !== \App\Models\User::USER_TYPE['teacher']) ? 1 : 0 }}'></lesson-index>
    </div>
@endsection
