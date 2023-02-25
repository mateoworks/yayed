@section('title', 'Registrar movimiento')

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/css/light/loaders/custom-loader.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/dark/loaders/custom-loader.css" rel="stylesheet" type="text/css" />

@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('job.index') }}">Ocupaciones</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registrar ocupación</li>
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
                            <h4>Guardar ocupacón
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
                                <label for="job.name" class="col-sm-3 col-form-label">Nombre de la ocupacion</label>
                                <div class="col-sm-4">
                                    <input type="text" wire:model="job.name" class="form-control @error('job.name') is-invalid @enderror" id="job.name">
                                    @error('job.name')
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