@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Contact Message Details</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $message->name }}</h5>
            <p><strong>Email:</strong> {{ $message->email }}</p>
            <p><strong>Message:</strong> {{ $message->description }}</p>
            <p><strong>Submitted On:</strong> {{ $message->created_at->format('d M Y H:i') }}</p>
            <a href="{{ route('contact.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
