<a href="{{ $topic->routeUrl() }}" class="knowledge-card group overflow-hidden flex flex-col">
    @if($topic->featured_image)
    <div class="h-44 overflow-hidden">
        <img src="{{ $topic->imageUrl() }}" alt="{{ $topic->title() }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
    </div>
    @endif
    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center gap-2 flex-wrap">
            @if($topic->category)
            <span class="text-xs font-bold uppercase tracking-widest" style="color:{{ $topic->category->accent_color ?? '#f59e0b' }}">{{ $topic->category->name() }}</span>
            @endif
            @if(isset($index))
            <span class="ml-auto text-xs font-black text-slate-700">#{{ $index }}</span>
            @endif
        </div>
        <h3 class="mt-2 font-bold leading-snug text-white transition group-hover:text-amber-300 line-clamp-2">{{ $topic->title() }}</h3>
        @if($topic->excerpt())
        <p class="mt-2 text-xs leading-5 text-slate-500 line-clamp-2 flex-1">{{ $topic->excerpt() }}</p>
        @endif
        <div class="mt-4 flex items-center gap-3 text-xs text-slate-600">
            @if($topic->era) <span class="text-amber-700">{{ $topic->era }}</span> @endif
            <span class="ml-auto">{{ $topic->reading_time }}m read</span>
        </div>
    </div>
</a>
