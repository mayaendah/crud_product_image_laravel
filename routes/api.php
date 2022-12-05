<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apiController;

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
Route::get('crud',[apiController::class,'index']);
Route::post('crud',[apiController::class,'store']);
Route::get('crud/{id}',[apiController::class,'show']);
Route::post('crud/update/{id}',[apiController::class,'update']);
Route::delete('crud/{id}',[apiController::class,'destroy']);
