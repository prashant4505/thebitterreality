@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Post</h2>
    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ $post->title }}" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-control" name="category" id="category" required>
                <option value="">Select a category</option>
                <option value="Animal Jokes" {{ $post->category == 'Animal Jokes' ? 'selected' : '' }}>Animal Jokes</option>
                <option value="Dad Jokes" {{ $post->category == 'Dad Jokes' ? 'selected' : '' }}>Dad Jokes</option>
                <option value="Dark Humor" {{ $post->category == 'Dark Humor' ? 'selected' : '' }}>Dark Humor</option>
                <option value="One-Liner Jokes" {{ $post->category == 'One-Liner Jokes' ? 'selected' : '' }}>One-Liner Jokes</option>
                <option value="Political Jokes" {{ $post->category == 'Political Jokes' ? 'selected' : '' }}>Political Jokes</option>
                <option value="Relationship Jokes" {{ $post->category == 'Relationship Jokes' ? 'selected' : '' }}>Relationship Jokes</option>
                <option value="Technology Jokes" {{ $post->category == 'Technology Jokes' ? 'selected' : '' }}>Technology Jokes</option>
                <option value="Workplace Jokes" {{ $post->category == 'Workplace Jokes' ? 'selected' : '' }}>Workplace Jokes</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="5" required>{{ $post->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@section('scripts')
    <!-- Load CKEditor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            CKEDITOR.replace('description');
        });
    </script>
@endsection
