<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — The Bitter Reality</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/admin-editor.js'])
    <style>
        /* Tab panels: English shown by default, Hindi hidden */
        .ck-tab-panel          { display: block; }
        .ck-tab-panel.hidden   { display: none; }
        /* Active tab button state */
        .ck-tab-btn.active     { background: #fbbf24; color: #000; }
        /* CKEditor 5 sizing + content typography (mirrors the old contentsCss) */
        .ck-editor__editable_inline   { min-height: 380px; }
        .ck-content                   { font-family: Georgia, serif; font-size: 16px; line-height: 1.85; }
        /* Image preview */
        .img-preview           { max-height: 160px; object-fit: cover; border-radius: .75rem; }
    </style>
</head>
<body class="bg-[#02030a] text-slate-100" style="font-family:Inter,ui-sans-serif,system-ui,sans-serif" data-upload-url="{{ route('admin.upload-image') }}">
<div class="flex min-h-screen">

    {{-- ─── Sidebar ──────────────────────────────────────── --}}
    <aside class="fixed inset-y-0 left-0 z-40 w-56 border-r border-white/8 bg-black/60 backdrop-blur-xl">
        <div class="flex h-16 items-center px-5 border-b border-white/8">
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-black tracking-widest text-white">TBR <span class="text-amber-400">ADMIN</span></a>
        </div>
        <nav class="space-y-0.5 p-3 text-sm">
            @php $r = request()->route()->getName(); @endphp
            @foreach([
                ['admin.dashboard', route('admin.dashboard'), 'Dashboard', '◈'],
                ['admin.topics',    route('admin.topics.index'),     'Topics',      '📖'],
                ['admin.figures',   route('admin.figures.index'),    'Figures',     '👤'],
                ['admin.timelines', route('admin.timelines.index'),  'Timelines',   '📅'],
                ['admin.categories',route('admin.categories.index'), 'Categories',  '🗂'],
                ['admin.tags',      route('admin.tags.index'),       'Tags',        '🏷'],
                ['admin.comments',  route('admin.comments.index'),   'Comments',    '💬'],
                ['admin.pages',     route('admin.pages.index'),      'Pages',       '📄'],
            ] as [$name, $url, $label, $icon])
            <a href="{{ $url }}"
               class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 font-medium transition
                      {{ str_starts_with($r, $name) ? 'bg-amber-950/50 text-amber-300' : 'text-slate-400 hover:bg-white/4 hover:text-white' }}">
                <span class="text-base">{{ $icon }}</span>{{ $label }}
            </a>
            @endforeach
        </nav>
        <div class="absolute bottom-0 left-0 right-0 border-t border-white/8 p-3 space-y-1">
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-sm text-slate-600 hover:text-slate-400 transition">↗ View Site</a>
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm text-slate-600 hover:text-rose-400 transition">⏏ Logout</button>
            </form>
        </div>
    </aside>

    {{-- ─── Main ────────────────────────────────────────── --}}
    <div class="ml-56 flex-1">
        <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-white/8 bg-[#02030a]/90 px-8 backdrop-blur-xl">
            <h1 class="text-sm font-bold text-slate-400">@yield('heading', 'Dashboard')</h1>
            <span class="text-xs text-slate-600">{{ auth()->user()?->email }}</span>
        </header>

        <main class="px-8 py-8">
            @foreach(['success', 'error', 'warning'] as $type)
            @if(session($type))
            <div class="mb-6 rounded-2xl border p-4 text-sm font-medium
                {{ $type === 'success' ? 'border-emerald-400/30 bg-emerald-950/25 text-emerald-300'
                 : ($type === 'error'  ? 'border-rose-400/30 bg-rose-950/25 text-rose-300'
                 :                      'border-amber-400/30 bg-amber-950/25 text-amber-300') }}">
                {{ session($type) }}
            </div>
            @endif
            @endforeach

            @yield('content')
        </main>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     Language tab system — no Alpine dependency, runs on DOMContentLoaded.
     (CKEditor 5 is initialised separately by resources/js/admin-editor.js —
     it edits an in-DOM contenteditable, not an iframe, so it doesn't need
     a resize pass when its tab panel becomes visible.)
═══════════════════════════════════════════════════════════════ --}}
<script>
(function () {

    function initTabs() {
        document.querySelectorAll('.ck-tab-bar').forEach(function (bar) {
            bar.querySelectorAll('.ck-tab-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var targetLang = this.dataset.lang;
                    var form       = this.closest('.ck-tabbed-form');
                    if (!form) return;

                    // Update button states
                    bar.querySelectorAll('.ck-tab-btn').forEach(function (b) {
                        b.classList.toggle('active', b.dataset.lang === targetLang);
                    });

                    // Show/hide panels
                    form.querySelectorAll('.ck-tab-panel').forEach(function (panel) {
                        panel.classList.toggle('hidden', panel.dataset.lang !== targetLang);
                    });
                });
            });
        });
    }

    document.addEventListener('DOMContentLoaded', initTabs);

    /* ── Image file-input live preview ─────────────────────────── */
    window.previewImage = function (input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = document.getElementById(previewId);
                if (img) { img.src = e.target.result; img.classList.remove('hidden'); }
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

})();
</script>
</body>
</html>
