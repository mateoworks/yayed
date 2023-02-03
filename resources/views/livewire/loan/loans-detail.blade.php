@section('title', 'Reporte de prestamo: ' . $loan->id)
@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

<link href="/src/assets/css/light/apps/invoice-preview.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/apps/invoice-preview.css" rel="stylesheet" type="text/css" />
<style>
    .invoice-container {
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        color: black;
    }
</style>
@endpush
<div class="middle-content container-xxl p-0">

    <div class="row invoice layout-top-spacing layout-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="doc-container">

                <div class="row">

                    <div class="col-xl-9">

                        <div class="invoice-container">
                            <div class="invoice-inbox">

                                <div id="ct" class="">

                                    <div class="invoice-00001">
                                        <div class="content-section">

                                            <div class="inv--head-section inv--detail-section">

                                                <table style="width:100%">
                                                    <tr>
                                                        <td>
                                                            <img src="{{ url('src/assets/img/cork-logo.png') }}" height="150" alt="">
                                                        </td>
                                                        <td>
                                                            <h4 class="m-0">CAJA DE</h4>
                                                            <h4 class="m-0">PRÉSTAMOS</h4>
                                                            <h4 class="m-0">YA' YED</h4>
                                                            <p class="m-0">
                                                                C. Independencia S/N, San Baltazar Loxicha
                                                            </p>
                                                        </td>
                                                        <td class="text-end">

                                                            <h5>Reporte de préstamo</h5>
                                                            <h6 style="color: red;">{{ $loan->number }}</h6>
                                                            <p>Fecha de emisión: {{ \Carbon\Carbon::now() }}</p>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>

                                            <div class="inv--detail-section inv--customer-detail-section">

                                                <table style="width:100%">
                                                    <tr>
                                                        <td>
                                                            <strong>Socio</strong>
                                                            <p class="m-0">{{ $loan->partner->full_name }}</p>
                                                            <p class="m-0">{{ $loan->partner->address }}</p>
                                                            <p class="m-0">{{ $loan->partner->phone }}</p>
                                                        </td>
                                                        <td class="text-end">
                                                            <strong>Detalles del préstamo</strong>
                                                            <p class="m-0">$ {{ number_format($loan->amount, 2) }}</p>
                                                            <p class="m-0">Otorgado: {{ $loan->date_made->format('Y-m-d') }}</p>
                                                            <p class="m-0">Interés: {{ $loan->interest }}%</p>
                                                            <p class="m-0">Programado pago: {{ $loan->date_payment->format('Y-m-d') }}</p>
                                                            @if ($loan->status == 'activo')
                                                            <span class="fs-6 badge badge-light-primary">Activo</span>
                                                            @elseif ($loan->status == 'suspendido')
                                                            <span class="fs-6 badge badge-light-danger">Suspendido</span>
                                                            @elseif ($loan->status == 'liquidado')
                                                            <span class="fs-6 badge badge-light-success">Liquidado</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="inv--product-table-section">

                                                @if ($loan->payments->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="">
                                                            <tr>
                                                                <th scope="col">No</th>
                                                                <th scope="col">Fecha programada</th>
                                                                <th class="text-end" scope="col">Fecha realizada</th>
                                                                <th class="text-end" scope="col">Cantidad capital</th>
                                                                <th class="text-end" scope="col">Cantidad interés</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $i = 1;
                                                            $capital_pagado = 0;
                                                            @endphp
                                                            @foreach ($loan->payments as $payment)
                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <td>{{ $payment->scheduled_date->format('Y-m-d') }}</td>
                                                                <td class="text-end">{{ $payment->made_date->format('Y-m-d') }}</td>
                                                                <td class="text-end">$ {{ number_format($payment->principal_amount, 2) }}</td>
                                                                <td class="text-end">$ {{ number_format($payment->interest_amount, 2) }}</td>
                                                                @php
                                                                $capital_pagado += $payment->principal_amount;
                                                                @endphp
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="inv--total-amounts">

                                                    <div class="row mt-4">
                                                        <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                        </div>
                                                        <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                            <div class="text-sm-end">
                                                                <div class="row">
                                                                    <div class="col-sm-8 col-7">
                                                                        <p class="">Total capital pagado :</p>
                                                                    </div>
                                                                    <div class="col-sm-4 col-5">
                                                                        <p class="">$ {{ number_format($loan->payments->sum('principal_amount'), 2) }}</p>
                                                                    </div>
                                                                    <div class="col-sm-8 col-7">
                                                                        <p class="">Pendiente capital :</p>
                                                                    </div>
                                                                    <div class="col-sm-4 col-5">
                                                                        <p class="">$ {{ number_format($loan->amount - $capital_pagado, 2) }}</p>
                                                                    </div>
                                                                    <div class="col-sm-8 col-7">
                                                                        <p class="">Total interés pagado :</p>
                                                                    </div>
                                                                    <div class="col-sm-4 col-5">
                                                                        <p class="">$ {{ number_format($loan->payments->sum('interest_amount'), 2) }}</p>
                                                                    </div>
                                                                    <div class="col-sm-8 col-7">
                                                                        <p class="">Pagos por otros conceptos :</p>
                                                                    </div>
                                                                    <div class="col-sm-4 col-5">
                                                                        <p class="">$ {{ number_format($loan->payments->sum('other_amount'), 2) }}</p>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                @else
                                                <h6 class="ms-4">No se han realizado pagos aún</h6>
                                                @endif
                                            </div>

                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>

                    <div class="col-xl-3">

                        <div class="invoice-actions-btn">

                            <div class="invoice-action-btn">

                                <div class="row">
                                    <div class="col-xl-12 col-md-3 col-sm-6">
                                        <a href="javascript:void(0);" class="btn btn-secondary btn-print  action-print">
                                            <i class="fa-light fa-print"></i>
                                            Imprimir
                                        </a>
                                    </div>
                                    <div class="col-xl-12 col-md-3 col-sm-6">
                                        <a wire:click="exportPDF" class="btn btn-danger btn-print action-print">
                                            <i class="fa-light fa-file-pdf"></i>
                                            PDF
                                        </a>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

@push('scripts')
<script src="/src/assets/js/apps/invoice-preview.js"></script>
@endpush