@section('title', 'Lista de avales')
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
                <li class="breadcrumb-item active" aria-current="page">Avales</li>
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
                                <h4>Lista de avales</h4>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <a href="{{ route('endorsements.create') }}" class="btn btn-primary m-3">Nuevo</a>
                            <a class="btn btn-success mt-2 me-4" href="">
                                <i class="fa-light fa-file-excel"></i>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="widget-content widget-content-area">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Aval</th>
                                    <th scope="col">Dirección</th>
                                    <th scope="col">Préstamos avalados</th>
                                    <th class="text-center" scope="col"></th>
                                </tr>
                                <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                            </thead>
                            <tbody>

                                @foreach ($endorsements as $endorsement)
                                <tr>
                                    <td>

                                        <div class="media">
                                            <div class="media-body align-self-center">
                                                <h6 class="mb-0">{{ $endorsement->full_name }}</h6>
                                                <span><i class="fa-regular fa-phone"></i> {{ $endorsement->phone }}</span>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <p>{{ $endorsement->address }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $endorsement->solicituds->count() }}</p>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Basic example">

                                            <a href="{{ route('endorsements.show', $endorsement) }}" class="bs-tooltip btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ver">
                                                <i class="fa-light fa-eye"></i>
                                            </a>
                                            <a href="{{ route('endorsements.edit', $endorsement) }}" class="bs-tooltip btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa-light fa-pen-to-square"></i>
                                            </a>
                                            <a wire:click="$emit('deleteEndorsment', {{ $endorsement }})" class="bs-tooltip btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{ $endorsements->links() }}

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

        @this.on('deleteEndorsment', endorsement => {
            Swal.fire({
                title: '¿Estas seguro de eliminar?',
                html: "Se eliminará este aval y se le quitará a los préstamos que ha avalado",
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    @this.call('destroyEndorsement', endorsement)
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