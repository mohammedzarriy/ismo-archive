@extends('adminlte::page')
@section('title', 'Ajouter un document')
@section('content_header')
    <h1><i class="fas fa-plus"></i> Nouveau retrait — Baccalauréat</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('documents.store') }}" method="POST" id="doc-form">
            @csrf

            {{-- Recherche par CIN ou CEF --}}
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text"
                               id="search-trainee"
                               class="form-control form-control-lg"
                               placeholder="Rechercher par CIN ou CEF...">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" id="btn-search">
                                Rechercher
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- نتائج البحث --}}
            <div id="search-results" class="mb-4" style="display:none">
                <div class="alert alert-info">
                    <strong><i class="fas fa-user"></i> Stagiaire trouvé:</strong>
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <small class="text-muted">Nom complet</small>
                            <p class="mb-0 font-weight-bold" id="res-name">—</p>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">CIN</small>
                            <p class="mb-0" id="res-cin">—</p>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">CEF</small>
                            <p class="mb-0" id="res-cef">—</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Filière</small>
                            <p class="mb-0" id="res-filiere">—</p>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Groupe</small>
                            <p class="mb-0" id="res-group">—</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- رسالة إذا ما لقاش --}}
            <div id="not-found" class="alert alert-danger" style="display:none">
                <i class="fas fa-times-circle"></i> Aucun stagiaire trouvé avec ce CIN ou CEF.
            </div>

            {{-- الفورم الحقيقي --}}
            <div id="form-fields" style="display:none">
                <input type="hidden" name="trainee_id" id="trainee-id">
                <input type="hidden" name="type" value="Bac">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type de retrait <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card border-warning text-center p-3 retrait-option"
                                         data-value="Temp_Out"
                                         style="cursor:pointer">
                                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                        <strong>Temporaire</strong>
                                        <small class="text-muted">Retour obligatoire dans 48h</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-danger text-center p-3 retrait-option"
                                         data-value="Final_Out"
                                         style="cursor:pointer">
                                        <i class="fas fa-sign-out-alt fa-2x text-danger mb-2"></i>
                                        <strong>Définitif</strong>
                                        <small class="text-muted">Remis définitivement</small>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="bac_status" id="bac-status" required>
                            <div id="status-error" class="text-danger mt-1" style="display:none">
                                Veuillez choisir un type de retrait
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Numéro de référence</label>
                            <input type="text" name="reference_number"
                                   class="form-control"
                                   placeholder="Optionnel">
                        </div>
                        <div class="form-group">
                            <label>Observations</label>
                            <textarea name="observations" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-lg" id="btn-submit">
                        <i class="fas fa-save"></i> Enregistrer le retrait
                    </button>
                    <a href="{{ route('documents.index') }}" class="btn btn-secondary btn-lg ml-2">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>
@stop

@section('js')
<script>
// البحث عن المتدرب
$('#btn-search, #search-trainee').on('click keypress', function(e) {
    if (e.type === 'keypress' && e.which !== 13) return;

    var query = $('#search-trainee').val().trim();
    if (!query) return;

    $.get('/search?q=' + encodeURIComponent(query), function(data) {
        if (data.length === 0) {
            $('#search-results').hide();
            $('#not-found').show();
            $('#form-fields').hide();
            return;
        }

        var t = data[0];
        $('#not-found').hide();
        $('#search-results').show();
        $('#res-name').text(t.name);
        $('#res-cin').text(t.cin);
        $('#res-cef').text(t.cef);
        $('#res-filiere').text(t.filiere);
        $('#res-group').text(t.group ?? '—');
        $('#trainee-id').val(t.id);
        $('#form-fields').show();

        // Reset selection
        $('.retrait-option').removeClass('border-selected').css('background','');
        $('#bac-status').val('');
    });
});

// اختيار نوع الرتريت
$('.retrait-option').on('click', function() {
    $('.retrait-option').css({
        'background': '',
        'border-width': '1px'
    });
    $(this).css({
        'background': $(this).data('value') === 'Temp_Out' ? '#fff3cd' : '#f8d7da',
        'border-width': '3px'
    });
    $('#bac-status').val($(this).data('value'));
    $('#status-error').hide();
});

// Validation قبل submit
$('#doc-form').on('submit', function(e) {
    if (!$('#bac-status').val()) {
        e.preventDefault();
        $('#status-error').show();
        $('html, body').animate({
            scrollTop: $('#status-error').offset().top - 100
        }, 300);
    }
});
</script>
@stop