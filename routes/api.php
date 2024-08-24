<?php

use App\Http\Controllers\Api\CategoriController;
use App\Http\Controllers\Api\ProductAssetController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/', function () {
    return response()->json([
        'status' => true,
        'message' => "Akses Ditolak"
    ], 401);
})->name('login');

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoriController::class, 'index']);
    Route::post('/', [CategoriController::class, 'store']);
    Route::patch('/{id}', [CategoriController::class, 'update']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store'])->name('api.product.store');
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

Route::prefix('assets')->group(function () {
    Route::post('/', [ProductAssetController::class, 'store']);
    Route::delete('/{id}', [ProductAssetController::class, 'destroy']);
});