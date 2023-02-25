<?php

use App\Http\Middleware\CheckAuthentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//default route
Route::get('/', function () {
    return response()->json([
        'message' => 'Music-Album API',
    ]);
});

//user auth routes
Route::group(['prefix' => 'auth'], function () {
    Route::get('/user', [App\Http\Controllers\UserController::class, 'getUserData']);
    Route::post('/login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
    Route::post('/register', [App\Http\Controllers\UserController::class, 'registerUser']);
    Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout']);
});

Route::group(['middleware' => CheckAuthentication::class], function () {
    //albums routes
    Route::get('/albums', [App\Http\Controllers\AlbumController::class, 'getAlbums']);
    Route::get('/albums/{id}', [App\Http\Controllers\AlbumController::class, 'getAlbum']);
    Route::post('/albums', [App\Http\Controllers\AlbumController::class, 'createAlbum']);
    Route::patch('/albums/{id}', [App\Http\Controllers\AlbumController::class, 'updateAlbum']);
    Route::delete('/albums/{id}', [App\Http\Controllers\AlbumController::class, 'deleteAlbum']);
    
    //songs routes
    Route::get('/songs', [App\Http\Controllers\SongController::class, 'getSongs']);
    Route::get('/songs/{id}', [App\Http\Controllers\SongController::class, 'getSong']);
    Route::post('/songs', [App\Http\Controllers\SongController::class, 'createSong']);
    Route::patch('/songs/{id}', [App\Http\Controllers\SongController::class, 'updateSong']);
    Route::delete('/songs/{id}', [App\Http\Controllers\SongController::class, 'deleteSong']);
    
    Route::get('/songs/genres', [App\Http\Controllers\SongController::class, 'getGenres']);
    Route::get('/songs/{genre}', [App\Http\Controllers\SongController::class, 'getSongsByGenre']);
    
    Route::get('/albums/{id}/songs', [App\Http\Controllers\AlbumController::class, 'getAlbumSongs']);
});