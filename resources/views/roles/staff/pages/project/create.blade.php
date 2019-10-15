@extends('roles.staff.layouts.master')

@section('title', 'Add Project')

@section('content')
    <h1>Add Project</h1>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('staff.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('staff.project.list')}}">Projects</a></li>
        <li class="breadcrumb-item active">Add Project</li>
    </ul>
    <create-project></create-project>
@endsection

@section('scripts')
    <script src="https://assets.what3words.com/sdk/v3/what3words.js?key={{config('app.what3words_api_key')}}"></script>
@endsection
