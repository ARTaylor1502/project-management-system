@extends('roles.staff.layouts.master')

@section('title', 'Clients')

@section('content')
    <h1>Clients <span class="sub-title"><counter></counter></span></h1>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('staff.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Clients</li>
    </ul>
    <client-list></client-list>
@endsection
