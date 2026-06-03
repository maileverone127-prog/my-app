<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/contact', 'contact')->name('contact');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store')
    ->middleware('throttle:3,1');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/download-resume', function () {
    $path = public_path('resume.pdf');
    abort_if(!file_exists($path), 404);
    return response()->download($path, 'Kushal-Ghimire-Resume.pdf');
})->name('resume.download');

/*
|--------------------------------------------------------------------------
| Hidden Admin Registration (only route to create an account)
|--------------------------------------------------------------------------
*/

Route::get('/kushal', [RegisteredUserController::class, 'create'])->name('kushal.register');
Route::post('/kushal', [RegisteredUserController::class, 'store'])->name('kushal.store');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard.alt');

    // Mail test (admin only — remove after confirming mail works in production)
    Route::get('/test-mail', function () {
        $dummy = new \App\Models\Message([
            'id'      => 0,
            'name'    => 'Test Sender',
            'email'   => 'test@example.com',
            'message' => "This is a test email sent from the admin panel.\n\nIf you received this, your mail configuration is working correctly.",
        ]);
        $dummy->created_at = now();

        try {
            $recipient = config('mail.contact_recipient', config('mail.from.address'));
            \Illuminate\Support\Facades\Mail::to($recipient)
                ->send(new \App\Mail\NewContactMessage($dummy));
            return response()->json([
                'status'    => 'sent',
                'mailer'    => config('mail.default'),
                'recipient' => $recipient,
                'note'      => config('mail.default') === 'log'
                    ? 'Email written to storage/logs/laravel.log (log driver active)'
                    : 'Email sent successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'error'  => $e->getMessage(),
                'mailer' => config('mail.default'),
            ], 500);
        }
    })->name('admin.test-mail');

    // Projects
    Route::get('/projects', [ProjectController::class, 'adminIndex'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'adminShow'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Messages
    Route::get('/messages', [ContactController::class, 'adminIndex'])->name('messages.index');
    Route::get('/messages/{message}', [ContactController::class, 'adminShow'])->name('messages.show');
    Route::patch('/messages/{message}/read', [ContactController::class, 'markRead'])->name('messages.read');
    Route::patch('/messages/{message}/unread', [ContactController::class, 'markUnread'])->name('messages.unread');
    Route::delete('/messages/{message}', [ContactController::class, 'destroy'])->name('messages.destroy');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Backup & Restore
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/export/all', [BackupController::class, 'exportAll'])->name('backup.export.all');
    Route::get('/backup/export/{project}', [BackupController::class, 'exportSingle'])->name('backup.export.single');
    Route::post('/backup/import', [BackupController::class, 'import'])->name('backup.import');

});

/*
|--------------------------------------------------------------------------
| Redirect /dashboard → home (Breeze default redirect override)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return redirect()->route('home');
});

require __DIR__.'/auth.php';
