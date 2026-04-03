@extends('adminlte::page')

@section('title', 'Importer stagiaires')

@section('content_header')
    <h1><i class="fas fa-file-excel"></i> Importer depuis Excel</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="alert alert-info">
            <strong>Format requis du fichier Excel:</strong>
            <br>
            Colonnes: <code>cin | nom | prenom | cef | filiere | groupe | annee | date_de_naissance</code>
</div>
        </div>

        <form action="{{ route('trainees.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Fichier Excel <span class="text-danger">*</span></label>
                <input type="file" name="file"
                       class="form-control @error('file') is-invalid @enderror"
                       accept=".xlsx,.xls,.csv" required>
                @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-upload"></i> Importer
            </button>
            <a href="{{ route('trainees.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </form>
    </div>
</div>
@stop