@section('title', 'Solicitudes')
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
                <li class="breadcrumb-item active" aria-current="page">Solicitudes</li>
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
                                <h4>Lista de solicitudes</h4>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <a class="btn btn-success mt-2 me-4" href="">
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
                                <option selected>Puedes seleccionar un estado de solicitud</option>
                                <option value="denegado">Denegado</option>
                                <option value="autorizado">Autorizado</option>
                                <option value="en proceso">En proceso</option>
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
                                    <th scope="col">Fecha solicitada</th>
                                    <th class="text-center" scope="col">Estado</th>
                                    <th class="text-center" scope="col"></th>
                                </tr>
                                <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                            </thead>
                            <tbody>

                                @foreach ($solicitudes as $solicitud)
                                <tr>
                                    <td>
                                        <a href="{{ route('partners.show', $solicitud->partner) }}">
                                            <div class="media">
                                                <div class="avatar me-2">
                                                    @if ($solicitud->partner->image)
                                                    <img alt="avatar" src="{{ Storage::disk('public')->url($partner->image) }}" class="rounded-circle" />
                                                    @else
                                                    <span class="avatar-title rounded-circle bg-primary">{{ $solicitud->partner->names[0] ?? '' }}{{ $solicitud->partner->surname_father[0] }}</span>
                                                    @endif
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <h6 class="mb-0">{{ $solicitud->partner->full_name }}</h6>
                                                    <span><i class="fa-regular fa-phone"></i> {{ $solicitud->partner->phone }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <p>$ {{ number_format($solicitud->mount, 2) }}</p>
                                    </td>
                                    <td>
                                        <p><i class="fa-light fa-calendar-days"></i> {{ $solicitud->date_solicitud->format('Y-m-d') }}</p>
                                    </td>
                                    <td class="text-center">
                                        @switch($solicitud->condition)
                                        @case('en proceso')
                                        <span class="badge badge-light-primary">En proceso</span>
                                        @break
                                        @case('denegado')
                                        <span class="badge badge-light-danger">Denegado</span>
                                        @break
                                        @case('autorizado')
                                        <span class="badge badge-light-success">Autorizado</span>
                                        @break
                                        @default
                                        Otra situacion
                                        @endswitch

                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Basic example">

                                            <a href="{{ route('partners.solicitud.show', $solicitud) }}" class="bs-tooltip btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ver">
                                                <i class="fa-light fa-eye"></i>
                                            </a>
                                            <a href="{{ route('solicitud.edit', $solicitud) }}" class="bs-tooltip btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa-light fa-pen-to-square"></i>
                                            </a>

                                        </div>

                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{ $solicitudes->links() }}

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