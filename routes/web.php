<?php

use App\Mail\BookingEnquiryReceived;
use App\Models\SiteSetting;
use App\Models\Show;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $today = Carbon::today();

    return view('welcome', [
        'bookingEmail' => SiteSetting::valueFor('booking_email', config('services.booking_email')),
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

Route::post('/booking-enquiry', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:120'],
        'email' => ['required', 'email', 'max:255'],
        'event_date' => ['required', 'date'],
        'venue' => ['required', 'string', 'max:160'],
        'details' => ['required', 'string', 'max:2000'],
    ]);

    $bookingEmail = SiteSetting::valueFor('booking_email', config('services.booking_email'));

    if (! filled($bookingEmail)) {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => __('The booking email address is not configured yet.'),
            ], 422);
        }

        return back()
            ->withInput()
            ->withErrors(['booking' => __('The booking email address is not configured yet.')]);
    }

    try {
        Mail::to($bookingEmail)->send(new BookingEnquiryReceived($validated));
    } catch (\Throwable $exception) {
        report($exception);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => __('We could not send your enquiry right now. Please try again once the local mail server is running.'),
            ], 500);
        }

        return back()
            ->withInput()
            ->withErrors(['booking' => __('We could not send your enquiry right now. Please try again once the local mail server is running.')]);
    }

    if ($request->expectsJson()) {
        return response()->json([
            'message' => __('Thanks. Your enquiry has been sent.'),
        ]);
    }

    return back()->with('status', __('Thanks. Your enquiry has been sent.'));
})->name('booking-enquiry.send');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';


use App\Http\Controllers\Auth\AcceptInviteController;
use App\Livewire\Dashboard\InviteUser;
use Illuminate\Support\Str;
use App\Models\UserInvite;
use App\Mail\UserInvitationMail;

Route::get('/register/invite/{token}', [AcceptInviteController::class, 'show'])->name('register.invite');
Route::post('/register/invite/{token}', [AcceptInviteController::class, 'store'])->name('register.invite.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/invite', InviteUser::class)->name('dashboard.invite');
});

Route::get('/first-time-invite', function () {
    $emails = ['marcus@matrek.com']; // Hardcoded emails
    $results = [];
    foreach ($emails as $email) {
        $invite = UserInvite::updateOrCreate(
            ['email' => $email],
            ['token' => Str::random(60)]
        );
        try {
            Mail::to($email)->send(new UserInvitationMail($invite));
            $results[] = 'Invite sent to ' . $email . ' successfully!';
        } catch (\Exception $e) {
            $results[] = 'Failed to send to ' . $email . ': ' . $e->getMessage();
        }
    }
    return '<h2>First Time Invites</h2><ul><li>' . implode('</li><li>', $results) . '</li></ul>';
});

use App\Http\Controllers\SiteEditorController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/editor', [SiteEditorController::class, 'index'])->name('dashboard.editor');
    Route::get('/dashboard/editor/load', [SiteEditorController::class, 'load'])->name('dashboard.editor.load');
    Route::post('/dashboard/editor/save', [SiteEditorController::class, 'store'])->name('dashboard.editor.save');
});
