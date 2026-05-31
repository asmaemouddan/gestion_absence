@extends('layouts.admin')

@section('page-title', 'Modifier un étudiant')
@section('page-subtitle', 'Mise à jour des informations de l’étudiant')

@section('admin-content')
<div class="sp-card">
    <form method="POST" action="{{ route('etudiants.update', $etudiant) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-md-6">
                <label for="name" class="form-label">Nom complet</label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $etudiant->user->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $etudiant->user->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" name="telephone" id="telephone"
                       class="form-control @error('telephone') is-invalid @enderror"
                       value="{{ old('telephone', $etudiant->user->telephone) }}">
                @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="classe_id" class="form-label">Classe</label>
                <select name="classe_id" id="classe_id"
                        class="form-select @error('classe_id') is-invalid @enderror" required>
                    <option value="">Sélectionner une classe</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}"
                            {{ old('classe_id', $etudiant->classe_id) == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                    @endforeach
                </select>
                @error('classe_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="image" class="form-label">Nouvelle photo</label>
                <input type="file" name="image" id="image"
                       class="form-control @error('image') is-invalid @enderror"
                       accept="image/png,image/jpeg,image/jpg">
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="sp-btn">
                <i class="bi bi-check2-circle"></i>
                Modifier
            </button>

            <a href="{{ route('etudiants.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </form>
</div>
@endsection