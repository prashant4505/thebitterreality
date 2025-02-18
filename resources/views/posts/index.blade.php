@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Posts</h2>
    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text"><strong>Category:</strong> {{ $post->category }}</p>
                <p class="card-text">{{ $post->description }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection
