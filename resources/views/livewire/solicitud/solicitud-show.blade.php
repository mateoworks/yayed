@section('title', 'Solicitud ' . $solicitud->folio)

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/css/light/loaders/custom-loader.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/dark/loaders/custom-loader.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/src/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="/src/plugins/src/sweetalerts2/sweetalerts2.css">

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
                                    @if ($solicitud->condition == 'en proceso')
                                    <span class="fs-3 badge badge-light-primary">En proceso</span>
                                    @elseif ($solicitud->condition == 'denegado')
                                    <span class="fs-3 badge badge-light-danger">Denegado</span>
                                    @elseif ($solicitud->condition == 'autorizado')
                                    <span class="fs-3 badge badge-light-success">Autorizado</span>
                                    @endif
                                    <a href="{{ route('solicitud.edit', $solicitud) }}" class="btn btn-info bs-tooltip" data-toggle="tooltip" data-placement="top" title="Editar">
                                        <i class="fa-light fa-pen-to-square"></i>
                                    </a>
                                    <button type="button" wire:click="exportPDF" class="btn btn-danger">Generar PDF</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            @if ($solicitud->loan)
                            <h6>Préstamo</h6>
                            <table>
                                <tr>
                                    <td>
                                        <p>Fecha en que se realizó el préstamo</p>
                                    </td>
                                    <td>
                                        <p><strong>{{ $solicitud->loan->date_made->format('d/m/Y') }}</strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Cantidad préstada</p>
                                    </td>
                                    <td>
                                        <p><strong>${{ number_format($solicitud->loan->amount, 2) }}</strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Estado del préstamo</p>
                                    </td>
                                    <td>
                                        <p><strong>{{ $solicitud->loan->status }}</strong></p>
                                    </td>
                                </tr>
                            </table>
                            <a href="{{ route('loans.show', $solicitud->loan) }}" class="btn btn-secondary">Ver préstamo</a>
                            @elseif ($solicitud->condition == 'autorizado')
                            <p>La solicitud fue actualizada, por lo tanto puede realizar el préstamo</p>
                            <a href="{{ route('loans.solicitud', $solicitud) }}" class="btn btn-primary">Realizar préstamo</a>
                            @elseif ($solicitud->condition = 'en proceso')
                            <button class="btn btn-success" wire:click="autorizar">Autorizar solicitud</button>
                            @endif

                        </div>
                    </div>


                    <hr>
                    <h3>Avales</h3>
                    <table class="table">
                        <tbody>
                            @forelse ($solicitud->endorsements as $endorsement)
                            <tr>
                                <td>{{ $endorsement->names }}</td>
                                <td>{{ $endorsement->surnames }}</td>
                                <td>{{ $endorsement->phone }}</td>
                                <td><a wire:click="$emit('endorsementQuit', {{ $endorsement }})" class="btn btn-danger btn-sm">Quitar</a></td>
                            </tr>

                            @empty
                            <tr>
                                <td>
                                    No hay avales asignados a esta solicitud,
                                    <a href="" class="btn btn-info btn-sm">Agregar</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <hr>
                    <h3>Garantías</h3>
                    <table class="table">
                        <tbody>
                            @forelse ($solicitud->warranties as $warranty)
                            <tr>
                                <td>{{ $warranty->type }}</td>
                                <td>
                                    @if ($warranty->url_document)
                                    @php
                                    $ext = pathinfo(Storage::disk('public')->url($warranty->url_document), PATHINFO_EXTENSION)
                                    @endphp

                                    @if ($ext == 'jpg' || $ext == 'png' || $ext == 'bmp')
                                    <img src="{{ Storage::disk('public')->url($warranty->url_document) }}" height="70" alt="...">
                                    <a href="{{ route('warranties.download', $warranty) }}">Descargar</a>
                                    @elseif($ext == 'pdf')
                                    <img src="/img/pdf.png" height="70" alt="...">
                                    <a href="{{ route('warranties.download', $warranty) }}">Descargar</a>
                                    @else
                                    <img src="/img/no_preview.png" height="70" alt="...">
                                    @endif

                                    @endif
                                </td>
                                <td>{{ $warranty->description }}</td>
                                <td><a wire:click="$emit('warrantyDelete', {{ $warranty }})" class="btn btn-danger btn-sm">Eliminar</a></td>
                            </tr>
                            @empty
                            <tr>
                                <td>
                                    No hay garantías asignados a esta solicitud,
                                    <a href="" class="btn btn-info btn-sm">Agregar</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
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
<script src="/src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        @this.on('warrantyDelete', warranty => {
            Swal.fire({
                title: '¿Estas seguro de eliminar?',
                html: "Se eliminará esta garantía con el archivo adjunto",
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    @this.call('destroyWarranty', warranty)
                }
            });
        });

        @this.on('endorsementQuit', endorsement => {
            Swal.fire({
                title: '¿Estas seguro de quitar?',
                html: "El aval se desvinvulará de este socio en este préstamo",
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    @this.call('quitEndorsement', endorsement)
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


@endpush