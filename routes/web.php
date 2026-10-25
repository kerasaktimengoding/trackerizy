<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabitTrackerController;

Route::get('/', [HabitTrackerController::class, 'index'])->name('tracker.index');
Route::post('/habits/{habit}/toggle', [HabitTrackerController::class, 'toggle'])->name('habits.toggle');

