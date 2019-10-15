@extends('roles.staff.layouts.master')

@section('title', 'Add User')

@section('content')
    <h1>Add User</h1>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('staff.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('staff.user.list')}}">Users</a></li>
        <li class="breadcrumb-item active">Add User</li>
    </ul>
    <create-user :what3words_api_key="'{{config('app.what3words_api_key')}}'"></create-user>
@endsection
