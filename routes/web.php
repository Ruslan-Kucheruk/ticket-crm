<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;

Route::redirect('/', '/widget');

Route::get('/widget', [WidgetController::class, 'create'])->name('widget.create');


Route::prefix('admin')->name('admin.')->group(function(){

    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');

    Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');

    Route::patch('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');

});

