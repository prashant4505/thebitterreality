@extends('layouts.app')

@section('title', $blog->title)

@section('content')
<div class="container">
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
            <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; margin:10px; border-radius:6px;">
                <p>{{ $comment->comment }}</p>
                <small>- <strong>{{ $comment->name }}</strong>, {{ $comment->created_at->format('F j, Y') }}</small>
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
