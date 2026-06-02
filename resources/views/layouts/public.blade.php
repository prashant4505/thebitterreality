<!doctype html>
<html lang="{{ app()->getLocale() }}" x-data="{ menu: false, searchOpen: false, darkMode: true }" :class="darkMode ? 'dark' : ''" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seo['title'] ?? 'The Bitter Reality — Knowledge Library' }}</title>
    <meta name="description" content="{{ $seo['description'] ?? 'A premium documentary-style knowledge library. Explore history, science, civilizations, biographies, geopolitics and more.' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? 'history, science, civilization, biography, geopolitics, philosophy, knowledge' }}">
    <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">

    <meta property="og:title" content="{{ $seo['title'] ?? 'The Bitter Reality' }}">
    <meta property="og:description" content="{{ $seo['description'] ?? '' }}">
    <meta property="og:image" content="{{ $seo['image'] ?? asset('images/og-default.jpg') }}">
    <meta property="og:url" content="{{ $seo['canonical'] ?? url()->current() }}">
    <meta property="og:type" content="{{ $seo['type'] ?? 'website' }}">
    <meta name="twitter:card" content="summary_large_image">

    @foreach(($schemas ?? []) as $schema)
        <script type="application/ld+json">@json($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    @endforeach

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Georgia', serif; }
        nav, header, footer, .ui { font-family: Inter, ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#02030a] text-slate-100 selection:bg-amber-400 selection:text-black">

{{-- Deep space background --}}
<div class="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_left,rgba(120,80,20,.18),transparent_40%),radial-gradient(ellipse_at_80%_15%,rgba(16,80,120,.15),transparent_35%),linear-gradient(180deg,#01020a,#060810_50%,#01020a)]"></div>
<div class="pointer-events-none fixed inset-0 -z-10 opacity-[.04]" style="background-image:linear-gradient(rgba(255,255,255,.5) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.5) 1px,transparent 1px);background-size:60px 60px"></div>

{{-- ═══ HEADER ═══════════════════════════════════════════════════ --}}
<header class="ui sticky top-0 z-50 border-b border-white/8 bg-[#02030a]/80 backdrop-blur-xl">
    <div class="container-page flex h-16 items-center justify-between gap-4">

        {{-- Logo --}}
        <a href="{{ app()->getLocale() === 'hi' ? route('hi.home') : route('home') }}" class="flex items-center gap-2 font-bold tracking-wide text-white" style="font-family:Inter,sans-serif">
            <span class="text-lg font-black tracking-[.15em]">THE</span><span class="text-amber-400 font-black tracking-[.15em]">BITTER</span><span class="text-slate-400 font-black tracking-[.15em]">REALITY</span>
        </a>

        {{-- Desktop Nav --}}
        <nav class="hidden items-center gap-1 lg:flex" style="font-family:Inter,sans-serif">
            @php $locale = app()->getLocale(); @endphp
            <a href="{{ $locale === 'hi' ? route('hi.topics.index') : route('topics.index') }}" class="rounded-lg px-4 py-2 text-xs font-bold uppercase tracking-widest text-slate-300 transition hover:bg-white/5 hover:text-amber-300">Topics</a>
            <a href="{{ $locale === 'hi' ? route('hi.figures.index') : route('figures.index') }}" class="rounded-lg px-4 py-2 text-xs font-bold uppercase tracking-widest text-slate-300 transition hover:bg-white/5 hover:text-amber-300">Figures</a>
            <a href="{{ $locale === 'hi' ? route('hi.trending') : route('trending') }}" class="rounded-lg px-4 py-2 text-xs font-bold uppercase tracking-widest text-slate-300 transition hover:bg-white/5 hover:text-amber-300">Trending</a>
            <a href="{{ $locale === 'hi' ? route('hi.search') : route('search') }}" class="rounded-lg px-4 py-2 text-xs font-bold uppercase tracking-widest text-slate-300 transition hover:bg-white/5 hover:text-amber-300">Search</a>
        </nav>

        {{-- Right controls --}}
        <div class="flex items-center gap-2">
            {{-- Language Switcher --}}
            @php
                $currentLocale = app()->getLocale();
                $currentPath = request()->path();
                $enPath = $currentLocale === 'hi' ? preg_replace('#^hi/?#', '', $currentPath) : $currentPath;
                $hiPath = $currentLocale === 'en' ? 'hi/' . $currentPath : $currentPath;
            @endphp
            <div class="flex items-center rounded-full border border-white/10 bg-white/5 p-0.5" style="font-family:Inter,sans-serif">
                <a href="/{{ $enPath }}" class="rounded-full px-3 py-1.5 text-xs font-bold transition {{ $currentLocale === 'en' ? 'bg-amber-400 text-black' : 'text-slate-400 hover:text-white' }}">EN</a>
                <a href="/hi/{{ $enPath }}" class="rounded-full px-3 py-1.5 text-xs font-bold transition {{ $currentLocale === 'hi' ? 'bg-amber-400 text-black' : 'text-slate-400 hover:text-white' }}">HI</a>
            </div>

            {{-- Search icon --}}
            <button x-on:click="searchOpen = !searchOpen" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/5 text-slate-400 transition hover:border-amber-400/40 hover:text-amber-300">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </button>

            {{-- Mobile menu --}}
            <button class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/5 text-slate-400 lg:hidden" x-on:click="menu = !menu">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    {{-- Search bar --}}
    <div x-show="searchOpen" x-cloak x-transition class="border-t border-white/5 bg-[#02030a]/95">
        <div class="container-page py-4">
            <form action="{{ $locale === 'hi' ? route('hi.search') : route('search') }}" class="flex gap-3">
                <input class="input flex-1" name="q" placeholder="Search topics, historical figures, events..." autofocus value="{{ request('q') }}">
                <button type="submit" class="btn-primary px-5 py-3">Search</button>
            </form>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="menu" x-cloak class="border-t border-white/5 lg:hidden" style="font-family:Inter,sans-serif">
        <div class="container-page py-4">
            <div class="grid gap-1 rounded-2xl border border-white/8 bg-white/4 p-4">
                <a href="{{ $locale === 'hi' ? route('hi.topics.index') : route('topics.index') }}" class="rounded-xl px-4 py-3 text-sm font-semibold text-slate-300 hover:bg-white/5 hover:text-amber-300">Topics</a>
                <a href="{{ $locale === 'hi' ? route('hi.figures.index') : route('figures.index') }}" class="rounded-xl px-4 py-3 text-sm font-semibold text-slate-300 hover:bg-white/5 hover:text-amber-300">Historical Figures</a>
                <a href="{{ $locale === 'hi' ? route('hi.trending') : route('trending') }}" class="rounded-xl px-4 py-3 text-sm font-semibold text-slate-300 hover:bg-white/5 hover:text-amber-300">Trending</a>
                <a href="{{ $locale === 'hi' ? route('hi.search') : route('search') }}" class="rounded-xl px-4 py-3 text-sm font-semibold text-slate-300 hover:bg-white/5 hover:text-amber-300">Search</a>
            </div>
        </div>
    </div>
</header>

{{-- ═══ MAIN ════════════════════════════════════════════════════ --}}
<main>@yield('content')</main>

{{-- ═══ FOOTER ════════════════════════════════════════════════════ --}}
<footer class="border-t border-white/8 bg-black/40 py-16" style="font-family:Inter,sans-serif">
    <div class="container-page">
        <div class="grid gap-12 md:grid-cols-[1.6fr_1fr_1fr_1fr]">
            <div>
                <p class="text-xl font-black tracking-[.15em]">THE BITTER REALITY</p>
                <p class="mt-4 max-w-sm text-sm leading-7 text-slate-500">A premium documentary-style knowledge library. Every topic tells the complete story — what happened, why it happened, and what it means today.</p>
                <div class="mt-6 flex gap-3">
                    <div class="flex rounded-full border border-white/8 bg-white/4 p-0.5">
                        <a href="{{ request()->is('hi*') ? '/' . ltrim(request()->path(), 'hi/') : request()->path() }}" class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ app()->getLocale() === 'en' ? 'bg-amber-400 text-black' : 'text-slate-400 hover:text-white' }}">English</a>
                        <a href="/hi/{{ ltrim(request()->is('hi*') ? ltrim(request()->path(), 'hi/') : request()->path(), '/') }}" class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ app()->getLocale() === 'hi' ? 'bg-amber-400 text-black' : 'text-slate-400 hover:text-white' }}">हिंदी</a>
                    </div>
                </div>
            </div>

            <div>
                <p class="mb-4 text-xs font-black uppercase tracking-[.3em] text-amber-400">Explore</p>
                <div class="grid gap-2 text-sm text-slate-400">
                    <a href="{{ app()->getLocale() === 'hi' ? route('hi.topics.index') : route('topics.index') }}" class="hover:text-amber-300 transition">All Topics</a>
                    <a href="{{ app()->getLocale() === 'hi' ? route('hi.figures.index') : route('figures.index') }}" class="hover:text-amber-300 transition">Historical Figures</a>
                    <a href="{{ app()->getLocale() === 'hi' ? route('hi.trending') : route('trending') }}" class="hover:text-amber-300 transition">Trending</a>
                    <a href="{{ app()->getLocale() === 'hi' ? route('hi.latest') : route('latest') }}" class="hover:text-amber-300 transition">Latest Research</a>
                </div>
            </div>

            <div>
                <p class="mb-4 text-xs font-black uppercase tracking-[.3em] text-amber-400">Platform</p>
                <div class="grid gap-2 text-sm text-slate-400">
                    <a href="{{ route('page.show', 'about-us') }}" class="hover:text-amber-300 transition">About</a>
                    <a href="{{ route('page.show', 'contact-us') }}" class="hover:text-amber-300 transition">Contact</a>
                    <a href="{{ route('page.show', 'privacy-policy') }}" class="hover:text-amber-300 transition">Privacy</a>
                    <a href="{{ route('page.show', 'disclaimer') }}" class="hover:text-amber-300 transition">Disclaimer</a>
                </div>
            </div>

            <div>
                <p class="mb-4 text-xs font-black uppercase tracking-[.3em] text-amber-400">System</p>
                <div class="grid gap-2 text-sm text-slate-400">
                    <a href="{{ route('sitemap.page') }}" class="hover:text-amber-300 transition">Sitemap</a>
                    <a href="{{ route('sitemap.xml') }}" class="hover:text-amber-300 transition">XML Sitemap</a>
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-300 transition">Admin</a>
                </div>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/6 pt-8 text-xs text-slate-600 sm:flex-row">
            <p>© {{ date('Y') }} The Bitter Reality. All rights reserved.</p>
            <p>Knowledge that stays with you.</p>
        </div>
    </div>
</footer>

</body>
</html>
