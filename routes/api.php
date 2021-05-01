<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
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

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group( function () {
    Route::get('recipes', [RecipeController::class, 'index']);
	Route::post('recipes', [RecipeController::class, 'store']);
	Route::get('recipes/{id}', [RecipeController::class, 'show']);
	Route::put('recipes/{id}', [RecipeController::class, 'update']);
	Route::delete('recipes/{id}', [RecipeController::class, 'destroy']);

	Route::get('recipes/{id}/ingredients', [IngredientController::class, 'index']);
	Route::post('recipes/{id}/ingredients', [IngredientController::class, 'store']);
	Route::get('recipes/{id}/ingredients/{r_id}', [IngredientController::class, 'show']);
	Route::put('recipes/{id}/ingredients/{r_id}', [IngredientController::class, 'update']);
	Route::delete('recipes/{id}/ingredients/{r_id}', [IngredientController::class, 'destroy']);
});
