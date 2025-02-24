@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Deep Thoughts</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($thoughts as $thought)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $thought->title }}</h5>
                <p class="card-text">{{ $thought->content }}</p>
                <small>
                    Posted by <strong>{{ $thought->user->name ?? 'Unknown' }}</strong>
                    on {{ $thought->created_at->format('d M, Y') }}
                </small>

                @if(Auth::id() === $thought->user_id)
                    <div class="mt-3">
                        <a href="{{ route('deep-thoughts.edit', $thought->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('deep-thoughts.destroy', $thought->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
