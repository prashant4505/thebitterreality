@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Deep Thought</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('deep-thoughts.update', $thought->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $thought->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="4" required>{{ old('content', $thought->content) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('deep-thoughts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
