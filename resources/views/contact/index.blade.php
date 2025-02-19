@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Contact Messages</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Submission Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $message)
                <tr>
                    <td>{{ $message->id }}</td>
                    <td>{{ $message->name }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ $message->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <a href="{{ route('contact.showDetails', $message->id) }}" class="btn btn-primary btn-sm">Show</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $messages->links() }}
</div>
@endsection
