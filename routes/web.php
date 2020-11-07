<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/niveaux', 'App\Http\Controllers\LevelController@index')->name('levels.index');

Route::group(['auth:sanctum', 'verified'], function () {
    Route::get('/dashboard', function() {
        return Inertia\Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/niveau/{id}/chapitres', 'App\Http\Controllers\ChapterController@index')->name('chapters.index');
});
