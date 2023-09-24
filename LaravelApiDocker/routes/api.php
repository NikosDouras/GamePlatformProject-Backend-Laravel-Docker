<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\ReviewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




//Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

//Protected routes


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('my_games', GamesController::class);
    Route::get('all_games', [GamesController::class, 'allGames']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('my_games/{id}', 'GameController@destroy');
    Route::get('/game/{id}', [GamesController::class, 'singleGame']);


    //ADMIN
    Route::delete('all_games/{id}', [GamesController::class, 'admin_destroy']);
    Route::delete('any_review/{id}', [ReviewsController::class, 'admin_destroy_review']);
    Route::delete('/any_rating/{id}', [RatingsController::class, 'admin_destroy_rating']);


    //REVIEWS
    Route::post('/reviews/{id}', [ReviewsController::class, 'create_review']);
    Route::delete('reviews/{id}', [ReviewsController::class, 'destroy_review']);

    //RATING
    Route::post('/ratings/{id}', [RatingsController::class, 'rate']);
    Route::delete('/ratings/{id}', [RatingsController::class, 'delete_rate']);

});


