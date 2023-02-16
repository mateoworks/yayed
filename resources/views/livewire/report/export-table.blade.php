@section('title', 'Reportes')

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/src/plugins/src/sweetalerts2/sweetalerts2.css">
<link rel="stylesheet" type="text/css" href="/src/assets/css/light/elements/alert.css">
<link rel="stylesheet" type="text/css" href="/src/assets/css/dark/elements/alert.css">

<link rel="stylesheet" type="text/css" href="/src/assets/css/light/forms/switches.css">
<link rel="stylesheet" type="text/css" href="/src/assets/css/dark/forms/switches.css">
@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Generar reportes</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->

    <!-- CONTENT AREA -->
    <div class="row layout-top-spacing">

        <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>Selecciona que cos quiere tu exportar</h4>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area">

                    <form class="row g-3">
                        <div class="col-md-3">
                            <div class="switch form-switch-custom switch-inline form-switch-primary">
                                <input wire:model="table.PartnersExport" class="switch-input" type="checkbox" role="switch" id="form-custom-switch-checked" checked>
                                <label class="switch-label" for="form-custom-switch-checked">Socios</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="switch form-switch-custom switch-inline form-switch-primary">
                                <input wire:model="table.SolicitudsExport" class="switch-input" type="checkbox" role="switch" id="form-custom-switch-checked" checked>
                                <label class="switch-label" for="form-custom-switch-checked">Solicitudes</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="switch form-switch-custom switch-inline form-switch-primary">
                                <input wire:model="table.LoansExport" class="switch-input" type="checkbox" role="switch" id="form-custom-switch-checked" checked>
                                <label class="switch-label" for="form-custom-switch-checked">Préstamos</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="switch form-switch-custom switch-inline form-switch-primary">
                                <input wire:model="table.PaymentsExport" class="switch-input" type="checkbox" role="switch" id="form-custom-switch-checked" checked>
                                <label class="switch-label" for="form-custom-switch-checked">Pagos</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="switch form-switch-custom switch-inline form-switch-primary">
                                <input wire:model="table.EndorsmentsExport" class="switch-input" type="checkbox" role="switch" id="form-custom-switch-checked" checked>
                                <label class="switch-label" for="form-custom-switch-checked">Avales</label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <label for="periodo" class="form-label">Por periodo</label>
                            <select type="date" wire:model="periodo" class="form-select" id="periodo" wire:change="porPeriodo">
                                <option selected>Desde el origen de los tiempos</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                            @error('periodo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        @if ($porPeriodoSelect)
                        <div class="col-md-5">
                            <label for="start" class="form-label">Fecha de inicio</label>
                            <input wire:model="dateStart" type="date" class="form-control @error('dateStart') is-invalid @enderror" id="start">
                            @error('dateStart')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label for="end" class="form-label">Fecha de término</label>
                            <input wire:model="dateEnd" type="date" class="form-control @error('dateEnd') is-invalid @enderror" id="end">
                            @error('dateEnd')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif

                        <div class="col-md-3">
                            <button type="button" wire:click="exportar" class="btn btn-primary">
                                <div wire:loading wire:target="exportar">
                                    <div class="spinner-border text-white me-2 align-self-center loader-sm "></div>
                                </div>
                                Exportar
                            </button>
                        </div>
                    </form>


                </div>

            </div>
        </div>



    </div>
    <!-- CONTENT AREA -->
</div>

@push('scripts')
<script src="/src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

    });

    window.addEventListener('message', event => {
        Snackbar.show({
            showAction: false,
            text: event.detail.message,
            pos: 'top-center',
            actionTextColor: '#fff',
            backgroundColor: '#00ab55',

        });
    });
</script>

@endpush