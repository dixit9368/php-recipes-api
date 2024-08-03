<?php

use Illuminate\Support\Facades\Route;
use App\Controllers\RecipeController;

// $request_uri = $_SERVER['REQUEST_URI'];
// $method = $_SERVER['REQUEST_METHOD'];

 $recipeController = new RecipeController();
Route::get('/', function () {
    return response()->json(["message" => "Welcome to the Recipe API!"]);
});

Route::get('/recipes', [RecipeController::class, 'index']);
Route::post('/recipes', [RecipeController::class, 'store']);
Route::get('/recipes/{id}', [RecipeController::class, 'show']);
Route::put('/recipes/{id}', [RecipeController::class, 'update']);
Route::patch('/recipes/{id}', [RecipeController::class, 'update']);
Route::delete('/recipes/{id}', [RecipeController::class, 'destroy']);
Route::post('/recipes/{id}/rating', [RecipeController::class, 'rate']);
?>
