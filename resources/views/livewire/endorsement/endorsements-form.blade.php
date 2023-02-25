@section('title', 'Registrar movimiento')

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/css/light/loaders/custom-loader.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/dark/loaders/custom-loader.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/src/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="/src/plugins/src/select2/css/select2.min.css">

@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('endorsements.index') }}">Avales</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registrar aval</li>
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
                            <h4>Guardar aval
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">


                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <div class="row">

                        <form wire:submit.prevent="save">
                            <div class="form-group row mb-3">
                                <label for="endorsement.names" class="col-sm-3 col-form-label">Nombre del aval</label>
                                <div class="col-sm-4">
                                    <input type="text" wire:model="endorsement.names" class="form-control @error('endorsement.names') is-invalid @enderror" id="endorsement.names">
                                    @error('endorsement.names')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="endorsement.surnames" class="col-sm-3 col-form-label">Apellidos</label>
                                <div class="col-sm-4">
                                    <input type="text" wire:model="endorsement.surnames" class="form-control @error('endorsement.surnames') is-invalid @enderror" id="endorsement.surnames">
                                    @error('endorsement.surnames')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="endorsement.phone" class="col-sm-3 col-form-label">Teléfono</label>
                                <div class="col-sm-4">
                                    <input type="text" wire:model="endorsement.phone" class="form-control @error('endorsement.phone') is-invalid @enderror" id="endorsement.phone">
                                    @error('endorsement.phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="endorsement.address" class="col-sm-3 col-form-label">Dirección</label>
                                <div class="col-sm-4">
                                    <input type="text" wire:model="endorsement.address" class="form-control @error('endorsement.address') is-invalid @enderror" id="endorsement.address">
                                    @error('endorsement.address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="endorsement.key_ine" class="col-sm-3 col-form-label">Clave INE</label>
                                <div class="col-sm-4">
                                    <input type="text" wire:model="endorsement.key_ine" class="form-control @error('endorsement.key_ine') is-invalid @enderror" id="endorsement.key_ine">
                                    @error('endorsement.key_ine')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <button class="btn btn-primary" type="submit">Registrar</button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- CONTENT AREA -->
</div>