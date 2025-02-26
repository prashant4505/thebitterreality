@extends('layouts.app')

@section('title', $blog->title)

@section('content')
<div class="container">
    <!-- Success message for deletion -->
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        @if($blog->image)
            <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" alt="Blog Image">
        @endif
        <div class="card-body">
            <h2 class="card-title">{{ $blog->title }}</h2>
            <p class="card-text">{!! $blog->description !!}</p>
            <a href="{{ route('blogs.index') }}" class="btn btn-primary btn-sm" style="text-align: center;">Back to Blogs</a>
        </div>
        <h3>Comments</h3>
        @foreach ($blog->comments as $comment)
            <div class="card mb-2">
                <div class="card-body">
                    <strong>{{ $comment->name }}</strong>
                    <p>{{ $comment->comment }}</p>

                    @auth
                        @if(Auth::user()->role == 'admin')
                            <div class="mt-2"> <!-- Added margin for spacing -->
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-comment-btn">Delete</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        @endforeach

        <h3>Leave a Comment</h3>
        <form action="{{ route('comments.store', $blog->id) }}" method="POST" style="margin:10px;">
            @csrf
            <textarea name="comment" class="form-control" placeholder="Write a comment..." required></textarea>
            <button type="submit" class="btn btn-primary btn-sm mt-1">Post Comment</button>
        </form>
    </div>
</div>
@endsection
