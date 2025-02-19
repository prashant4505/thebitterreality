@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="row">
    <!-- Card for Total Users -->
    <div class="col-md-4 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text">{{ $userCount }}</p> <!-- Dummy data for Total Users -->
                <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">Show Users</a>
            </div>
        </div>
    </div>

    <!-- Card for Total Posts -->
    <div class="col-md-4 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Posts</h5>
                <p class="card-text">{{ $jokesCount }}</p> <!-- Dummy data for Total Posts -->
                <a href="{{ route('posts.index') }}" class="btn btn-warning btn-sm">Show Jokes</a>
            </div>
        </div>
    </div>

    <!-- Card for Total Blogs -->
    <div class="col-md-4 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Blogs</h5>
                <p class="card-text">{{ $blogCount }}</p> <!-- Dummy data for Total Blogs -->
                <a href="{{ route('blogs.index') }}" class="btn btn-success btn-sm">Show Blogs</a>
            </div>
        </div>
    </div>

    <!-- Card for Total Contact Us -->
    <div class="col-md-4 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Contact Us</h5>
                <p class="card-text">{{ $contactMessage }}</p> <!-- Dummy data for Total Blogs -->
                <a href="{{ route('contact.index') }}" class="btn btn-info btn-sm">Show Contact Us</a>

            </div>
        </div>
    </div>
</div>


<!-- <div class="container">
    <a href="{{ route('blogs.create') }}" class="btn btn-primary btn-sm mb-5">Create Blogs</a>
    <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm mb-5">Create Jokes</a>
</div> -->

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
</form>
@endsection
