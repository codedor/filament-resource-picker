<?php

use Codedor\FilamentResourcePicker\Http\Controllers\ResourcesController;
use Illuminate\Support\Facades\Route;

Route::get('/picker/resources', ResourcesController::class);
