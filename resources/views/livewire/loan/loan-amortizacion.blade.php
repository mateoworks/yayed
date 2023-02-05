@section('title', 'Generar tabla amortización: ' . $loan->number)

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
                <li class="breadcrumb-item"><a href="{{ route('loans.show', $loan) }}">{{ $loan->number }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tabla amortización</li>
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
                                    <h4>Generar tabla de amortización para {{ $loan->partner->full_name }}</h4>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col">
                            <p>El total del capital es de {{ $loan->amount }}</p>
                            <h6>Fecha otorgada: {{ $loan->date_made->format('Y-m-d') }}</h6>
                            <h6>Fecha otorgada: {{ $loan->date_payment->format('Y-m-d') }}</h6>
                            <a href="{{ route('loans.show', $loan) }}" class="btn btn-info">Más datos del préstamo</a>
                            <hr>
                            <p>Para realizar el calculo, ingrese el número de periodos si es que el calculado es diferente</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group row mb-4">
                            <label for="periodos" class="col-sm-4 col-form-label">Número de periodos</label>
                            <div class="col-sm-4">
                                <input type="number" wire:model.defer="periodos" class="form-control @error('periodos') is-invalid @enderror" id="periodos">
                                @error('periodos')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-sm-3">
                                <button type="button" wire:click="generar" class="btn btn-secondary">Generar</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lx-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>Periodos</th>
                                        <th>Fecha programada</th>
                                        <th>Saldo inicial</th>
                                        <th>Interés</th>
                                        <th>Amortización</th>
                                        <th>Saldo a pagar</th>
                                        <th>Saldo final</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>${{ number_format($loan->amount, 2) }}</td>
                                        </tr>
                                        @foreach ($amortizacion as $amor)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $amor->fecha->addMonth()->format('d/m/Y') }}</td>
                                            <td>${{ number_format($amor->saldoInicial, 2) }}</td>
                                            <td>${{ number_format($amor->interes, 2) }}</td>
                                            <td>${{ number_format($amor->amortizacion, 2) }}</td>
                                            <td>${{ number_format($amor->saldoPagar, 2) }}</td>
                                            <td>${{ number_format($amor->saldoFinal, 2) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Sumas</td>
                                            <td>${{ number_format($sumInteres, 2) }}</td>
                                            <td>${{ number_format($sumAmortizacion, 2) }}</td>
                                            <td>${{ number_format($sumInteres + $sumAmortizacion, 2) }}</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if(!empty($amortizacion))
                                <button class="btn btn-danger" wire:click="exportPDF">
                                    <i class="fa-light fa-file-pdf"></i>
                                </button>

                                <a class="btn btn-success" wire:click="exportExcel">
                                    <i class="fa-light fa-file-pdf"></i>
                                </a>
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