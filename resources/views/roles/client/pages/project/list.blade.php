@extends('roles.client.layouts.master')

@section('title', 'Projects')

@section('content')
    <h1>Projects</h1>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
        <li class="breadcrumb-item active">Projects</li>
    </ul>
    <client-projects-list :client_id="{{$user->client_id}}"></client-projects-list>
@endsection
