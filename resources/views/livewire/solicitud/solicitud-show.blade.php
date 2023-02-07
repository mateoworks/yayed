@section('title', 'Solicitud ' . $solicitud->folio)

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/css/light/loaders/custom-loader.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/dark/loaders/custom-loader.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/src/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="/src/plugins/src/select2/css/select2.min.css">

<link href="/src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css" />

@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">Socios</a></li>
                <li class="breadcrumb-item"><a href="{{ route('partners.show', $solicitud->partner) }}">{{ $solicitud->partner->full_name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Solicitud {{ $solicitud->folio }}</li>
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
                                <h4>Datos de la solicitud {{ $solicitud->folio }}</h4>
                                <div class="mt-3 me-3">
                                    <button type="button" wire:click="exportPDF" class="btn btn-danger">Generar PDF</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <table>
                        <tr>
                            <td>
                                <p>Folio(s): </p>
                            </td>
                            <td>
                                <p><strong>{{ $solicitud->folio }}</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Fecha de la solicitud: </p>
                            </td>
                            <td>
                                <p><strong>{{ $solicitud->date_solicitud->format('d/m/Y') }}</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Periodo: </p>
                            </td>
                            <td>
                                <p><strong>{{ $solicitud->period }} {{ $solicitud->period > 1 ? 'meses' : 'mes' }}</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Fecha de pago: </p>
                            </td>
                            <td>
                                <p><strong>{{ $solicitud->date_payment->format('d/m/Y') }}</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Monto: </p>
                            </td>
                            <td>
                                <p><strong>${{ number_format($solicitud->mount, 2) }}</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Concepto: </p>
                            </td>
                            <td>
                                <p><strong>{{ $solicitud->concept }}</strong></p>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT AREA -->


</div>




@push('scripts')
<script src="/js/jquery-3.6.0.min.js"></script>
<script src="/src/plugins/src/flatpickr/flatpickr.js"></script>
<script>
    window.addEventListener('show-modal', () => {
        $('#modal').modal('show');
    });

    window.addEventListener('hide-modal', () => {
        $('#modal').modal('hide');
    });

    window.addEventListener('save-endorsement', event => {
        $('#modal').modal('hide');
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