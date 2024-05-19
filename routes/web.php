<?php

use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserPartnerController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TaskerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\TrashCategoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $client = new Client();
    $response = $client->request('GET', 'https://restcountries.com/v3.1/all');
    $countries = json_decode($response->getBody(), true);

    usort($countries, function ($a, $b) {
        return strcmp($a['name']['common'], $b['name']['common']);
    });

    $data = [
        'countries' => $countries
    ];

    return view('landing.index', $data);
});

Route::get('/admin_login', function () {
    return view('admin.auth.login');
});

//# Partner Auth Route
Route::group(['prefix' => 'partner'], function () {
    Route::post("/register", [PartnerController::class, "register"])->name('partner-register');
    Route::post("/login", [PartnerController::class, "login"])->name('partner-login');
    Route::get("/logout", [PartnerController::class, "logout"])->name('partner-logout');
    Route::get("/partner-profile/{id}", [PartnerController::class, "profile"])->name('partner-profile')->middleware('partner');
    Route::put("/partner-profile/{id}", [PartnerController::class, "update"])->name('partner-profile-update')->middleware('partner');
});

//# Admin Partner Route
Route::group(['prefix' => 'admin-partner', 'middleware' => 'admin'], function () {
    Route::get("/", [PartnerController::class, "index"])->name('admin-partner-manage');
    Route::get("/details/{id}", [PartnerController::class, "details"])->name('admin-partner-details');
    Route::put("/updateStatus/{id}", [PartnerController::class, "updateStatusPartner"])->name('partner-updateStatusPartner');
});

//# Admin Payment Route
Route::group(['prefix' => 'payment'], function () {
    Route::get("/", [PaymentController::class, "index"])->name('admin-payment');
    Route::post("/pay", [PaymentController::class, "payment"])->name('admin-pay');
});

//# Admin Auth Route
Route::group(['prefix' => 'login-admin'], function () {
    Route::post("/", [AuthController::class, "login"])->name('admin-login');
    Route::get("/logout", [AuthController::class, "logout"])->name('admin-logout');
});

//# Admin Dashboard Route
Route::group(['prefix' => 'dashboard'], function () {
    Route::get("/", [DashboardController::class, "index"])->name('admin-dashboard')->middleware('admin');
    Route::post("/pay", [DashboardController::class, "payment"])->name('admin-pay');
});

//# Admin Tasker Route
Route::group(['prefix' => 'admin-tasker'], function () {
    Route::get("/", [TaskerController::class, "admin"])->name('admin-tasker-manage')->middleware('admin');
    Route::get("/details/{id}", [TaskerController::class, "details"])->name('admin-tasker-details')->middleware('admin');
});

//# Partner Tasker Route
Route::group(['prefix' => 'tasker'], function () {
    Route::get("/", [TaskerController::class, "index"])->name('partner-tasker-manage')->middleware('partner');
    Route::post("/store", [TaskerController::class, "store"])->name('partner-tasker-store')->middleware('partner');
    Route::delete("/delete/{id}", [TaskerController::class, "delete"])->name('partner-tasker-delete')->middleware('partner');
    Route::put("/update/{id}", [TaskerController::class, "update"])->name('partner-tasker-update')->middleware('partner');
    Route::put("/updateStatus/{id}", [TaskerController::class, "updateStatus"])->name('partner-tasker-updateStatus')->middleware('partner');
});

//# Partner Trash Category Route
Route::group(['prefix' => 'trash-category'], function () {
    Route::get("/", [TrashCategoryController::class, "index"])->name('partner-trash-category-manage')->middleware('partner');
    Route::post("/store", [TrashCategoryController::class, "store"])->name('partner-trash-category-store')->middleware('partner');
    Route::delete("/delete/{id}", [TrashCategoryController::class, "delete"])->name('partner-trash-category-delete')->middleware('partner');
    Route::put("/update/{id}", [TrashCategoryController::class, "update"])->name('partner-trash-category-update')->middleware('partner');
});

//# Partner Trash Route
Route::group(['prefix' => 'trash'], function () {
    Route::get("/", [TrashController::class, "index"])->name('partner-trash-manage')->middleware('partner');
    Route::post("/store", [TrashController::class, "store"])->name('partner-trash-store')->middleware('partner');
    Route::delete("/delete/{id}", [TrashController::class, "delete"])->name('partner-trash-delete')->middleware('partner');
    Route::put("/update/{id}", [TrashController::class, "update"])->name('partner-trash-update')->middleware('partner');
});

//# Admin Vehicle Route
Route::group(['prefix' => 'vehicle'], function () {
    Route::get("/", [VehicleController::class, "index"])->name('partner-vehicle-manage')->middleware('admin');
    Route::post("/store", [VehicleController::class, "store"])->name('partner-vehicle-store')->middleware('admin');
    Route::delete("/delete/{id}", [VehicleController::class, "delete"])->name('partner-vehicle-delete')->middleware('admin');
    Route::put("/update/{id}", [VehicleController::class, "update"])->name('partner-vehicle-update')->middleware('admin');
});

//# Partner News Route
Route::group(['prefix' => 'news'], function () {
    Route::get("/list", [NewsController::class, "list"])->name('admin-news-list')->middleware('admin');
    Route::get("/detail/{id}", [NewsController::class, "admin_detail"])->name('admin-news-details')->middleware('admin');
    Route::get("/", [NewsController::class, "index"])->name('partner-news-manage')->middleware('partner');
    Route::post("/store", [NewsController::class, "store"])->name('partner-news-store')->middleware('partner');
    Route::put("/update/{id}", [NewsController::class, "update"])->name('partner-news-update')->middleware('partner');
    Route::get("/details/{id}", [NewsController::class, "details"])->name('partner-news-details')->middleware('partner');
    Route::delete("/delete/{id}", [NewsController::class, "delete"])->name('partner-news-delete')->middleware('partner');
    Route::delete("/delete-image/{id}", [NewsController::class, "delete_image"])->name('partner-news-image-delete')->middleware('partner');
});

//# Admin News Category Route
Route::group(['prefix' => 'news-category', 'middleware' => 'admin'], function () {
    Route::get("/", [NewsCategoryController::class, "index"])->name('admin-news-category-manage');
    Route::post("/store", [NewsCategoryController::class, "store"])->name('admin-news-category-store');
    Route::post("/update/{id}", [NewsCategoryController::class, "update"])->name('admin-news-category-update');
    Route::delete("/delete/{id}", [NewsCategoryController::class, "delete"])->name('admin-news-category-delete');
});

Route::group(['prefix' => '/', 'middleware' => 'partner'], function () {
    Route::get("/dashboard-partner", [DashboardController::class, "partner"])->name('dashboard-partner');
});

Route::group(['prefix' => 'partner-customer', 'middleware' => 'partner'], function () {
    Route::get("/{id}", [UserPartnerController::class, "index"])->name('partner-customer-manage');
    Route::get("/detail/{id}/{user_id}", [UserPartnerController::class, "detail"])->name('partner-customer-details');
    Route::post("/register-partner", [UserPartnerController::class, "register"])->name('login-partner');
    Route::put("/updateStatus/{id}", [UserPartnerController::class, "updateStatusUser"])->name('customer-updateStatusUser');
});

