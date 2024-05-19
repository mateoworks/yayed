@section('title', 'Últimos pagos realizados')
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
                <li class="breadcrumb-item active" aria-current="page">Últimos pagos</li>
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
                                <h4>Lista de los últimos pagos realizados</h4>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <a wire:click="exportExcel" class="btn btn-success mt-2 me-4">
                                <div wire:loading wire:target="exportExcel">
                                    <div class="spinner-border text-white me-2 align-self-center loader-sm "></div>
                                </div>
                                <i class="fa-light fa-file-excel"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-3">
                            <input type="text" wire:model="search" class="form-control" placeholder="Buscar...">
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Número prestamo</th>
                                    <th>Socio</th>
                                    <th scope="col">Cantidad capital</th>
                                    <th scope="col">Fecha del pago</th>
                                    <th scope="col">Cantidad capital pagado</th>
                                    <th scope="col">Cantidad interés pagado</th>
                                    <th scope="col">Total</th>
                                    <th class="text-center" scope="col"></th>
                                </tr>
                                <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->loan->number }}</td>
                                    <td>{{ $payment->loan->partner->full_name }}</td>
                                    <td>{{ number_format($payment->loan->amount, 2) }}</td>
                                    <td>{{ $payment->scheduled_date->format('Y-m-d') }}</td>
                                    <td>{{ number_format($payment->principal_amount, 2) }}</td>
                                    <td>{{ number_format($payment->interest_amount, 2) }}</td>
                                    <td>{{ number_format(($payment->interest_amount + $payment->principal_amount), 2) }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ route('payments.show', $payment) }}" class="bs-tooltip btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ver">
                                                <i class="fa-light fa-eye"></i>
                                            </a>
                                            <a href="" class="bs-tooltip btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa-light fa-pen-to-square"></i>
                                            </a>
                                            <button type="button" wire:click="$emit('deletePayment', {{ $payment }})" class="bs-tooltip btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td>
                                        <h5>No hay pagos registrados</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $payments->links() }}

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

        @this.on('deletePayment', payment => {
            Swal.fire({
                title: '¿Estas seguro de eliminar?',
                html: "Se eliminarán los datos de este pago",
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    @this.call('destroyPayment', payment)
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
