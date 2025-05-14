<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\BooksController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\AuthController;
use App\Models\Favorites;
use App\Models\User;
use App\Models\Books;
use App\Models\Review;



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource("/usuarios", UserController::class);
    Route::apiResource("/reseñas", ReviewController::class);
    Route::apiResource("/favoritos", FavoritesController::class);
    Route::apiResource("/libros", BooksController::class);

});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'store']);