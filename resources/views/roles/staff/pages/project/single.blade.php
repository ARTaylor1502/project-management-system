@extends('roles.staff.layouts.master')

@section('title', 'Project')

@section('content')
    <div class="title-bar">
        @if($project->client->logo())
            <img class="avatar" src="{{$project->client->logo()}}" alt="{{$project->client->name}} logo" title="{{$project->client->name}}">
        @else
            <i class="avatar-placeholder fal fa-user" title="{{$project->client->name}}"></i>
        @endif
        <h1>Project #{{$project->id}} - {{$project->name}}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('staff.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('staff.project.list')}}">Projects</a></li>
            <li class="breadcrumb-item active">#{{$project->id}} - {{$project->name}}</li>
        </ul>
    </div>
    <staff-project :project_id="{{$project->id}}" :user_id="{{$user->id}}" :what3words_api_key="'{{config('app.what3words_api_key')}}'"></staff-project>
@endsection

@section('scripts')
    <script src="https://assets.what3words.com/sdk/v3/what3words.js?key={{config('app.what3words_api_key')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_maps_api_key')}}"></script>
@endsection
