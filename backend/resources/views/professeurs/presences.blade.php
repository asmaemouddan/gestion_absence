@extends('layouts.professeur')

@section('page-title', 'Présences')
@section('page-subtitle', 'Liste des présences des étudiants')

@section('professeur-content')

<div class="card">
    <div class="card-header">
        <h4>Présences des étudiants</h4>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Classe</th>
                    <th>Module</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>

            <tbody>
                @forelse($presences as $presence)
                    <tr>
                        <td>{{ $presence->etudiant->user->name ?? '-' }}</td>

                        <td>
                            {{ $presence->seance->classe->nom ?? '-' }}
                        </td>

                        <td>
                            {{ $presence->seance->module->nom ?? '-' }}
                        </td>

                        <td>
                            {{ $presence->seance->date ?? '-' }}
                        </td>

                        <td>
                            @if($presence->status == 'present')
                                <span class="badge bg-success">
                                    Présent
                                </span>

                            @elseif($presence->status == 'retard')
                                <span class="badge bg-warning">
                                    Retard
                                </span>

                            @else
                                <span class="badge bg-danger">
                                    Absent
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Aucune présence trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection