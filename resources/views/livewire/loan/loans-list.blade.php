@section('title', 'Préstamos')
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
                                <h4>Lista de prestamos</h4>
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
                        <div class="col-md-4">
                            <select wire:model="status" class="form-select" aria-label="Default select example">
                                <option selected>Puedes seleccionar un estado de préstamo</option>
                                <option value="activo">Activo</option>
                                <option value="suspendido">Suspendido</option>
                                <option value="liquidado">Liquidado</option>
                                <option value="">Todos</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Socio</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Fecha realizada</th>
                                    <th class="text-center" scope="col">Estado</th>
                                    <th class="text-center" scope="col"></th>
                                </tr>
                                <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                            </thead>
                            <tbody>

                                @foreach ($loans as $loan)
                                <tr>
                                    <td>
                                        <a href="{{ route('partners.show', $loan->partner) }}">
                                            <div class="media">
                                                <div class="avatar me-2">
                                                    @if ($loan->partner->image)
                                                    <img alt="avatar" src="{{ Storage::disk('public')->url($loan->partner->image) }}" class="rounded-circle" />
                                                    @else
                                                    <span class="avatar-title rounded-circle bg-primary">{{ $loan->partner->names[0] ?? '' }}{{ $loan->partner->surname_father[0] }}</span>
                                                    @endif
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <h6 class="mb-0">{{ $loan->partner->full_name }}</h6>
                                                    <span><i class="fa-regular fa-phone"></i> {{ $loan->partner->phone }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <p>$ {{ number_format($loan->amount, 2) }}</p>
                                    </td>
                                    <td>
                                        <p><i class="fa-light fa-calendar-days"></i> {{ $loan->date_made->format('Y-m-d') }}</p>
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
                                            <a href="{{ route('payments.create', $loan) }}" class="bs-tooltip btn btn-success" data-toggle="tooltip" data-placement="top" title="Realizar pago">
                                                <i class="fa-light fa-envelope-open-dollar"></i>
                                            </a>
                                            @endif
                                            <a href="{{ route('loans.show', $loan) }}" class="bs-tooltip btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ver">
                                                <i class="fa-light fa-eye"></i>
                                            </a>
                                            <a href="{{ route('loans.edit', $loan) }}" class="bs-tooltip btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa-light fa-pen-to-square"></i>
                                            </a>
                                            <a wire:click="$emit('deleteLoan', {{ $loan }})" class="bs-tooltip btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{ $loans->links() }}

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