<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\JustificationController;
use App\Http\Controllers\ScanController;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin_dashboard');
        }

        if (auth()->user()->role === 'professeur') {
            return redirect()->route('professeur_dashboard');
        }

        if (auth()->user()->role === 'etudiant') {
            return redirect()->route('etudiant_dashboard');
        }
    }

    return redirect()->route('login');
});

Auth::routes();

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboards.admin');
    })->name('admin_dashboard');

    Route::resource('classes', ClasseController::class)
        ->parameters(['classes' => 'classe']);

    Route::resource('modules', ModuleController::class);

    Route::resource('professeurs', ProfesseurController::class);

    Route::resource('etudiants', EtudiantController::class);

    Route::resource('seances', SeanceController::class);

    Route::resource('presences', PresenceController::class);

    Route::resource('justifications', JustificationController::class);
});

/*
|--------------------------------------------------------------------------
| Professeur Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:professeur'])->group(function () {

    Route::get('/professeur/dashboard', function () {
        return view('dashboards.professeur');
    })->name('professeur_dashboard');

    Route::get('/professeur/seances', [ProfesseurController::class, 'seances'])
        ->name('professeur.seances');

    Route::get('/professeur/presences', [ProfesseurController::class, 'presences'])
        ->name('professeur.presences');

    Route::get('/professeur/seances/{seance}/presences', [ProfesseurController::class, 'seancePresences'])
        ->name('professeur.seance.presences');

    Route::post('/seances/{seance}/scan', [ScanController::class, 'store'])
        ->name('seances.scan.store');
});
/*
|--------------------------------------------------------------------------
| Etudiant Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:etudiant'])->group(function () {

    Route::get('/etudiant/dashboard', function () {
        return view('dashboards.etudiant');
    })->name('etudiant_dashboard');

    Route::get('/etudiant/justifications', [EtudiantController::class, 'justifications'])
        ->name('etudiant.justifications');

    Route::get('/etudiant/justifications/create', [EtudiantController::class, 'createJustification'])
        ->name('etudiant.justifications.create');

    Route::post('/etudiant/justifications/store', [EtudiantController::class, 'storeJustification'])
        ->name('etudiant.justifications.store');

    Route::get('/etudiant/justifications/{justification}/edit', [EtudiantController::class, 'editJustification'])
        ->name('etudiant.justifications.edit');

    Route::put('/etudiant/justifications/{justification}', [EtudiantController::class, 'updateJustification'])
        ->name('etudiant.justifications.update');

    Route::delete('/etudiant/justifications/{justification}', [EtudiantController::class, 'destroyJustification'])
        ->name('etudiant.justifications.destroy');
});
/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');