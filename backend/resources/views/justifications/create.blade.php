@extends('layouts.admin')

@section('page-title', 'Ajouter une justification')
@section('page-subtitle', 'Justification d’une absence')

@section('admin-content')
<div class="sp-card">
    <form method="POST" action="{{ route('justifications.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <div class="col-md-12">
                <label for="presence_id" class="form-label">Absence concernée</label>
                <select name="presence_id" id="presence_id" class="form-select @error('presence_id') is-invalid @enderror" required>
                    <option value="">Sélectionner une absence</option>
                    @foreach($presences as $presence)
                        <option value="{{ $presence->id }}" {{ old('presence_id') == $presence->id ? 'selected' : '' }}>
                            {{ $presence->etudiant->user->name ?? '-' }}
                            - {{ $presence->seance->module->nom ?? '-' }}
                            - {{ $presence->seance->classe->nom ?? '-' }}
                            - {{ $presence->seance->date ?? '-' }}
                        </option>
                    @endforeach
                </select>
                @error('presence_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12">
                <label for="motif" class="form-label">Motif</label>
                <textarea name="motif" id="motif" rows="5"
                          class="form-control @error('motif') is-invalid @enderror"
                          required>{{ old('motif') }}</textarea>
                @error('motif') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12">
                <label for="fichier" class="form-label">Fichier justificatif</label>
                <input type="file" name="fichier" id="fichier"
                       class="form-control @error('fichier') is-invalid @enderror"
                       accept=".pdf,image/png,image/jpeg,image/jpg">
                @error('fichier') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="sp-btn">
                <i class="bi bi-check2-circle"></i>
                Enregistrer
            </button>

            <a href="{{ route('justifications.index') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </form>
</div>
@endsection
