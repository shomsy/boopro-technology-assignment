<?php

use App\Http\Controllers\API\V1\SocialMediaSearchController as SocialMediaSearchV1Controller;
use App\Http\Controllers\API\V2\SocialMediaSearchController as SocialMediaSearchV2Controller;
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

Route::prefix('V1')->group(
    static fn() => Route::get('/search', [SocialMediaSearchV1Controller::class, 'search'])
);
Route::prefix('V2')->group(
    static fn() => Route::get('/search', [SocialMediaSearchV2Controller::class, 'search'])
);

