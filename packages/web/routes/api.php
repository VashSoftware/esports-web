<?php

use App\Http\Controllers\OsuMessageController;
use Illuminate\Support\Facades\Route;

Route::resource('/osu_messages', OsuMessageController::class);
