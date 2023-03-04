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
                                    <a href="" class="btn btn-info bs-tooltip" data-toggle="tooltip" data-placement="top" title="Editar pago">
                                        <i class="fa-light fa-pen-to-square"></i>
                                    </a>
                                    <a href="{{ route('loans.show', $payment->loan) }}" class="btn btn-primary bs-tooltip" data-toggle="tooltip" data-placement="top" title="Ver préstamo">
                                        <i class="d-inline fa-regular fa-hand-holding-dollar"></i>
                                    </a>
                                    <a wire:click="exportPDF" class="btn btn-danger bs-tooltip" data-toggle="tooltip" data-placement="top" title="Generar comprobante">
                                        <div wire:loading wire:target="exportPDF">
                                            <div class="spinner-border text-white me-2 align-self-center loader-sm "></div>
                                        </div>
                                        <i class="fa-light fa-file-pdf"></i>
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
                                <div class="col-md-5">
                                    <h6>Datos del socio</h6>

                                    <a href="{{ route('partners.show', $payment->loan->partner) }}">
                                        <div class="media">
                                            <div class="avatar me-2">
                                                @if ($payment->loan->partner->image)
                                                <img alt="avatar" src="{{ Storage::disk('public')->url($payment->loan->partner->image) }}" class="rounded-circle" />
                                                @else
                                                <span class="avatar-title rounded-circle bg-primary">{{ $payment->loan->partner->names[0] ?? '' }}{{ $payment->loan->partner->surname_father[0] }}</span>
                                                @endif
                                            </div>
                                            <div class="media-body align-self-center">
                                                <h6 class="mb-0">{{ $payment->loan->partner->full_name }}</h6>
                                                <span><i class="fa-regular fa-phone"></i> {{ $payment->loan->partner->phone }}</span>
                                                <p>{{ $payment->loan->partner->address }}</p>
                                                <p>Contribución social: <strong>${{ $payment->loan->partner->social_contribution }}</strong></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-5">
                                    <h6>Datos del préstamo</h6>
                                    <p class="m-0">Folio: {{ $payment->loan->number }}</p>
                                    <p class="m-0">Capital: ${{number_format($payment->loan->amount, 2) }}</p>
                                    <p class="m-0">Fecha de préstamo: {{ $payment->loan->date_made->format('d/m/Y') }}</p>
                                    <p class="m-0">Total capital pagado: ${{ number_format($payment->loan->payments->sum('principal_amount'), 2) }}</p>
                                    @if($payment->loan->ultimo_pago)
                                    <p class="m-0">Fecha de último pago: {{ $payment->loan->ultimo_pago->made_date->format('d/m/Y') }}</p>
                                    @endif
                                    <a href="{{ route('loans.show', $payment->loan) }}" class="btn btn-primary">Ver préstamo</a>
                                    @if ($payment->loan->status != 'liquidado')
                                    <a href="{{ route('payments.create', $payment->loan) }}" class="btn btn-secondary">
                                        Realizar otro pago de este préstamo
                                    </a>
                                    @endif

                                </div>
                                <div class="col-md-2">
                                    @if ($payment->loan->status == 'activo')
                                    <span class="fs-3 badge badge-light-primary">Activo</span>
                                    @elseif ($payment->loan->status == 'suspendido')
                                    <span class="fs-3 badge badge-light-danger">Suspendido</span>
                                    @elseif ($payment->loan->status == 'liquidado')
                                    <span class="fs-3 badge badge-light-success">Liquidado</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="m-3">Datos del pago realizado, número: <span class="text-danger">{{ $payment->numero }}</span></h4>
                    <table>
                        <tr>
                            <td>Fecha programada:</td>
                            <td>
                                <p><strong>{{ $payment->scheduled_date->format('d/m/Y') }}</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td>Fecha realizada:</td>
                            <td>
                                <p><strong>{{ $payment->made_date->format('d/m/Y') }}</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td>Contribución social:</td>
                            <td>
                                <p><strong>{{ $payment->social_contribution }}</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td>Periodo:</td>
                            <td>
                                <p><strong>{{ $payment->period }}</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td>Concepto:</td>
                            <td>
                                <p><strong>{{ $payment->concept }}</strong></p>
                            </td>
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
                            <td class="text-end">$ {{ number_format($payment->principal_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Pago de interés</td>
                            <td class="text-end">$ {{ number_format($payment->interest_amount, 2) }}</td>
                        </tr>
                        @if ($payment->other)
                        <tr>
                            <td>3</td>
                            <td>{{ $payment->other }}</td>
                            <td class="text-end">$ {{ number_format(other_amount, 2) }}</td>
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
                            <td class="text-end">
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