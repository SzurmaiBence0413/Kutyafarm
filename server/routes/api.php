<?php

use App\Http\Controllers\BreedController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PhotoeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaccinationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//endpoint
Route::get('/x', function () {
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
    ->middleware(['auth:sanctum', 'ability:dogs:patch']);
Route::delete('dogs/{id}', [DogController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'ability:dogs:delete']);
//endregion

//region Breeds
Route::get('breeds', [BreedController::class, 'index']);
Route::get('breeds/{id}', [BreedController::class, 'show']);
Route::post('breeds', [BreedController::class, 'store'])
    ->middleware(['auth:sanctum', 'ability:breeds:post']);
Route::patch('breeds/{id}', [BreedController::class, 'update'])
    ->middleware(['auth:sanctum', 'ability:breeds:patch']);
Route::delete('breeds/{id}', [BreedController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'ability:breeds:delete']);

//endregion

//region Colors
Route::get('colors', [ColorController::class, 'index']);
Route::get('colors/{id}', [ColorController::class, 'show']);
Route::post('colors', [ColorController::class, 'store'])
    ->middleware(['auth:sanctum', 'ability:colors:post']);
Route::patch('colors/{id}', [ColorController::class, 'update'])
    ->middleware(['auth:sanctum', 'ability:colors:patch']);
Route::delete('colors/{id}', [ColorController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'ability:colors:delete']);
//endregion

//region Medicines
Route::get('medicines', [MedicineController::class, 'index']);
Route::get('medicines/{id}', [MedicineController::class, 'show']);
Route::post('medicines', [MedicineController::class, 'store'])
    ->middleware(['auth:sanctum', 'ability:medicines:post']);
Route::patch('medicines/{id}', [MedicineController::class, 'update'])
    ->middleware(['auth:sanctum', 'ability:medicines:patch']);
Route::delete('medicines/{id}', [MedicineController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'ability:medicines:delete']);
//endregion

//region Photoes
Route::get('photoes', [PhotoeController::class, 'index']);
Route::get('photoes/{id}', [PhotoeController::class, 'show']);
Route::post('photoes', [PhotoeController::class, 'store'])
    ->middleware(['auth:sanctum', 'ability:photoes:post']);
Route::patch('photoes/{id}', [PhotoeController::class, 'update'])
    ->middleware(['auth:sanctum', 'ability:photoes:patch']);
Route::delete('photoes/{id}', [PhotoeController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'ability:photoes:delete']);
//endregion

//region Photoes
Route::get('vaccinations', [VaccinationController::class, 'index']);
Route::get('vaccinations/{id}', [VaccinationController::class, 'show']);
Route::post('vaccinations', [VaccinationController::class, 'store'])
    ->middleware(['auth:sanctum', 'ability:vaccinations:post']);
Route::patch('vaccinations/{id}', [VaccinationController::class, 'update'])
    ->middleware(['auth:sanctum', 'ability:vaccinations:patch']);
Route::delete('vaccinations/{id}', [VaccinationController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'ability:vaccinations:delete']);
//endregion

