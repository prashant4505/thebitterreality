@extends('layouts.public')

@section('content')

{{-- ═══ HERO ═══════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden">
    @if($figure->featured_image)
    <img src="{{ $figure->imageUrl() }}" alt="{{ $figure->name() }}" class="absolute inset-0 h-full w-full object-cover opacity-15">
    @endif
    <div class="absolute inset-0 bg-gradient-to-b from-[#02030a]/70 via-[#02030a]/85 to-[#02030a]"></div>

    <div class="container-page relative z-10 py-20">
        <nav class="mb-6 flex items-center gap-2 text-xs text-slate-600" style="font-family:Inter,sans-serif">
            <a href="{{ app()->getLocale() === 'hi' ? route('hi.home') : route('home') }}" class="hover:text-amber-400 transition">Home</a>
            <span>/</span>
            <a href="{{ app()->getLocale() === 'hi' ? route('hi.figures.index') : route('figures.index') }}" class="hover:text-amber-400 transition">Figures</a>
            <span>/</span>
            <span class="text-slate-400">{{ $figure->name() }}</span>
        </nav>

        <div class="flex flex-col gap-8 lg:flex-row lg:items-end">
            @if($figure->featured_image)
            <div class="h-64 w-52 flex-shrink-0 overflow-hidden rounded-2xl border border-white/10 shadow-2xl">
                <img src="{{ $figure->imageUrl() }}" alt="{{ $figure->name() }}" class="h-full w-full object-cover">
            </div>
            @endif
            <div>
                @if($figure->era) <p class="kicker">{{ $figure->era }}</p> @endif
                <h1 class="page-title mt-3">{{ $figure->name() }}</h1>
                @if($figure->title()) <p class="mt-2 text-xl text-slate-400">{{ $figure->title() }}</p> @endif
                <div class="mt-4 flex flex-wrap gap-6 text-sm text-slate-600" style="font-family:Inter,sans-serif">
                    @if($figure->born) <span><strong class="text-slate-400">Born:</strong> {{ $figure->born }}</span> @endif
                    @if($figure->died) <span><strong class="text-slate-400">Died:</strong> {{ $figure->died }}</span> @endif
                    @if($figure->region) <span><strong class="text-slate-400">Region:</strong> {{ $figure->region }}</span> @endif
                    @if($figure->category) <span><strong class="text-slate-400">Known as:</strong> {{ $figure->category }}</span> @endif
                </div>
                @if($figure->shortBio())
                <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-400">{{ $figure->shortBio() }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ═══ CONTENT ══════════════════════════════════════════════════ --}}
<div class="container-page py-12 lg:py-16">
    <div class="grid gap-10 lg:grid-cols-[1fr_280px]">

        <div>
            {{-- Full Biography --}}
            @if($figure->fullBio())
            <div class="mb-12">
                <p class="kicker mb-6">Biography</p>
                <div class="prose-doc">{!! $figure->fullBio() !!}</div>
            </div>
            @endif

            {{-- Achievements --}}
            @if($figure->trans('achievements'))
            <div class="mb-12">
                <p class="kicker mb-6">Key Achievements</p>
                <div class="prose-doc">{!! $figure->trans('achievements') !!}</div>
            </div>
            @endif

            {{-- Quotes --}}
            @if($figure->quotes())
            <div class="mb-12">
                <p class="kicker mb-6">Notable Quotes</p>
                <div class="space-y-6">
                    @foreach($figure->quotes() as $quote)
                    <div class="pull-quote">
                        <p class="text-xl font-bold italic text-amber-100 leading-8">"{{ $quote }}"</p>
                        <p class="mt-3 text-sm font-bold uppercase tracking-widest text-amber-500">— {{ $figure->name() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Related Topics --}}
            @if($figure->topics->isNotEmpty())
            <div class="mt-12 border-t border-white/8 pt-10">
                <p class="kicker mb-6">Related Topics</p>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach($figure->topics as $topic)
                    @include('public.partials.topic-card', ['topic' => $topic])
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <aside>
            <div class="sticky top-24 space-y-6" style="font-family:Inter,sans-serif">
                <div class="rounded-2xl border border-white/8 bg-white/[.03] p-5">
                    <p class="mb-4 text-xs font-black uppercase tracking-widest text-amber-400">Quick Facts</p>
                    <div class="space-y-3 text-sm">
                        @if($figure->born) <div class="flex justify-between"><span class="text-slate-600">Born</span><span class="text-slate-300">{{ $figure->born }}</span></div> @endif
                        @if($figure->died) <div class="flex justify-between"><span class="text-slate-600">Died</span><span class="text-slate-300">{{ $figure->died }}</span></div> @endif
                        @if($figure->era) <div class="flex justify-between"><span class="text-slate-600">Era</span><span class="text-slate-300">{{ $figure->era }}</span></div> @endif
                        @if($figure->region) <div class="flex justify-between"><span class="text-slate-600">Region</span><span class="text-slate-300">{{ $figure->region }}</span></div> @endif
                        @if($figure->category) <div class="flex justify-between"><span class="text-slate-600">Category</span><span class="text-slate-300">{{ $figure->category }}</span></div> @endif
                        <div class="flex justify-between"><span class="text-slate-600">Views</span><span class="text-slate-300">{{ number_format($figure->view_count) }}</span></div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
