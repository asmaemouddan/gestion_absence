@extends('layouts.admin')

@section('page-title', 'Ajouter une séance')
@section('page-subtitle', 'Planification d’une séance')

@section('admin-content')
<div class="sp-card">
    <form method="POST" action="{{ route('seances.store') }}">
        @csrf

        <div class="row g-4">
            <div class="col-md-4">
                <label for="classe_id" class="form-label">Classe</label>
                <select name="classe_id" id="classe_id" class="form-select @error('classe_id') is-invalid @enderror" required>
                    <option value="">Sélectionner une classe</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                    @endforeach
                </select>
                @error('classe_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label for="professeur_id" class="form-label">Professeur</label>
                <select name="professeur_id" id="professeur_id" class="form-select @error('professeur_id') is-invalid @enderror" required>
                    <option value="">Sélectionner un professeur</option>
                    @foreach($professeurs as $professeur)
                        <option value="{{ $professeur->id }}" {{ old('professeur_id') == $professeur->id ? 'selected' : '' }}>
                            {{ $professeur->user->name ?? '-' }}
                        </option>
                    @endforeach
                </select>
                @error('professeur_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label for="module_id" class="form-label">Module</label>
                <select name="module_id" id="module_id" class="form-select @error('module_id') is-invalid @enderror" required>
                    <option value="">Sélectionner un module</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>
                            {{ $module->nom }}
                        </option>
                    @endforeach
                </select>
                @error('module_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                       value="{{ old('date') }}" required>
                @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label for="heure_debut" class="form-label">Heure début</label>
                <input type="time" name="heure_debut" id="heure_debut" class="form-control @error('heure_debut') is-invalid @enderror"
                       value="{{ old('heure_debut') }}" required>
                @error('heure_debut') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label for="heure_fin" class="form-label">Heure fin</label>
                <input type="time" name="heure_fin" id="heure_fin" class="form-control @error('heure_fin') is-invalid @enderror"
                       value="{{ old('heure_fin') }}" required>
                @error('heure_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="sp-btn">
                <i class="bi bi-check2-circle"></i>
                Enregistrer
            </button>

            <a href="{{ route('seances.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </form>
</div>
@endsection