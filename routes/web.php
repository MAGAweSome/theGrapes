<?php

use App\Models\Show;
use App\Models\SocialLink;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $today = Carbon::today();

    return view('welcome', [
        'upcomingShows' => Show::query()
            ->where('is_published', true)
            ->whereDate('event_date', '>=', $today)
            ->orderBy('event_date')
            ->orderBy('event_time')
            ->limit(3)
            ->get(),
        'featuredShow' => Show::query()
            ->where('is_published', true)
            ->whereDate('event_date', '>=', $today)
            ->orderByDesc('is_featured')
            ->orderBy('event_date')
            ->orderBy('event_time')
            ->first(),
        'socialLinks' => SocialLink::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('platform')
            ->get(),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
