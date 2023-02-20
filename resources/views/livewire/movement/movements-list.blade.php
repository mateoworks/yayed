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
                <li class="breadcrumb-item active" aria-current="page">Movimientos</li>
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
                                <h4>Lista de movimientos</h4>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <a wire:click="exportExcel" class="btn btn-success mt-2 me-4">
                                <div wire:loading wire:target="exportExcel">
                                    <div class="spinner-border text-white me-2 align-self-center loader-sm "></div>
                                </div>
                                <i class="fa-light fa-file-excel"></i>
                            </a>
                            <a href="{{ route('movements.create')}}" class="btn btn-primary mt-2 me-4">
                                Registrar
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
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Categoría</th>
                                    <th scope="col">Concepto</th>
                                    <th scope="col">Cantidad</th>
                                    <th class="text-center" scope="col"></th>
                                </tr>
                                <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                            </thead>
                            <tbody>
                                @forelse ($movements as $movement)
                                <tr>
                                    <td>{{ $movement->date_movement }}</td>
                                    <td>{{ $movement->type }}</td>
                                    <td>{{ $movement->category->name }}</td>
                                    <td>{{ $movement->concept }}</td>
                                    <td class="text-end">${{ number_format($movement->amount, 2) }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="" class="bs-tooltip btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ver">
                                                <i class="fa-light fa-eye"></i>
                                            </a>
                                            <a href="{{ route('movements.edit', $movement) }}" class="bs-tooltip btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa-light fa-pen-to-square"></i>
                                            </a>
                                            <button type="button" class="bs-tooltip btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td>
                                        <h5>No hay movimientos registrados</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $movements->links() }}

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