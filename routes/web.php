<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\RegisteredUserController;

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
| Custom Register Route (/kushal)
|--------------------------------------------------------------------------
*/

Route::get('/kushal', [RegisteredUserController::class, 'create'])->name('kushal.register');
Route::post('/kushal', [RegisteredUserController::class, 'store'])->name('kushal.store');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
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

    Route::get('/projects', [ProjectController::class, 'adminIndex'])->name('projects.index');

    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');

    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

});

/*
|--------------------------------------------------------------------------
| Redirect Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return redirect()->route('home');
});

/*
|--------------------------------------------------------------------------
| TEST CLOUDINARY ROUTE (REMOVE AFTER TESTING) test 
|--------------------------------------------------------------------------
*/


Route::get('/cloudinary-test', function () {
    try {
        $result = Cloudinary::uploadApi()->upload(
            'https://res.cloudinary.com/demo/image/upload/sample.jpg'
        );

        return response()->json([
            'success' => true,
            'message' => 'Cloudinary is working ✅',
            'url' => $result['secure_url'],
        ]);

    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => 'Cloudinary upload failed ❌',
            'error' => $e->getMessage(),
        ], 500);
    }
});

/*
|--------------------------------------------------------------------------
| TEST MAIL ROUTE (REMOVE AFTER TESTING)
test
|--------------------------------------------------------------------------
*/

Route::get('/test-mail', function () {

    Mail::raw('Test Email from Kushal Portfolio', function ($msg) {
        $msg->to('kushal.upr@gmail.com')
            ->from('hello@kushalghimire57.com.np', 'Kushal Portfolio')
            ->subject('TEST EMAIL');
    });

    return "Mail Sent ✅";
});

require __DIR__.'/auth.php';