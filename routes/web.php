<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Public\BookmarkController;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\CommentController;
use App\Http\Controllers\Public\FigureController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\SearchController;
use App\Http\Controllers\Public\SitemapController;
use App\Http\Controllers\Public\StaticPageController;
use App\Http\Controllers\Public\TopicController;
use Illuminate\Support\Facades\Route;

// ─── System ───────────────────────────────────────────────────
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [SitemapController::class, 'xml'])->name('sitemap.xml');

// ─── Admin (registered FIRST so /admin/* is never caught by public wildcards) ──
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:web')->group(function () {
        Route::get('/login', [Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [Admin\AuthController::class, 'login'])
            ->name('login.store')->middleware('throttle:5,1');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('/', Admin\DashboardController::class)->name('dashboard');
        Route::post('/upload-image', [Admin\ImageUploadController::class, 'store'])->name('upload-image');

        Route::resource('topics', Admin\TopicController::class);
        Route::resource('topics.chapters', Admin\ChapterController::class)->shallow();
        Route::resource('figures', Admin\FigureController::class);
        Route::resource('categories', Admin\CategoryController::class)->except('show');
        Route::resource('tags', Admin\TagController::class)->except('show');
        Route::resource('timelines', Admin\TimelineController::class)->except('show');
        Route::resource('timelines.entries', Admin\TimelineEntryController::class)->shallow()->except('show');
        Route::resource('pages', Admin\StaticPageController::class)->except('show');

        Route::prefix('comments')->name('comments.')->group(function () {
            Route::get('/', [Admin\CommentController::class, 'index'])->name('index');
            Route::patch('/{comment}/approve', [Admin\CommentController::class, 'approve'])->name('approve');
            Route::delete('/{comment}', [Admin\CommentController::class, 'destroy'])->name('destroy');
        });
    });
});

// ─── Bilingual public routes ─────────────────────────────────
// hi routes registered first so /hi/* is never caught by the en wildcard
foreach (['hi' => '/hi', 'en' => ''] as $locale => $prefix) {
    $p = $locale === 'en' ? '' : 'hi.';

    Route::middleware(\App\Http\Middleware\SetLocale::class . ':' . $locale)
        ->prefix($prefix)
        ->group(function () use ($p) {

            Route::get('/', HomeController::class)->name("{$p}home");

            Route::get('/topics', [TopicController::class, 'index'])->name("{$p}topics.index");

            Route::get('/figures', [FigureController::class, 'index'])->name("{$p}figures.index");
            Route::get('/figures/{slug}', [FigureController::class, 'show'])->name("{$p}figure.show");

            Route::get('/category/{slug}', [CategoryController::class, 'show'])->name("{$p}category.show");

            Route::get('/search', [SearchController::class, 'index'])->name("{$p}search");
            Route::get('/search/suggestions', [SearchController::class, 'suggestions'])
                ->name("{$p}search.suggestions")->middleware('throttle:30,1');

            Route::get('/trending', [HomeController::class, 'trending'])->name("{$p}trending");
            Route::get('/latest', [HomeController::class, 'latest'])->name("{$p}latest");

            Route::get('/sitemap', [StaticPageController::class, 'sitemap'])->name("{$p}sitemap.page");
            Route::get('/page/{slug}', [StaticPageController::class, 'show'])->name("{$p}page.show");

            // Topic wildcard — must be last
            Route::get('/{category}/{slug}', [TopicController::class, 'show'])->name("{$p}topic.show");
            Route::post('/{category}/{slug}/comments', [CommentController::class, 'store'])
                ->name("{$p}comments.store")->middleware('throttle:4,1');
            Route::post('/{category}/{slug}/bookmark', [BookmarkController::class, 'toggle'])
                ->name("{$p}bookmark.toggle")->middleware('throttle:20,1');
        });
}
