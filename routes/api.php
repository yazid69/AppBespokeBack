<?php

use App\Http\Controllers\UserController;
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

Route::post("/register", [UserController::class, "createUser"]);

Route::post("/login", [UserController::class, "loginUser"]);

Route::put("/update/{idUser}", [UserController::class, "updateUser"]);

Route::get ("/users", [UserController::class, "getUsers"]);
Route::get("/users/{idUser}", [UserController::class, "getUserById"]);

Route::delete("/delete/{idUser}", [UserController::class, "deleteUser"]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
