@extends('layouts.etudiant')

@section('page-title', 'Ajouter une justification')
@section('page-subtitle', 'Justification d’une absence')

@section('etudiant-content')
<div class="sp-card">
   <form method="POST" action="{{ route('etudiant.justifications.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
 @php
    $etudiant = \App\Models\Etudiant::where('user_id', Auth::id())->first();
@endphp

<input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">
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

            <<a href="{{ route('etudiant.justifications') }}" class="sp-btn-light">
                <i class="bi bi-arrow-left"></i>
                Retour
            </a>
        </div>
    </form>
</div>
@endsection
