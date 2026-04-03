@extends('adminlte::page')

@section('title', 'Validation finale')

@section('content_header')
    <h1>
        <i class="fas fa-check-double"></i>
        Validation — {{ $trainee->last_name }} {{ $trainee->first_name }}
    </h1>
@stop

@section('content')

@if(count($missing) > 0)
    <div class="alert alert-warning">
        <h5><i class="fas fa-exclamation-triangle"></i> Documents non remis:</h5>
        @foreach($missing as $m)
            <span class="badge badge-danger mr-1">{{ $m }}</span>
        @endforeach
        <p class="mt-2 mb-0">
            Ces documents n'ont pas encore été remis définitivement.
            Voulez-vous continuer quand même?
        </p>
    </div>
@else
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <strong>Tous les documents ont été remis!</strong> Vous pouvez procéder à la validation.
    </div>
@endif

<div class="row">
    {{-- Info stagiaire --}}
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Informations stagiaire</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th>Nom</th><td>{{ $trainee->last_name }} {{ $trainee->first_name }}</td></tr>
                    <tr><th>CIN</th><td>{{ $trainee->cin }}</td></tr>
                    <tr><th>CEF</th><td>{{ $trainee->cef ?? '—' }}</td></tr>
                    <tr><th>Filière</th><td>{{ $trainee->filiere->nom_filiere }}</td></tr>
                    <tr><th>Promotion</th><td>{{ $trainee->graduation_year }}</td></tr>
                </table>
            </div>
        </div>

        {{-- État des documents --}}
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="card-title">État des documents</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    @foreach(['Bac','Diplome','Attestation','Bulletin'] as $type)
                        @php $doc = $trainee->documents->where('type', $type)->first(); @endphp
                        <tr>
                            <td>{{ $type }}</td>
                            <td>
                                @if(!$doc)
                                    <span class="badge badge-light border">
                                        <i class="fas fa-times text-danger"></i> Non enregistré
                                    </span>
                                @elseif(in_array($doc->status, ['Final_Out','Remis']))
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> Remis
                                    </span>
                                @elseif($doc->status == 'Temp_Out')
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i> Retrait temp.
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-archive"></i> En stock
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    {{-- Formulaire validation --}}
    <div class="col-md-8">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-signature"></i>
                    Enregistrer la validation
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('validations.store', $trainee) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Date de validation <span class="text-danger">*</span></label>
                        <input type="date" name="date_validation"
                               class="form-control @error('date_validation') is-invalid @enderror"
                               value="{{ old('date_validation', date('Y-m-d')) }}" required>
                        @error('date_validation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Upload signature --}}
                    <div class="form-group">
                        <label>
                            <i class="fas fa-signature"></i>
                            Scan de la signature du registre
                            <span class="text-danger">*</span>
                        </label>
                        <div class="card border-primary">
                            <div class="card-body text-center py-4" id="drop-zone"
                                 style="border: 2px dashed #007bff; cursor:pointer; border-radius:8px">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-2"></i>
                                <p class="mb-1">Glissez le scan ici ou</p>
                                <label for="signature_scan" class="btn btn-primary btn-sm">
                                    <i class="fas fa-folder-open"></i> Choisir le fichier
                                </label>
                                <input type="file"
                                       id="signature_scan"
                                       name="signature_scan"
                                       accept="image/*,.pdf"
                                       style="display:none"
                                       required>
                                <p class="text-muted mt-2 mb-0">
                                    <small>JPG, PNG, PDF — Max 5MB</small>
                                </p>
                                <p id="file-name" class="text-success mt-1 mb-0 font-weight-bold"></p>
                            </div>
                        </div>
                        @error('signature_scan')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Preview --}}
                    <div id="preview-container" class="mb-3" style="display:none">
                        <label><i class="fas fa-eye"></i> Aperçu du scan:</label>
                        <div class="border rounded p-2 text-center">
                            <img id="preview-img" src="" class="img-fluid"
                                 style="max-height:400px" alt="Aperçu">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Observations</label>
                        <textarea name="observations" class="form-control" rows="3"
                                  placeholder="Notes éventuelles...">{{ old('observations') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg btn-block">
                        <i class="fas fa-check-double"></i>
                        Confirmer la validation finale
                    </button>
                    <a href="{{ route('trainees.show', $trainee) }}"
                       class="btn btn-secondary btn-block mt-2">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    // File selection & preview
    $('#signature_scan').on('change', function() {
        var file = this.files[0];
        if (!file) return;

        // اسم الملف
        $('#file-name').text('✓ ' + file.name);

        // Preview للصور
        if (file.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-img').attr('src', e.target.result);
                $('#preview-container').show();
            };
            reader.readAsDataURL(file);
        } else {
            // PDF
            $('#preview-container').hide();
            $('#file-name').text('✓ PDF: ' + file.name);
        }
    });

    // Click على Drop zone
    $('#drop-zone').on('click', function() {
        $('#signature_scan').trigger('click');
    });

    // Drag & Drop support
    $('#drop-zone').on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('border-primary bg-light');
    });

    $('#drop-zone').on('dragleave drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('border-primary bg-light');
    });

    $('#drop-zone').on('drop', function(e) {
        var files = e.originalEvent.dataTransfer.files;
        if(files.length) $('#signature_scan')[0].files = files;
        $('#signature_scan').trigger('change');
    });
</script>
@stop