@extends('layouts.professeur')

@section('page-title', 'Présences')

@section('professeur-content')

<div class="card">
    <div class="card-header">
        <h4>
            {{ $seance->module->nom ?? '-' }}
            - {{ $seance->date }}
        </h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Statut</th>
                    <th>Heure scan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($presences as $presence)
                    <tr>
                        <td>{{ $presence->etudiant->user->name ?? '-' }}</td>
                        <td>{{ $presence->status }}</td>
                        <td>{{ $presence->heure_scan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            Aucune présence
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('professeur.seances') }}"
           class="btn btn-secondary">
            Retour
        </a>

    </div>
</div>

@endsection