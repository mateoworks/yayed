@section('title', 'Pago: ' . $payment->numero)

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
                <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Pagos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pago número {{ $payment->numero }}</li>
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
                                    <h4>Detalles del pago</h4>

                                </div>
                                <div class="mt-3 me-3">
                                    <a href="{{ route('loans.show', $payment->loan) }}" class="btn btn-primary bs-tooltip" data-toggle="tooltip" data-placement="top" title="Ver préstamo">
                                        <i class="d-inline fa-regular fa-hand-holding-dollar"></i>
                                    </a>
                                    <a wire:click="exportPDF" class="btn btn-danger bs-tooltip" data-toggle="tooltip" data-placement="top" title="Generar comprobante">
                                        <i class="fa-light fa-file-pdf"></i>
                                    </a>
                                    <a href="" class="btn btn-secondary bs-tooltip" data-toggle="tooltip" data-placement="top" title="Editar pago">
                                        <i class="fa-light fa-pen-to-square"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h6>Datos del socio</h6>
                                    <p class="m-0">{{ $payment->loan->partner->full_name }}</p>
                                    <p class="m-0">{{ $payment->loan->partner->address }}</p>
                                    <p class="m-0">{{ $payment->loan->partner->phone }}</p>
                                </div>
                                <div class="col">
                                    <h6>Datos del préstamo</h6>
                                    <p class="m-0">Capital: ${{number_format($payment->loan->amount, 2) }}</p>
                                    <p class="m-0">Fecha de préstamo: {{ $payment->loan->date_made->format('Y-m-d') }}</p>
                                    <p class="m-0">Total capital pagado: ${{ number_format($payment->loan->payments->sum('principal_amount'), 2) }}</p>
                                    <p class="m-0"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="m-3">Datos del pago realizado, número: <span class="text-danger">{{ $payment->numero }}</span></h4>
                    <table>
                        <tr>
                            <td>Fecha programada:</td>
                            <td>{{ $payment->scheduled_date->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <td>Fecha realizada:</td>
                            <td>{{ $payment->made_date->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <td>Contribución social:</td>
                            <td>{{ $payment->social_contribution }}</td>
                        </tr>
                        <tr>
                            <td>Periodo:</td>
                            <td>{{ $payment->period }}</td>
                        </tr>
                        <tr>
                            <td>Concepto:</td>
                            <td>{{ $payment->concept }}</td>
                        </tr>
                    </table>
                    <table class="table">
                        <thead>
                            <th>NP</th>
                            <th>Concepto</th>
                            <th>Importe</th>
                        </thead>
                        <tr>
                            <td>1</td>
                            <td>Pago de capital</td>
                            <td>$ {{ number_format($payment->principal_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Pago de interés</td>
                            <td>$ {{ number_format($payment->interest_amount, 2) }}</td>
                        </tr>
                        @if ($payment->other)
                        <tr>
                            <td>3</td>
                            <td>{{ $payment->other }}</td>
                            <td>$ {{ number_format(other_amount, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td></td>
                            <td class="text-end">
                                <h4>Total</h4>
                            </td>
                            @php
                            $total = $payment->principal_amount + $payment->interest_amount + $payment->other_amount;
                            @endphp
                            <td>
                                <h4>${{ number_format($total, 2) }}</h4>
                            </td>
                        </tr>
                    </table>
                    <h6>Observaciones</h6>
                    <p>{{ $payment->observations }}</p>
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