<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\QuoteController;
use App\Http\Controllers\API\v1\UserController;

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

Route::prefix("v1")->group(function () {
    Route::post('/users/login', [UserController::class, 'login']);
    Route::post('/users/register', [UserController::class, 'register']);

});

Route::prefix("v1")->middleware("auth:sanctum")->group(function(){
    Route::apiResource("quotes", QuoteController::class);
    Route::get("test", function () {
        return "probando ";
    });
});

/*
Route::group([
    "middleware" => "auth:sanctum",
    "prefix" => "v1"
], function () {
    Route::apiResource("quotes", QuoteController::class);
    Route::get("test", function () {
        return "probando ";
    });
}); */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
