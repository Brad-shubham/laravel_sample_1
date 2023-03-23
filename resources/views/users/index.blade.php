@extends('layouts.app')

@section('pageTitle','Users Listing')

@section('content')

    <div class="container-fluid">
        <user-index
            :canEdit='{{ (\Illuminate\Support\Facades\Auth::user()->user_type !== \App\Models\User::USER_TYPE['teacher']) ? 1 : 0 }}'></user-index>
    </div>
@endsection
