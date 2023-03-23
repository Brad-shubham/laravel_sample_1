@extends('layouts.app')

@section('pageTitle','Books Listing')

@section('content')
    <div class="container-fluid">
        <book-index
            :canEdit='{{ (\Illuminate\Support\Facades\Auth::user()->user_type !== \App\Models\User::USER_TYPE['teacher']) ? 1 : 0 }}'></book-index>

    </div>
@endsection
