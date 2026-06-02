<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('articles:publish-scheduled', function () {
    $count = \App\Models\Article::where('status', 'scheduled')
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
        ->update(['status' => 'published']);

    Cache::flush();
    $this->info("Published {$count} scheduled articles.");
})->purpose('Publish scheduled articles');

Schedule::command('articles:publish-scheduled')->everyMinute();
