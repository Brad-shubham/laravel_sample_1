@extends('layouts.app')

@section('pageTitle','Tests Listing')

@section('content')

    <div class="container-fluid">
        <test-index
            :canEdit='{{ (\Illuminate\Support\Facades\Auth::user()->user_type !== \App\Models\User::USER_TYPE['teacher']) ? 1 : 0 }}'></test-index>
    </div>
@endsection
