@section('title', 'Reportes')

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
                <li class="breadcrumb-item active" aria-current="page">Generar reportes</li>
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
                                    <h4>Reporte</h4>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="card">
                        <div class="card-body">
                            <form class="row g-3">
                                <div class="col-md-5">
                                    <label for="start" class="form-label">Fecha de inicio</label>
                                    <input wire:model="dateStart" type="date" class="form-control" id="start">
                                </div>
                                <div class="col-md-5">
                                    <label for="end" class="form-label">Fecha de término</label>
                                    <input wire:model="dateEnd" type="date" class="form-control" id="end">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" wire:click="generar" class="btn btn-primary">Generar</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <h4>
                        Pagos realizados en el periodo
                    </h4>
                    <table class="table table-striped">
                        <thead>
                            <th>Fecha realizada</th>
                            <th>Socio</th>
                            <th>Cantidad capital pagado</th>
                            <th>Cantidad interés pagado</th>
                        </thead>
                        <tbody>
                            @foreach ($pagos as $p)
                            <tr>
                                <td>{{ $p->made_date->format('Y-d-m') }}</td>
                                <td>{{ $p->loan->partner->full_name }}</td>
                                <td>{{ $p->principal_amount }}</td>
                                <td>{{ $p->interest_amount }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


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