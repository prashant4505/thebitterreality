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
    </div>
</div>
@endsection
