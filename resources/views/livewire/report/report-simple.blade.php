@section('title', 'Reportes')

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
                <li class="breadcrumb-item active" aria-current="page">Generar reportes mensuales</li>
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
                                    <h4>Reporte por mes</h4>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">


                    <form class="row g-3">
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
                        <div class="col-md-2">
                            <button type="button" wire:click="generar" class="btn btn-primary">Generar</button>
                        </div>
                    </form>


                </div>

            </div>
        </div>

        <div id="tableCustomBasic" class="col-lg-6 col-6 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>Préstamos</h4>

                                </div>
                            </div>
                            <div class="widget-content widget-content-area">

                                <table class="table">
                                    <thead>
                                        <th>Mes</th>
                                        <th>Monto</th>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalPrestamo = 0;
                                        @endphp
                                        @foreach ($prestamosPorMes as $capital)
                                        <tr>
                                            <td>{{ $capital->mes != null ? ucfirst($months[$capital->mes]) : '' }} {{ $capital->anio }}</td>
                                            <td class="text-end">${{ number_format($capital->capital, 2) }}</td>
                                            @php
                                            $totalPrestamo += $capital->capital;
                                            @endphp
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-end">${{ number_format($totalPrestamo, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="tableCustomBasic" class="col-lg-6 col-6 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>Intereses</h4>

                                </div>
                            </div>
                            <div class="widget-content widget-content-area">

                                <table class="table">
                                    <thead>
                                        <th>Mes</th>
                                        <th>Monto</th>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalInteres = 0;
                                        @endphp
                                        @foreach ($interesPorMes as $interes)
                                        <tr>
                                            <td>{{ $capital->mes != null ? ucfirst($months[$capital->mes]) : '' }} {{ $interes->anio }}</td>
                                            <td class="text-end">${{ number_format($interes->interes, 2) }}</td>
                                            @php
                                            $totalInteres += $interes->interes;
                                            @endphp
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-end">{{ number_format($totalInteres, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="tableCustomBasic" class="col-lg-6 col-6 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>Aportación social</h4>

                                </div>
                            </div>
                            <div class="widget-content widget-content-area">

                                <table class="table">
                                    <thead>
                                        <th>Mes</th>
                                        <th>Monto</th>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalAportacion = 0;
                                        @endphp
                                        @foreach ($aportacionPorMes as $aportacion)
                                        <tr>
                                            <td>{{ $aportacion->mes != null ? ucfirst($months[$aportacion->mes]) : '' }} {{ $aportacion->anio }}</td>
                                            <td class="text-end">${{ number_format($aportacion->aportacion, 2) }}</td>
                                            @php
                                            $totalAportacion += $aportacion->aportacion;
                                            @endphp
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-end">${{ number_format($totalAportacion, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="tableCustomBasic" class="col-lg-6 col-6 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>Capital recuperado en préstamo</h4>

                                </div>
                            </div>
                            <div class="widget-content widget-content-area">

                                <table class="table">
                                    <thead>
                                        <th>Mes</th>
                                        <th>Monto</th>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalCapital = 0;
                                        @endphp
                                        @foreach ($capitalPorMes as $capital)
                                        <tr>
                                            <td>{{ $capital->mes != null ? ucfirst($months[$capital->mes]) : '' }} {{ $capital->anio }}</td>
                                            <td class="text-end">${{ number_format($capital->capital, 2) }}</td>
                                            @php
                                            $totalCapital += $capital->capital;
                                            @endphp
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-end">{{ number_format($totalCapital, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4> Pagos realizados en el periodo</h4>

                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Fecha realizada</th>
                                        <th>Socio</th>
                                        <th>Cantidad capital pagado</th>
                                        <th>Cantidad interés pagado</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($pagos as $p)
                                        <tr>
                                            <td>{{ $p->made_date->format('d/m/Y') }}</td>
                                            <td>{{ $p->loan->partner->full_name }}</td>
                                            <td class="text-end">${{ number_format($p->principal_amount, 2) }}</td>
                                            <td class="text-end">${{ number_format($p->interest_amount, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

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