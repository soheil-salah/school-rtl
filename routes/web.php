<?php

use App\Http\Controllers\BoardMemberController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Backend\SendInqueryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AppController::class, 'index'])->name('index');

Route::get('/about', [AppController::class, 'about'])->name('about');

Route::get('/galleries', [AppController::class, 'galleries'])->name('galleries');
Route::get('/gallery/{slug}', [AppController::class, 'gallery'])->name('gallery');

Route::get('/board-members', [BoardMemberController::class, 'index'])->name('board-members');
Route::get('/board-member/show/{slug}', [BoardMemberController::class, 'show'])->name('board-member.show');

Route::get('/contact', [AppController::class, 'contact'])->name('contact');

Route::get('/admission', [AppController::class, 'admission'])->name('admission');
Route::post('/send-admission', [AppController::class, 'sendAdmission'])->name('send-admission');

Route::get("/terms",[AppController::class, 'terms'])->name('terms');

Route::get('/policy',[AppController::class, 'policy'])->name('policy');

// ajax post to send inquery
Route::post('/send-inquery', [SendInqueryController::class, 'send'])->name('send-inquery');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
