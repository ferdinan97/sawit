<?php

use App\Http\Controllers\StaffController;
use App\Http\Controllers\WorkHistoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/login', [AuthController::class, 'viewLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth']], function () {

    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    });

    Route::prefix('staff')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('index_staff');
        Route::get('/data', [StaffController::class, 'data'])->name('data_staff');
        Route::get('/add', [StaffController::class, 'add'])->name('add_staff');
        Route::post('/post', [StaffController::class, 'store'])->name('post_staff');
        Route::get('/edit/{id}', [StaffController::class, 'edit'])->name('edit_staff');
        Route::post('/update', [StaffController::class, 'update'])->name('update_staff');
        Route::delete('/delete/{id}', [StaffController::class, 'delete'])->name('delete_staff');
    });

    Route::prefix('work-history')->group(function () {
        Route::get('/', [WorkHistoryController::class, 'index'])->name('index_work_history');
        Route::get('/list-data', [WorkHistoryController::class, 'history'])->name('data_work_history');
        Route::get('/data', [WorkHistoryController::class, 'data'])->name('data_work_history');
        Route::get('/add', [WorkHistoryController::class, 'add'])->name('add_work_history');
        Route::get('/add_per_item', [WorkHistoryController::class, 'add_per_item'])->name('add_per_item_work_history');
        Route::post('/post', [WorkHistoryController::class, 'store'])->name('post_work_history');
        Route::get('/edit/{id}', [WorkHistoryController::class, 'edit'])->name('edit_work_history');
        Route::post('/update', [WorkHistoryController::class, 'update'])->name('update_work_history');
        Route::delete('/delete/{id}', [WorkHistoryController::class, 'delete'])->name('delete_work_history');
    });

    Route::prefix('report')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index_report');
        Route::get('/data', [ReportController::class, 'general_report'])->name('data_report');
    });

    Route::prefix('expense')->group(function () {
        Route::get('/', [ExpenseController::class, 'index'])->name('index_expense');
        Route::get('/data', [ExpenseController::class, 'data'])->name('data_report');
        Route::get('/add', [ExpenseController::class, 'add'])->name('add_expense');
        Route::post('/insert', [ExpenseController::class, 'store'])->name('insert_expense');
        Route::get('/edit/{id}', [ExpenseController::class, 'edit'])->name('edit_expense');
        Route::post('/update', [ExpenseController::class, 'update'])->name('update_expense');
        Route::delete('/delete/{id}', [ExpenseController::class, 'delete'])->name('delete_expense');
    });

    Route::prefix('income')->group(function () {
        Route::get('/', [ExpenseController::class, 'index'])->name('index_expense');
        Route::get('/data', [ExpenseController::class, 'data'])->name('data_report');
        Route::get('/add', [ExpenseController::class, 'add'])->name('add_expense');
        Route::post('/insert', [ExpenseController::class, 'store'])->name('insert_expense');
        Route::get('/edit/{id}', [ExpenseController::class, 'edit'])->name('edit_expense');
        Route::post('/update', [ExpenseController::class, 'update'])->name('update_expense');
        Route::delete('/delete/{id}', [ExpenseController::class, 'delete'])->name('delete_expense');
    });

});