<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\ChatMessageStatusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Index');
})->middleware(['auth'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users/find-all-by-simular-email', [UserController::class, 'findAllBySimularEmail'])->name('user.find-all-by-simular-email');
});

Route::group([
    'prefix'     => 'chats',
    'as'         => 'chats.',
    'controller' => ChatController::class,
    'middleware' => 'auth',
], function () {
    Route::post('', 'store')->name('store');
    Route::get('{id}', 'show')->name('show');
    Route::delete('{id}', 'destroy')->name('destroy');
});

Route::group([
    'prefix'     => 'chat-messages',
    'as'         => 'chat-messages.',
    'controller' => ChatMessageController::class,
    'middleware' => 'auth',
], function () {
    Route::post('', 'store')->name('store');
});

Route::group([
    'prefix'     => 'chat-message-statuses',
    'as'         => 'chat-message-statuses.',
    'controller' => ChatMessageStatusController::class,
    'middleware' => 'auth',
], function () {
    Route::post('make-chat-read', 'makeChatRead')->name('make-chat-read');
});

require __DIR__ . '/auth.php';
