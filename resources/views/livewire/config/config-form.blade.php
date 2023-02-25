@section('title', 'Configurar')
@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/src/plugins/src/sweetalerts2/sweetalerts2.css">
@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Configurar</li>
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
                        <div class="col">
                            <div class="col-xl-12">
                                <h4>Configurar algunas cosas</h4>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end">

                        </div>
                    </div>

                </div>
                <div class="widget-content widget-content-area">

                    <form wire:submit.prevent="save">
                        <div class="form-group row mb-3">
                            <label for="periodo" class="col-sm-2 col-form-label">Periodo</label>
                            <div class="col-sm-6">
                                <input type="text" wire:model="periodo" class="form-control @error('periodo') is-invalid @enderror" id="periodo">
                                @error('periodo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="logotipo" class="col-sm-2 col-form-label">Logotipo</label>
                            <div class="col-sm-6">
                                @if ($logotipo)
                                <a wire:click="$set('logotipo', null)" class="btn btn-warning">Quitar</a>
                                <img src="{{ $logotipo->temporaryUrl() }}" height="150px" alt="...">
                                @elseif ($logoGuardar != null)
                                <a class="btn btn-danger" wire:click="deleteImg">Quitar</a>
                                <img src="{{ Storage::disk('public')->url($logoGuardar->value) }}" height="150px" alt="...">
                                @else
                                Selecciona una imagen
                                @endif
                                <input type="file" wire:model="logotipo" class="form-control @error('logotipo') is-invalid @enderror" id="logotipo">
                                @error('logotipo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary" type="submit">Guardar</button>
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
<script type="text/javascript">
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

@if(session()->has('message'))
<script>
    Snackbar.show({
        showAction: false,
        text: "{{ session('message') }}",
        pos: 'top-center',
        actionTextColor: '#fff',
        backgroundColor: '#00ab55',

    });
</script>
@endif

@endpush