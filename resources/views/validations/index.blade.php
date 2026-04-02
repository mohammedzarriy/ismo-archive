@extends('adminlte::page')
@section('title', 'Registre des validations')
@section('content_header')
    <h1><i class="fas fa-check-double"></i> Registre des validations</h1>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        <table id="val-table" class="table table-bordered table-hover">
            <thead class="bg-success">
                <tr>
                    <th>#</th>
                    <th>Stagiaire</th>
                    <th>CIN</th>
                    <th>Filière</th>
                    <th>Date validation</th>
                    <th>Validé par</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($validations as $val)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $val->trainee->last_name }} {{ $val->trainee->first_name }}</td>
                    <td>{{ $val->trainee->cin }}</td>
                    <td>{{ $val->trainee->filiere->nom_filiere }}</td>
                    <td>
                        <span class="badge badge-success">
                            {{ $val->date_validation->format('d/m/Y') }}
                        </span>
                    </td>
                    <td>{{ $val->user->name }}</td>
                    <td>
                        <a href="{{ route('validations.show', $val->trainee) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $validations->links() }}
    </div>
</div>
@stop
@section('js')
<script>
    $('#val-table').DataTable({
        "language": {"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/French.json"},
        "paging": false,
        "order": [[4, "desc"]]
    });
</script>
@stop