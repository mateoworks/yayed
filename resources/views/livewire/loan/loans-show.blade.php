@section('title', 'Prestamo: ' . $loan->id)

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
                <li class="breadcrumb-item"><a href="{{ route('loans.index') }}">Prestamos</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $loan->id }}</li>
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
                                    <h4>Detalles del préstamo</h4>

                                </div>
                                <div class="mt-3 me-3">
                                    @if ($loan->status == 'activo')
                                    <span class="fs-3 badge badge-light-primary">Activo</span>
                                    @elseif ($loan->status == 'suspendido')
                                    <span class="fs-3 badge badge-light-danger">Suspendido</span>
                                    @elseif ($loan->status == 'liquidado')
                                    <span class="fs-3 badge badge-light-success">Liquidado</span>
                                    @endif
                                    <a href="{{ route('loans.edit', $loan) }}" class="btn btn-secondary ms-2 bs-tooltip" data-toggle="tooltip" data-placement="top" title="Editar">
                                        <i class="fa-light fa-pen-to-square"></i>
                                    </a>
                                    <a href="{{ route('loans.payment.plan', $loan) }}" class="btn btn-primary ms-1 bs-tooltip" data-toggle="tooltip" data-placement="top" title="Generar plan de pago">
                                        <i class="fa-light fa-calendar-check"></i>
                                    </a>
                                    <a href="{{ route('payments.create', $loan) }}" class="btn btn-payment ms-1 bs-tooltip" data-toggle="tooltip" data-placement="top" title="Registrar pago">
                                        <i class="fa-light fa-envelope-open-dollar"></i>
                                    </a>
                                    <a href="{{ route('loans.contract', $loan) }}" class="btn btn-success btn-sm ms-1">
                                        <i class="fa-regular fa-file"></i>
                                        Contrato prestamo
                                    </a>
                                    <a href="{{ route('loans.detail', $loan) }}" class="btn btn-info btn-sm ms-1">
                                        <i class="fa-regular fa-file"></i>
                                        Reporte
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Socio</h4>
                                    <div class="media">
                                        <div class="avatar me-2">
                                            @if ($loan->partner->image)
                                            <img alt="avatar" src="{{ Storage::disk('public')->url($partner->image) }}" class="rounded-circle" />
                                            @else
                                            <span class="avatar-title rounded-circle bg-primary">{{ $loan->partner->names[0] ?? '' }}{{ $loan->partner->surname_father[0] }}</span>
                                            @endif
                                        </div>
                                        <div class="media-body align-self-center">
                                            <h6 class="mb-0">{{ $loan->partner->full_name }}</h6>
                                            <span><i class="fa-regular fa-phone"></i> {{ $loan->partner->phone }}</span>
                                            <p>{{ $loan->partner->address }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4>Préstamo</h4>
                                    <table class="table table-hover table-striped table-bordered">
                                        <tr>
                                            <td>ID:</td>
                                            <td><span class=" badge badge-danger">{{ $loan->id }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>Cantidad capital:</td>
                                            <td>$ {{ number_format($loan->amount, 2) }}</td>
                                        </tr>

                                        <tr>
                                            <td>Cantidad con letra:</td>
                                            <td>{{ $loan->amount_letter }} PESOS MX</td>
                                        </tr>

                                        <tr>
                                            <td>Interés:</td>
                                            <td>{{ $loan->interest }}%</td>
                                        </tr>
                                        <tr>
                                            <td>Fecha realizada:</td>
                                            <td>{{ $loan->date_made->format('Y-m-d') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Fecha de pago:</td>
                                            <td>{{ $loan->date_payment->format('Y-m-d') }}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <hr>
                            <h3>Avales</h3>
                            <table class="table">
                                <tbody>
                                    @forelse ($loan->endorsements as $endorsement)
                                    <tr>
                                        <td>{{ $endorsement->names }}</td>
                                        <td>{{ $endorsement->surnames }}</td>
                                        <td>{{ $endorsement->phone }}</td>
                                        <td><a wire:click="$emit('endorsementQuit', {{ $endorsement }})" class="btn btn-danger btn-sm">Quitar</a></td>
                                    </tr>

                                    @empty
                                    <tr>
                                        <td>
                                            No hay avales asignados a este prestamo,
                                            <a href="{{ route('loans.edit', $loan) }}" class="btn btn-info btn-sm">Agregar</a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <hr>
                            <h3>Garantías</h3>
                            <table class="table">
                                <tbody>
                                    @forelse ($loan->warranties as $warranty)
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
                                            No hay garantías asignados a este prestamo,
                                            <a href="{{ route('loans.edit', $loan) }}" class="btn btn-info btn-sm">Agregar</a>
                                        </td>
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
                            <h3>Pagos realizados</h3>
                            <table class="table table-striped">
                                <thead>
                                    <th>Fecha programada</th>
                                    <th>Fecha realizada</th>
                                    <th>Pago de capital</th>
                                    <th>Pago de interés</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @forelse ($loan->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->scheduled_date->format('Y-m-d') }}</td>
                                        <td>{{ $payment->made_date->format('Y-m-d') }}</td>
                                        <td>$ {{ number_format($payment->principal_amount, 2) }}</td>
                                        <td>$ {{ number_format($payment->interest_amount, 2) }}</td>
                                        <td>
                                            <a href="{{ route('payments.show', $payment) }}" class="btn btn-primary">
                                                <i class="fa-light fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty

                                    @endforelse
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