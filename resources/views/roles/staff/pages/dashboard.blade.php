@extends('roles.staff.layouts.master')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>
    <p class="mb-5">{{$welcome_message}} {{$user->first_name}}</p>
    <staff-dashboard :staff_id="{{$user->id}}"></staff-dashboard>
@endsection
