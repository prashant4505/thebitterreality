@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Post</h2>
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-control" name="category" id="category" required>
                <option value="">Select a category</option>
                @foreach(['Animal Jokes', 'Dad Jokes', 'Dark Humor', 'One-Liner Jokes', 'Political Jokes', 'Relationship Jokes', 'Technology Jokes', 'Workplace Jokes', 'Sports Jokes', 'Medical Jokes', 'School Jokes'] as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
