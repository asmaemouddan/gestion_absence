@extends('layouts.etudiant')

@section('page-title', 'Modifier la justification')
@section('page-subtitle', 'Modification de la justification')

@section('etudiant-content')
<div class="sp-card">

    <form method="POST"
          action="{{ route('etudiant.justifications.update', $justification->id) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="row g-4">

            <div class="col-md-12">
                <label class="form-label">Absence concernée</label>

                <input type="text"
                       class="form-control"
                       value="{{ $justification->presence->seance->module->nom }} - {{ $justification->presence->seance->date }}"
                       readonly>
            </div>

            <div class="col-md-12">
                <label for="motif" class="form-label">Motif</label>

                <textarea name="motif"
                          id="motif"
                          rows="5"
                          class="form-control @error('motif') is-invalid @enderror"
                          required>{{ old('motif', $justification->motif) }}</textarea>

                @error('motif')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12">
                <label for="fichier" class="form-label">
                    Nouveau fichier justificatif
                </label>

                <input type="file"
                       name="fichier"
                       id="fichier"
                       class="form-control"
                       accept=".pdf,image/png,image/jpeg,image/jpg">

                @if($justification->fichier)
                    <small class="d-block mt-2">
                        Fichier actuel :
                        <a href="{{ asset('storage/'.$justification->fichier) }}"
                           target="_blank">
                            Consulter
                        </a>
                    </small>
                @endif
            </div>

        </div>

        <div class="d-flex gap-2 mt-4">

            <button type="submit" class="sp-btn">
                Enregistrer
            </button>

            <a href="{{ route('etudiant.justifications') }}"
               class="sp-btn-light">
                Retour
            </a>

        </div>

    </form>

</div>
@endsection
