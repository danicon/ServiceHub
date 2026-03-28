<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tickets.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('tickets', TicketController::class);
});

require __DIR__.'/auth.php';