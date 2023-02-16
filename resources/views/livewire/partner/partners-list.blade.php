@section('title', 'Socios')
@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/src/plugins/src/sweetalerts2/sweetalerts2.css">

<link href="/src/plugins/css/light/loaders/custom-loader.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/dark/loaders/custom-loader.css" rel="stylesheet" type="text/css" />
@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Socios</li>
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
                                <h4>Lista de socios</h4>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end mt-4 me-4">
                            <button type="button" wire:click="exportExcel" class="btn btn-success">
                                <div wire:loading wire:target="exportExcel">
                                    <div class="spinner-border text-white me-2 align-self-center loader-sm "></div>
                                </div>
                                <i class="fa-light fa-file-excel"></i>
                            </button>

                            <a class="btn btn-primary" href="{{ route('partners.create') }}">
                                <i class="fa-regular fa-square-plus"></i>
                                <span class="btn-text-inner">Agregar socio</span>
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
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Teléfono</th>

                                    <th class="text-center" scope="col"></th>
                                </tr>
                                <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                            </thead>
                            <tbody>

                                @foreach ($partners as $partner)
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="avatar">
                                                @if ($partner->image)
                                                <img alt="avatar" src="{{ Storage::disk('public')->url($partner->image) }}" class="rounded-circle" />
                                                @else
                                                <span class="avatar-title rounded-circle bg-primary">{{ $partner->names[0] ?? '' }}{{ $partner->surname_father[0] }}</span>
                                                @endif
                                            </div>
                                            <div class="media-body align-self-center ms-3">
                                                <h6 class="mb-0">{{ $partner->names }} {{ $partner->surname_father }}</h6>
                                                <span>{{ $partner->curp }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">{{ $partner->phone }}</p>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            @if (!$partner->active && $partner->solicitud_autorizado)
                                            <a href="{{ route('loans.solicitud', $partner->solicitud_autorizado) }}" class="bs-tooltip btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Realizar préstamo">
                                                <i class="fa-regular fa-hand-holding-dollar"></i>
                                            </a>
                                            @elseif (!$partner->solicitud_autorizado)
                                            <a href="{{ route('partners.solicitud.create', $partner) }}" class="bs-tooltip btn btn-warning" data-toggle="tooltip" data-placement="top" title="Realizar solicitud">
                                                <i class="fa-light fa-file-export"></i>
                                            </a>
                                            @elseif ($partner->active)
                                            <a href="{{ route('payments.create', $partner->active) }}" class="bs-tooltip btn btn-success" data-toggle="tooltip" data-placement="top" title="Realizar pago">
                                                <i class="fa-light fa-envelope-open-dollar"></i>
                                            </a>
                                            @endif
                                            <a href="{{ route('partners.show', $partner) }}" class="bs-tooltip btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ver">
                                                <i class="fa-light fa-eye"></i>
                                            </a>
                                            <a href="{{ route('partners.edit', $partner) }}" class="bs-tooltip btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa-light fa-pen-to-square"></i>
                                            </a>
                                            <a wire:click="$emit('triggerDelete', '{{ $partner->id }}')" class="bs-tooltip btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{ $partners->links() }}

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

        @this.on('triggerDelete', id => {
            Swal.fire({
                title: '¿Estas seguro de eliminar?',
                html: "Se eliminará todo registro de este socio, documentos, préstamos, pagos, solicitudes.",
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    @this.call('destroy', id)
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
            backgroundColor: '#' + event.detail.backgroundColor,

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