<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/home/{folder?}', App\Livewire\Home::class)->name('home');
    Route::get('/document/view/{filename}', [DocumentController::class, 'view'])->name('document.view');
    Route::post('/upload', [DocumentController::class, 'upload'])->name('upload.docs');

    Route::get('/activity', App\Livewire\Activity::class)->name('activity');
    Route::group(['middleware' => ['role:Admin']], function(){
        Route::get('/addUser', App\Livewire\AddUser::class)->name('addUser');
    });

    Route::get('/userList', App\Livewire\UserList::class)->name('userList');

    Route::get('/passDocs', App\Livewire\passDocs::class)->name('passDocs');

    Route::get('/masterList', App\Livewire\masterList::class)->name('masterList');
    Route::post('/upload-masterlist', [DocumentController::class, 'uploadMasterlist'])->name('upload-masterlist');
});

