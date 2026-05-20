<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ModuleController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboards.admin');
    })->name('admin_dashboard');
    // Route::resource('classes', ClasseController::class)
    // ->parameters(['classes' => 'classe']);
Route::resource('modules', ModuleController::class);
    Route::resource('classes', ClasseController::class);
});

Route::middleware(['auth', 'role:professeur'])->group(function () {
    Route::get('/professeur/dashboard', function () {
        return view('dashboards.professeur');
    })->name('professeur_dashboard');
});

Route::middleware(['auth', 'role:etudiant'])->group(function () {
    Route::get('/etudiant/dashboard', function () {
        return view('dashboards.etudiant');
    })->name('etudiant_dashboard');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
