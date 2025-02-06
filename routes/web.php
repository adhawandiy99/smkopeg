<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\AccountController;

// Public Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'requestOtp']);
Route::get('/otp', [LoginController::class, 'showVerifyForm']);
Route::post('/otp', [LoginController::class, 'verifyOtp']);
Route::post('/api/location', [LoginController::class, 'store_loc']);
Route::post('/api/upload', [HomeController::class, 'upload']);
Route::get('/loginWithToken', [LoginController::class, 'login_token_post']);

Route::post('/telegram/webhook', [TelegramController::class, 'handleWebhook']);
// API Routes
Route::prefix('api')->group(function () {
    Route::post('/insertUpdate', [ApiController::class, 'insertUpdate']);
    Route::get('/get', [ApiController::class, 'get']);
});

// Ajax Routes
Route::prefix('ajax')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'ajax']);
    Route::post('/get_odp', [MasterController::class, 'ajax_get_odp']);
    Route::post('/get_paket', [MasterController::class, 'ajax_get_paket']);

    Route::post('/update_status_rekon', [OrderController::class, 'update_status_rekon']);
});

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index']);
// Authenticated Routes
Route::middleware(['custom-auth'])->group(function () {
    //transactional
    Route::get('/', [HomeController::class, 'home']);
    Route::get('/survey_layanan', [HomeController::class, 'survey_layanan']);
    Route::get('/get_markers', [HomeController::class, 'get_markers']);
    Route::get('/form_order/{id}', [OrderController::class, 'form']);
    Route::post('/form_order/{id}', [OrderController::class, 'save']);
    Route::get('/approval_tl', [OrderController::class, 'approval_tl_list']);
    Route::get('/approval_spv', [OrderController::class, 'approval_spv_list']);
    Route::get('/order_issued', [OrderController::class, 'order_issued_list']);
    Route::get('/my_order', [OrderController::class, 'my_order_list']);
    Route::get('/search', [OrderController::class, 'search']);
    Route::get('/export_orders', [DashboardController::class, 'exportToExcel']);
    // Route::post('/input_pi', [ActivityController::class, 'input_pi']);
    // Route::get('/activity', [ActivityController::class, 'index']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    //master
    Route::get('/odp', [MasterController::class, 'odp']);
    Route::post('/odp', [MasterController::class, 'odp_save']);
    Route::get('/homepass', [MasterController::class, 'homepass']);
    Route::post('/homepass', [MasterController::class, 'homepass_save']);
    Route::get('/users', [AccountController::class, 'users']);
    Route::get('/user/{id}', [AccountController::class, 'user_form']);
    Route::post('/user/{id}', [AccountController::class, 'user_save']);
    Route::get('/setting', [MasterController::class, 'setting']);
    Route::post('/paket', [MasterController::class, 'paket_save']);
    Route::post('/isp', [MasterController::class, 'isp_save']);
    Route::post('/promo', [MasterController::class, 'promo_save']);
    Route::get('/update_status_batch', [MasterController::class, 'update_status_batch']);
    Route::post('/update_status_batch', [MasterController::class, 'update_status_batch_save']);
});