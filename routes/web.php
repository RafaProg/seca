<?php
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

Auth::routes(['register' => false]);

Route::get('/painel', 'HomeController@index')->name('painel');

Route::namespace('Classroom')->middleware('auth')->prefix('classrooms')->group(function () {
    Route::name('classroom.')->group(function () {
        Route::resource('/', 'ClassroomController');
        Route::get('/config-release', 'ClassroomController@showConfigReleaseClassroom')->name('config-release');
        Route::put('/classrooms/config-release-update', 'ClassroomController@updateRelease')->name('config-release-update');
        Route::get('/config-internship', 'ClassroomController@showConfigInternship')->name('config-internship');
        Route::post('/store-config-internship', 'ClassroomController@storeConfigInternship')->name('store-config-internship');
        Route::get('/clear-config-internship', 'ClassroomController@clearConfigInternship')->name('clear-config-internship');
    });
});

Route::namespace('Release')->middleware(['auth', 'can:isControllerOrAdmin,App\User'])->prefix('release-times')->group(function () {
    Route::name('releasetime.')->group(function () {
        Route::get('/', 'ReleaseTimeController@createReleaseTime')->name('config-time');
        Route::post('/add-release-time', 'ReleaseTimeController@storeReleaseTime')->name('store-time');
        Route::post('/interval-between-release', 'ReleaseTimeController@storeBetweenRelease')->name('store-betweenrelese');
        Route::delete('/delete-release-time/{id}', 'ReleaseTimeController@deleteReleaseTime')->name('delete-time');
    });
});

Route::namespace('User')->middleware('auth')->prefix('users')->group(function () {
    Route::name('user.')->group(function () {
        Route::get('/', 'UserController@index')->name('index');

        Route::middleware('can:isControllerOrAdmin,App\User')->group(function () {
            Route::get('/create', 'UserController@create')->name('create');
            Route::post('/create', 'UserController@store')->name('store');
            Route::get('/{user}/edit', 'UserController@edit')->name('edit');
            Route::put('/{user}/edit', 'UserController@update')->name('update');
            Route::delete('/delete/{id}', 'UserController@destroy')->name('delete');
        });
    });
});

Route::get('/teste', function () {
    $view = view('classroom.index');
    dd((string) $view);
});
