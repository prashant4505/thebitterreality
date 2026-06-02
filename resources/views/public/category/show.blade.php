@extends('layouts.public')

@section('content')
<section class="relative overflow-hidden border-b border-white/6 py-16">
    <div class="container-page">
        <nav class="mb-4 flex items-center gap-2 text-xs text-slate-600" style="font-family:Inter,sans-serif">
            <a href="{{ app()->getLocale() === 'hi' ? route('hi.home') : route('home') }}" class="hover:text-amber-400 transition">Home</a>
            <span>/</span>
            <span class="text-slate-400">{{ $category->name() }}</span>
        </nav>
        <p class="kicker">Category</p>
        <h1 class="section-title mt-3" style="border-left:3px solid {{ $category->accent_color }}; padding-left:1rem">{{ $category->name() }}</h1>
        @if($category->description())
        <p class="mt-4 max-w-2xl text-lg text-slate-500">{{ $category->description() }}</p>
        @endif
    </div>
</section>

<section class="container-page py-14">
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @forelse($topics as $topic)
            @include('public.partials.topic-card', ['topic' => $topic])
        @empty
        <div class="col-span-full py-16 text-center text-slate-600">No topics in this category yet.</div>
        @endforelse
    </div>
    <div class="mt-10">{{ $topics->links() }}</div>
</section>
@endsection
