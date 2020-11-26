<?php

use App\Http\Controllers\RepositoriesController;
use Illuminate\Support\Facades\Route;

Route::get('repositories', [RepositoriesController::class, 'index'])
    ->name('repositories.index');
