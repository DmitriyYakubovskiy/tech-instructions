<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\AdminController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('instructions', InstructionController::class);
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/instructions', [AdminController::class, 'index'])->name('admin.instructions.index');
    Route::post('/admin/instructions/{id}/approve', [AdminController::class, 'approve']);
});

Route::resource('instructions', InstructionController::class);
Route::post('instructions/{id}/report', [InstructionController::class, 'report'])->name('instructions.report');