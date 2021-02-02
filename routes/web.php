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

Route::get('/', function() {
    return Inertia\Inertia::render('Levels/Index');
})->name('home');

Route::get('/formations', 'App\Http\Controllers\LevelController@index')->name('levels.index');
Route::get('/formation/{uuid}', 'App\Http\Controllers\ChapterController@index')->name('chapters.index');
Route::get('/chapitre/{uuid}', 'App\Http\Controllers\CourseController@index')->name('courses.index');

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/profils', 'App\Http\Controllers\ProfileController@index')->name('profiles.index');
    Route::post('/profils/select', 'App\Http\Controllers\ProfileController@select')->name('profiles.select');
    Route::post('/profils/edit', 'App\Http\Controllers\ProfileController@edit')->name('profiles.edit');
    Route::post('/profils/create', 'App\Http\Controllers\ProfileController@create')->name('profiles.create');
    Route::post('/profils/delete', 'App\Http\Controllers\ProfileController@delete')->name('profiles.delete');

    Route::get('/cours/{uuid}', 'App\Http\Controllers\ContentController@index')->name('contents.index');

    Route::post('/completed/edit', 'App\Http\Controllers\ContentUserController@edit')->name('contentUser.edit');
    Route::post('/completed/delete', 'App\Http\Controllers\ContentUserController@delete')->name('contentUser.delete');

    Route::post('/stripe', 'App\Http\Controllers\StripeController@index')->name('stripe.index');
    Route::post('/stripe/buy', 'App\Http\Controllers\CourseController@buy')->name('course.buy');
});

Route::middleware(['auth', 'admin', 'verified'])->group(function() {
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard.index');
    Route::get('/api/dashboard/logs', 'App\Http\Controllers\DashboardController@logs')->name('dashboard.logs');
    Route::get('/api/dashboard/courses', 'App\Http\Controllers\DashboardController@courses')->name('dashboard.courses');
    Route::post('/api/dashboard/courses/edit', 'App\Http\Controllers\DashboardController@editCourse')->name('dashboard.editCourse');

    Route::post('/formation/store', 'App\Http\Controllers\LevelController@store')->name('levels.store');
    Route::post('/chapter/store', 'App\Http\Controllers\ChapterController@store')->name('chapters.store');
    Route::post('/course/store', 'App\Http\Controllers\CourseController@store')->name('courses.store');
    Route::post('/content/store', 'App\Http\Controllers\ContentController@store')->name('contents.store');
    Route::post('/resource/store', 'App\Http\Controllers\ResourceController@store')->name('resources.store');

    Route::post('/formation/delete', 'App\Http\Controllers\LevelController@delete')->name('levels.delete');
    Route::post('/chapter/delete', 'App\Http\Controllers\ChapterController@delete')->name('chapters.delete');
    Route::post('/course/delete', 'App\Http\Controllers\CourseController@delete')->name('courses.delete');
    Route::post('/content/delete', 'App\Http\Controllers\ContentController@delete')->name('contents.delete');
    Route::post('/resource/delete', 'App\Http\Controllers\ResourceController@delete')->name('resources.delete');

    Route::post('/formation/edit', 'App\Http\Controllers\LevelController@edit')->name('levels.edit');
    Route::post('/chapter/edit', 'App\Http\Controllers\ChapterController@edit')->name('chapters.edit');
    Route::post('/course/edit', 'App\Http\Controllers\CourseController@edit')->name('courses.edit');
    Route::post('/content/edit', 'App\Http\Controllers\ContentController@edit')->name('contents.edit');
    Route::post('/resource/edit', 'App\Http\Controllers\ResourceController@edit')->name('resources.edit');
});
