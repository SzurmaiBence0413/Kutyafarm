<?php

use App\Http\Controllers\BreedController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//endpoint
Route::get('/x', function(){
    return 'API';
});


//region users
//User kezelés, login, logout
//Mindenki
Route::post('users/login', [UserController::class, 'login']);
Route::post('users/logout', [UserController::class, 'logout']);
Route::post('users', [UserController::class, 'store']);

//Admin:
//minden user lekérdezése
Route::get('users', [UserController::class, 'index'])
    ->middleware('auth:sanctum', 'ability:admin');
//Egy user lekérése
Route::get('users/{id}', [UserController::class, 'show'])
    ->middleware('auth:sanctum', 'ability:admin');
//User adatok módosítása
Route::patch('users/{id}', [UserController::class, 'update'])
->middleware('auth:sanctum', 'ability:admin');
//User törlés
Route::delete('users/{id}', [UserController::class, 'destroy'])
->middleware('auth:sanctum', 'ability:admin');

//User self (Amit a user önmagával csinálhat) parancsok
Route::delete('usersme', [UserController::class, 'destroySelf'])
->middleware('auth:sanctum', 'ability:usersme:delete');

Route::patch('usersme', [UserController::class, 'updateSelf'])
->middleware('auth:sanctum', 'ability:usersme:patch');

Route::patch('usersmeupdatepassword', [UserController::class, 'updatePassword'])
->middleware('auth:sanctum', 'ability:usersme:updatePassword');

Route::get('usersme', [UserController::class, 'indexSelf'])
    ->middleware('auth:sanctum', 'ability:usersme:get');
//endregion

//region Dogs
Route::get('dogs', [DogController::class, 'index']);
Route::get('dogs/{id}', [DogController::class, 'show']);
Route::post('dogs', [DogController::class, 'store'])
    ->middleware(['auth:sanctum', 'ability:dogs:post']);
Route::patch('dogs/{id}', [DogController::class, 'update'])
    ->middleware(['auth:sanctum','ability:dogs:patch']);
Route::delete('dogs/{id}', [DogController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'ability:dogs:delete']);
//endregion

//region Breeds
Route::get('breeds', [BreedController::class, 'index']);
Route::get('breeds/{id}', [BreedController::class, 'show']);
Route::post('breeds', [BreedController::class, 'store'])
    ->middleware(['auth:sanctum', 'ability:breeds:post']);
Route::patch('breeds/{id}', [BreedController::class, 'update'])
    ->middleware(['auth:sanctum','ability:breeds:patch']);
Route::delete('breeds/{id}', [BreedController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'ability:breeds:delete']);

//endregion

//region Colors
Route::get('colors', [ColorController::class, 'index']);
Route::get('colors/{id}', [ColorController::class, 'show']);
Route::post('colors', [ColorController::class, 'store'])
    ->middleware(['auth:sanctum', 'ability:colors:post']);
Route::patch('colors/{id}', [ColorController::class, 'update'])
    ->middleware(['auth:sanctum','ability:colors:patch']);
Route::delete('colors/{id}', [ColorController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'ability:colors:delete']);
//endregion
