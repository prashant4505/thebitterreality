@extends('layouts.public')

@section('content')
<section class="container-page py-16">
    <div class="mb-10">
        <p class="kicker">Knowledge Library</p>
        <h1 class="section-title mt-2">{{ $pageTitle ?? 'All Topics' }}</h1>
    </div>

    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @forelse($topics as $topic)
            @include('public.partials.topic-card', ['topic' => $topic])
        @empty
        <div class="col-span-full py-20 text-center text-slate-600">No topics found.</div>
        @endforelse
    </div>

    <div class="mt-10">{{ $topics->links() }}</div>
</section>
@endsection
