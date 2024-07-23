<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CreatePost;
use App\Livewire\PostShow;
use App\Livewire\UserShow;
use App\Livewire\FollowButton;


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
Route::get('/users/{id}', UserShow::class)->name('users.show');


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/create-post',CreatePost::class)->middleware(['auth', 'verified'])->name('create-post');
Route::get('/posts/{id}',PostShow::class)->name('posts.show');
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';


