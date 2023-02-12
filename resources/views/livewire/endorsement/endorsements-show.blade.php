@section('title', 'Aval: ' . $endorsement->id)

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
                <li class="breadcrumb-item"><a href="{{ route('endorsements.index') }}">Avales</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $endorsement->full_name }}</li>
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
                                    <h4>Datos del aval</h4>
                                </div>
                                <div class="mt-3 me-3">

                                    <a href="" class="btn btn-secondary ms-2 bs-tooltip" data-toggle="tooltip" data-placement="top" title="Editar">
                                        <i class="fa-light fa-pen-to-square"></i>
                                    </a>

                                </div>
                            </div>
                            <div class="card mt-2">
                                <div class="card-body">
                                    <table>
                                        <tr>
                                            <td>
                                                <p> Nombre: </p>
                                            </td>
                                            <td>
                                                <p><strong>{{ $endorsement->names }}</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Apellidos:</p>
                                            </td>
                                            <td>
                                                <p><strong>{{ $endorsement->surnames }}</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Teléfono:</p>
                                            </td>
                                            <td>
                                                <p><strong>{{ $endorsement->phone }}</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Dirección:</p>
                                            </td>
                                            <td>
                                                <p><strong>{{ $endorsement->address }}</strong></p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="widget-content widget-content-area mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h3>Solicitudes avalados</h3>
                            <table class="table table-striped">
                                <thead>
                                    <th>Fecha de la solicitud</th>
                                    <th>Socio</th>
                                    <th>Monto</th>
                                    <th>Estado de la solicitud</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @forelse ($endorsement->solicituds as $solicitud)
                                    <tr>
                                        <td>{{ $solicitud->date_solicitud->format('d/m/Y') }}</td>
                                        <td>{{ $solicitud->partner->full_name }}</td>
                                        <td>${{ number_format($solicitud->mount, 2) }}</td>
                                        <td>{{ $solicitud->condition }}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ route('partners.solicitud.show', $solicitud) }}">
                                                <i class="fa-light fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td>No hay solicitudes avalados</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h3>Préstamos avalados</h3>
                            {{dd($loans) }}
                            <table class="table table-striped">
                                <thead>
                                    <th>Fecha de la solicitud</th>
                                    <th></th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- CONTENT AREA -->
</div>

@push('scripts')
<script src="/src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
<script>
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