@extends('roles.staff.layouts.master')

@section('title', 'All Users')

@section('content')
    <h1>All Users <span class="sub-title"><counter></counter></span></h1>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('staff.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ul>
    <users-list></users-list>
@endsection
