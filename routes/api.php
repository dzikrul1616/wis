<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ApiController::class)->group(function () {
    Route::post('/register', 'register_user');
    Route::post('/login', 'login_user');
    Route::post('/logout', 'logout_user')->middleware('auth:sanctum');
    Route::post('/update-status', 'update_status')->middleware('auth:sanctum');
    Route::get('/check', 'check')->middleware('auth:sanctum');
    Route::get('/get-users/{id}', 'getUser')->middleware('auth:sanctum');
    Route::get('/get-partner', 'getPartner')->middleware('auth:sanctum');
    Route::get('/get-partner-details/{id}', 'getPartnerDetails')->middleware('auth:sanctum');
    Route::post('/user-application', 'userApplication')->middleware('auth:sanctum');
    Route::get('/get-status-application', 'getPartnerbyUser')->middleware('auth:sanctum');
    Route::get('/get-news', 'getNews')->middleware('auth:sanctum');
    Route::get('/get-news-details/{id}', 'getNewsDetail')->middleware('auth:sanctum');
    Route::get('/get-vehicle', 'getvehicle');
    Route::post('/transaction', 'postTransaction')->middleware('auth:sanctum');
    Route::get('/get-user', 'getUserAll')->middleware('auth:sanctum');
    Route::get('/get-user/{partner_id}', 'getUserByPartner')->middleware('auth:sanctum');
    Route::get('/get-notif', 'getNotifbyId')->middleware('auth:sanctum');
    Route::post('/send-notif', 'sendNotification')->middleware('auth:sanctum');
    Route::post('/add-notif', 'addNotifByUserId')->middleware('auth:sanctum');
    Route::post('/add-notif-fire', 'addNotifFirebase')->middleware('auth:sanctum');
    Route::post('/update-notif-token', 'updateTokenNotif')->middleware('auth:sanctum');
    Route::delete('/get-notif/{id}', 'deleteNotifById')->middleware('auth:sanctum');
    Route::get('/trash', 'getTrash')->middleware('auth:sanctum');
    Route::get('/trash-partner/{partnerId}', 'getTrashbyPartner')->middleware('auth:sanctum');
    Route::post('/point-exchange', 'pointExchange')->middleware('auth:sanctum');
});
