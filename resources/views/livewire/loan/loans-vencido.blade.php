@section('title', 'Préstamos vencidos')
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
                <li class="breadcrumb-item active" aria-current="page">Prestamos</li>
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
                                <h4>Lista de prestamos vencidos</h4>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <button class="btn btn-success mt-2 me-4" wire:click="exportExcel">
                                <div wire:loading wire:target="exportExcel">
                                    <div class="spinner-border text-white me-2 align-self-center loader-sm"></div>
                                </div>
                                <i class="fa-light fa-file-excel"></i>
                            </button>

                            <button class="btn btn-danger mt-2 me-4" wire:click="exportPDF">
                                <div wire:loading wire:target="exportPDF">
                                    <div class="spinner-border text-white me-2 align-self-center loader-sm"></div>
                                </div>
                                <i class="fa-light fa-file-pdf"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-3">
                            <form wire:submit.prevent="consultarBD">
                                <label for="numDias">Número de días</label>
                                <input type="number" wire:model.defer="noDias" id="numDias" class="form-control">
                                <button type="submit" class="btn btn-primary">Consultar</button>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th scope="col">Socio</th>
                                    <th scope="col">Último pago realizado</th>
                                    <th scope="col">Capital</th>
                                    <th scope="col">Capital pagado</th>
                                    <th scope="col">Capital pendiente</th>

                                    <th class="text-center" scope="col">Estado</th>
                                    <th class="text-center" scope="col"></th>
                                </tr>

                            </thead>
                            <tbody>

                                @foreach ($prestamosVencidos as $loan)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <a href="{{ route('partners.show', $loan->partner_id) }}">
                                            <div class="media">
                                                <div class="media-body align-self-center">
                                                    <h6 class="mb-0">{{ $loan->full_name }}</h6>
                                                    <span><i class="fa-regular fa-phone"></i> {{ $loan->phone }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    @php
                                    $ultimoPago = \Carbon\Carbon::parse($loan->ultimo_pago);
                                    @endphp
                                    <td>
                                        <p class="m-0">
                                            <i class="fa-light fa-calendar-days"></i>
                                            {{ $ultimoPago->format('d/m/Y') }}<br>
                                            {{ $ultimoPago->diffForHumans() }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-end">$ {{ number_format($loan->amount, 2) }}</p>
                                    </td>
                                    <td>
                                        <p class="text-end">$ {{ number_format($loan->capital_pagado, 2) }}</p>
                                    </td>
                                    <td>
                                        <p class="text-end">$ {{ number_format($loan->amount - $loan->capital_pagado, 2) }}</p>
                                    </td>

                                    <td class="text-center">
                                        @switch($loan->status)
                                        @case('activo')
                                        <span class="badge badge-light-primary">Activo</span>
                                        @break
                                        @case('suspendido')
                                        <span class="badge badge-light-danger">Suspendido</span>
                                        @break
                                        @case('liquidado')
                                        <span class="badge badge-light-success">Liquidado</span>
                                        @break
                                        @default
                                        Otra situacion
                                        @endswitch

                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            @if ($loan->status == 'activo' || $loan->status == 'suspendido')
                                            <a href="{{ route('payments.create', $loan->id) }}" class="bs-tooltip btn btn-success" data-toggle="tooltip" data-placement="top" title="Realizar pago">
                                                <i class="fa-light fa-envelope-open-dollar"></i>
                                            </a>
                                            @endif
                                            <a href="{{ route('loans.show', $loan->id) }}" class="bs-tooltip btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ver">
                                                <i class="fa-light fa-eye"></i>
                                            </a>

                                        </div>

                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>



                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT AREA -->
</div>
@push('scripts')
<script src="/src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {

        @this.on('deleteLoan', loan => {
            Swal.fire({
                title: '¿Estas seguro de eliminar?',
                html: "Se eliminará los datos del préstamos, pagos y garantías",
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    @this.call('destroyLoan', loan)
                }
            });
        });
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