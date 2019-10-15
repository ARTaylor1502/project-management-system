@extends('roles.staff.layouts.master')

@section('title', 'Edit Client')

@section('content')
    <div class="title-bar">
        @if($client->logo())
            <img class="avatar" src="{{$client->logo()}}" alt="{{$client->name}} logo" title="{{$client->name}}">
        @else
            <i class="avatar-placeholder fal fa-user" title="{{$client->name}}"></i>
        @endif
        <h1>Edit Client #{{$client->id}} - {{$client->name}}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('staff.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('staff.client.list')}}">Clients</a></li>
            <li class="breadcrumb-item active">Edit Client</li>
        </ul>
    </div>

    <client-edit :client_id="{{$client->id}}" :what3words_api_key="'{{config('app.what3words_api_key')}}'"></client-edit>
@endsection
