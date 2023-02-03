@section('title', 'Generar plan de pago: ' . $loan->id)

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/src/plugins/src/sweetalerts2/sweetalerts2.css">
<link rel="stylesheet" type="text/css" href="/src/assets/css/light/elements/alert.css">
<link rel="stylesheet" type="text/css" href="/src/assets/css/dark/elements/alert.css">
@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('loans.index') }}">Prestamos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Plan de pago</li>
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
                                    <h4>Generar plan de pago para {{ $loan->partner->full_name }}</h4>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col">
                            <p>El total del capital es de {{ $loan->amount }}, fecha de prestamo: {{ $loan->date_made }}</p>
                            <a href="{{ route('loans.show', $loan) }}" class="btn btn-info">Más datos del préstamo</a>
                            <hr>
                            <p>Para realizar el plan, solamente tiene que ingresar la cantidad del capital que el socio se compromete a pagar cada mes</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group row mb-4">
                            <label for="cantidadCapitalMes" class="col-sm-4 col-form-label">Cantidad capital a pagar por mes</label>
                            <div class="col-sm-4">
                                <input type="number" wire:model.defer="cantidadCapitalMes" class="form-control @error('cantidadCapitalMes') is-invalid @enderror" id="cantidadCapitalMes">
                                @error('cantidadCapitalMes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-sm-3">
                                <button type="button" wire:click.prevent="generar" class="btn btn-secondary">Generar</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lx-12">
                                <table class="table">
                                    <thead>
                                        <th>N° pago</th>
                                        <th>Fecha programada</th>
                                        <th>Capital actual</th>
                                        <th>Pago de capital</th>
                                        <th>Pago de interés</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($plan as $p)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $p->mes->addMonth()->format('Y-m-d') }}</td>
                                            <td>${{ number_format($p->capital, 2) }}</td>
                                            <td>${{ number_format($p->pagoCapital, 2) }}</td>
                                            <td>${{ number_format($p->interes, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if(!empty($plan))
                                <button class="btn btn-danger" wire:click.prevent="createPDF">
                                    <i class="fa-light fa-file-pdf"></i>
                                </button>
                                @endif
                            </div>

                        </div>


                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- CONTENT AREA -->
</div>

@push('scripts')
<script src="/src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>


@endpush