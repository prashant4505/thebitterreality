@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Post a Deep Thought</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('deep-thoughts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Post Thought</button>
    </form>
</div>
@endsection
