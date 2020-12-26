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

Route::get('/formations', 'App\Http\Controllers\LevelController@index')->name('levels.index');

Route::group(['auth:sanctum', 'verified'], function () {
    Route::get('/dashboard', function() {
        return Inertia\Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/formation/{uuid}', 'App\Http\Controllers\ChapterController@index')->name('chapters.index');
    Route::get('/chapter/{uuid}', 'App\Http\Controllers\CourseController@index')->name('courses.index');
    Route::get('/course/{uuid}', 'App\Http\Controllers\ContentController@index')->name('contents.index');

    // TODO : Add middleware for Admin
    Route::post('/formations', 'App\Http\Controllers\LevelController@store')->name('levels.store');
    Route::post('/chapters', 'App\Http\Controllers\ChapterController@store')->name('chapters.store');
    Route::post('/courses', 'App\Http\Controllers\CourseController@store')->name('courses.store');
    Route::post('/contents', 'App\Http\Controllers\ContentController@store')->name('contents.store');

    Route::post('/formation/delete', 'App\Http\Controllers\LevelController@delete')->name('levels.delete');
    Route::post('/chapter/delete', 'App\Http\Controllers\ChapterController@delete')->name('chapters.delete');
    Route::post('/course/delete', 'App\Http\Controllers\CourseController@delete')->name('courses.delete');
    Route::post('/content/delete', 'App\Http\Controllers\ContentController@delete')->name('contents.delete');
});
