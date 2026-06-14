@extends('layouts.etudiant')

@section('page-title', 'Mes Justifications')
@section('page-subtitle', 'Liste de mes justifications')

@section('etudiant-content')

<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Mes Justifications</h3>

        <a href="{{ route('etudiant.justifications.create') }}"
           class="btn btn-success">
            <i class="bi bi-plus-circle"></i>
            Ajouter une justification
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">

            <thead>
                <tr>
                    <th>Module</th>
                    <th>Date</th>
                    <th>Motif</th>
                    <th>Statut</th>
                    <th>Fichier</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>

            <tbody>

            @forelse($justifications as $justification)

                <tr>

                    <td>
                        {{ $justification->presence->seance->module->nom ?? '-' }}
                    </td>

                    <td>
                        {{ $justification->presence->seance->date ?? '-' }}
                    </td>

                    <td>
                        {{ $justification->motif }}
                    </td>

                    <td>
                        @if($justification->status == 'en_attente')
                            <span class="badge bg-warning text-dark">
                                En attente
                            </span>
                        @elseif($justification->status == 'acceptee')
                            <span class="badge bg-success">
                                Acceptée
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Refusée
                            </span>
                        @endif
                    </td>

                    <td>
                        @if($justification->fichier)
                            <a href="{{ asset('storage/'.$justification->fichier) }}"
                               target="_blank"
                               class="btn btn-primary btn-sm">
                                <i class="bi bi-file-earmark"></i>
                                Voir
                            </a>
                        @else
                            -
                        @endif
                    </td>

                    <td>

                        <div class="d-flex gap-1">

                            <a href="{{ route('etudiant.justifications.show', $justification->id) }}"
                               class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>

                            @if($justification->status == 'en_attente')

                                <a href="{{ route('etudiant.justifications.edit', $justification->id) }}"
                                   class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('etudiant.justifications.destroy', $justification->id) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Supprimer cette justification ?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            @endif

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="text-center">
                        Aucune justification trouvée
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>
    </div>

</div>

@endsection
