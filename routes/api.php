<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PegawaiController;

Route::get('/pegawai', [PegawaiController::class, 'index']);
