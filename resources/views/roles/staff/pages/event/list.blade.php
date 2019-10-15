@extends('roles.staff.layouts.master')

@section('title', 'Events')

@section('content')
    <h1>Events <span class="sub-title"><counter></counter></span></h1>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('staff.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Events</li>
    </ul>
    <events-list></events-list>
@endsection
