@extends('adminlte::page')
@section('title', 'Retraits temporaires — Bac')
@section('content_header')
    <h1><i class="fas fa-clock"></i> Bac — Retraits temporaires</h1>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        <table id="tempout-table" class="table table-bordered table-hover">
            <thead class="bg-warning">
                <tr>
                    <th>Stagiaire</th>
                    <th>CIN</th>
                    <th>Filière</th>
                    <th>Référence</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                <tr>
                    <td>{{ $doc->trainee->last_name }} {{ $doc->trainee->first_name }}</td>
                    <td>{{ $doc->trainee->cin }}</td>
                    <td>{{ $doc->trainee->filiere->nom_filiere }}</td>
                    <td>{{ $doc->reference_number ?? '—' }}</td>
                    <td>
                        <a href="{{ route('documents.show', $doc) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('documents.retour', $doc) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success"
                                onclick="return confirm('Confirmer le retour?')">
                                <i class="fas fa-undo"></i> Retour
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-success">
                        <i class="fas fa-check-circle"></i> Aucun retrait temporaire en cours
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $documents->links() }}
    </div>
</div>
@stop
@section('js')
<script>
    $('#tempout-table').DataTable({
        "language": {"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/French.json"},
        "paging": false
    });
</script>
@stop