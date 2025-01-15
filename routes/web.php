<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\BlockedMiddleware;
use Illuminate\Support\Facades\Route;

Route::any('captcha-test', function() {
    if (request()->getMethod() == 'POST') {
        $rules = ['captcha' => 'required|captcha'];
        $validator = validator()->make(request()->all(), $rules);
        if ($validator->fails()) {
            echo '<p style="color: #ff0000;">Incorrect!</p>';
        } else {
            echo '<p style="color: #00ff30;">Matched :)</p>';
        }
    }

    $form = '<form method="post" action="captcha-test">';
    $form .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    $form .= '<p>' . captcha_img() . '</p>';
    $form .= '<p><input type="text" name="captcha"></p>';
    $form .= '<p><button type="submit" name="check">Check</button></p>';
    $form .= '</form>';
    return $form;
});

Route::middleware(['auth', BlockedMiddleware::class])->group(function () {
    Route::resource('profile', ProfileController::class);

    Route::post('/instructions/{id}/complain', [InstructionController::class, 'complain'])->name('instructions.complain');
    Route::get('/instructions/create', [InstructionController::class, 'create'])->name('instructions.create');
    Route::post('/instructions/create', [InstructionController::class, 'store'])->name('instructions.store');
});

Route::middleware(['auth', AdminMiddleware::class, BlockedMiddleware::class])->group(function () {
    Route::resource('users', UserController::class);
    Route::post('/instructions/{id}/approve', [ProfileController::class, 'approveInstruction'])->name('instructions.approve');
    Route::delete('/instructions/{id}', [InstructionController::class, 'destroy'])->name('instructions.destroy');

    Route::post('/users/{id}/block', [UserController::class, 'block'])->name('users.block');
    Route::post('/users/{id}/unblock', [UserController::class, 'unblock'])->name('users.unblock');
});

Route::get('/', [InstructionController::class, 'index'])->name('instructions.index');
Route::get('/instructions/{id}', [InstructionController::class, 'show'])->name('instructions.show');

require __DIR__.'/auth.php';
