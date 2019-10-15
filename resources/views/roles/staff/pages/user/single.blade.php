@extends('roles.staff.layouts.master')

@section('title', 'User')

@section('content')
    <div class="title-bar">
        <user-avatar :user_id="{{$user->id}}" :user_full_name="'{{$user->full_name()}}'"></user-avatar>
        <h1>{{$user->full_name()}}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('staff.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('staff.user.list')}}">Users</a></li>
            <li class="breadcrumb-item active">Edit User</li>
        </ul>
    </div>
    <user-edit :user_id="{{$user->id}}" :what3words_api_key="'{{config('app.what3words_api_key')}}'"></user-edit>
@endsection
