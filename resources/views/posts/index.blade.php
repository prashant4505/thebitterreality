@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Posts</h2>
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>

    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text"><strong>Category:</strong> {{ $post->category }}</p>
                <p class="card-text">{{ $post->description }}</p>
                <div class="d-flex">
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
