@extends('roles.staff.layouts.master')

@section('title', 'My Projects')

@section('content')
    <h1>My Projects</h1>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('staff.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">My Projects</li>
    </ul>
@endsection
