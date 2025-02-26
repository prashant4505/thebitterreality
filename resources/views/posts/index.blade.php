@extends('layouts.app')

@section('content')
<div class="container">
    <form method="GET" action="{{ route('posts.index') }}" class="mb-3" onchange="this.submit()">
        <select name="category" class="form-control">
            <option value="">All Categories</option>
            <option value="Animal Jokes" {{ request('category') == 'Animal Jokes' ? 'selected' : '' }}>Animal Jokes</option>
            <option value="Dad Jokes" {{ request('category') == 'Dad Jokes' ? 'selected' : '' }}>Dad Jokes</option>
            <option value="Dark Humor" {{ request('category') == 'Dark Humor' ? 'selected' : '' }}>Dark Humor</option>
            <option value="One-Liner Jokes" {{ request('category') == 'One-Liner Jokes' ? 'selected' : '' }}>One-Liner Jokes</option>
            <option value="Political Jokes" {{ request('category') == 'Political Jokes' ? 'selected' : '' }}>Political Jokes</option>
            <option value="Relationship Jokes" {{ request('category') == 'Relationship Jokes' ? 'selected' : '' }}>Relationship Jokes</option>
            <option value="Technology Jokes" {{ request('category') == 'Technology Jokes' ? 'selected' : '' }}>Technology Jokes</option>
            <option value="Workplace Jokes" {{ request('category') == 'Workplace Jokes' ? 'selected' : '' }}>Workplace Jokes</option>
            <option value="Sports Jokes" {{ request('category') == 'Sports Jokes' ? 'selected' : '' }}>Sports Jokes</option>
            <option value="Medical Jokes" {{ request('category') == 'Medical Jokes' ? 'selected' : '' }}>Medical Jokes</option>
            <option value="School Jokes" {{ request('category') == 'School Jokes' ? 'selected' : '' }}>School Jokes</option>
        </select>
    </form>

    <h2>Posts</h2>
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>

    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text"><strong>Category:</strong> {{ $post->category }}</p>
                <p class="card-text">{!! $post->description !!}</p>
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
    <nav aria-label="Page navigation example">
        {{ $posts->appends(request()->query())->links('pagination::bootstrap-4') }}  <!-- Use bootstrap-5 for Bootstrap 5 -->
    </nav>
</div>
@endsection
