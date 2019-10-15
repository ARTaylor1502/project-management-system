@extends('roles.staff.layouts.master')

@section('title', 'Add Client')

@section('content')
    <h1>Add Client</h1>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('staff.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('staff.client.list')}}">Clients</a></li>
        <li class="breadcrumb-item active">Add Client</li>
    </ul>
    <create-client :what3words_api_key="'{{config('app.what3words_api_key')}}'"></create-client>
@endsection
