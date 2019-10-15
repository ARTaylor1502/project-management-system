@extends('roles.staff.layouts.master')

@section('title', 'Projects')

@section('content')
    <h1>Projects</h1>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('staff.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Projects</li>
    </ul>
    <a href="{{route('staff.project.add')}}" class="cta btn btn-primary float-right">Add New Project <i class="fas fa-plus"></i></a>

    <project-list></project-list>
@endsection
