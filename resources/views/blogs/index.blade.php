@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Blog Posts</h2>
    @foreach ($blogs as $blog)
        <div class="card mb-3">
            <div class="row g-0">
                <!-- Left Side: Image -->
                <div class="col-md-4">
                    @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid rounded-start" alt="Blog Image">
                    @endif
                </div>

                <!-- Right Side: Title and Description -->
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($blog->description, 300) }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
