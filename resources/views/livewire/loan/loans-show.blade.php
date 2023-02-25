@section('title', 'Prestamo: ' . $loan->numero)

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
                <li class="breadcrumb-item active" aria-current="page">{{ $loan->numero }}</li>
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
                                    <a href="{{ route('loans.edit', $loan) }}" class="btn btn-info ms-2 bs-tooltip" data-toggle="tooltip" data-placement="top" title="Editar">
                                        <i class="fa-light fa-pen-to-square"></i>
                                    </a>
                                    @if ($loan->status == 'activo' || $loan->status == 'suspendido')
                                    <a href="{{ route('payments.create', $loan) }}" class="btn btn-success ms-1 bs-tooltip" data-toggle="tooltip" data-placement="top" title="Registrar pago">
                                        <i class="fa-light fa-envelope-open-dollar"></i>
                                    </a>
                                    @endif
                                    <a href="{{ route('loans.amortizacion', $loan) }}" class="btn btn-warning ms-1 bs-tooltip" data-toggle="tooltip" data-placement="top" title="Tabla de amortización">
                                        <i class="fa-light fa-calendar-check"></i>
                                    </a>
                                    <div class="btn-group">
                                        <a wire:click="pagare" class="btn btn-primary ms-1 bs-tooltip" data-toggle="tooltip" data-placement="top" title="Pagaré">
                                            <div wire:loading wire:target="pagare">
                                                <div class="spinner-border text-white me-2 align-self-center loader-sm"></div>
                                            </div>
                                            <i class="fa-sharp fa-regular fa-money-check-dollar"></i>
                                            Pagaré
                                        </a>
                                        @if ($loan->solicitud->endorsements()->exists())
                                        <a wire:click="constanciaAval" class="btn btn-danger bs-tooltip" data-toggle="tooltip" data-placement="top" title="Pagaré">
                                            <div wire:loading wire:target="constanciaAval">
                                                <div class="spinner-border text-white me-2 align-self-center loader-sm"></div>
                                            </div>
                                            <i class="fa-sharp fa-regular fa-money-check-dollar"></i>
                                            Constancia aval
                                        </a>
                                        @endif
                                    </div>

                                    <div class="btn-group  mb-2 me-4" role="group">
                                        <button id="btndefault" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Generar <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg></button>
                                        <div class="dropdown-menu" aria-labelledby="btndefault">
                                            <!-- <a href="{{ route('loans.contract', $loan) }}" class="dropdown-item">
                                                <i class="flaticon-home-fill-1 mr-1"></i>
                                                Contrato de préstamo
                                            </a> -->
                                            <a href="{{ route('loans.detail', $loan) }}" class="dropdown-item">
                                                <i class="flaticon-home-fill-1 mr-1"></i>
                                                Reporte de préstamo
                                            </a>
                                            <a href="{{ route('loans.payment.plan', $loan) }}" class="dropdown-item">
                                                <i class="flaticon-home-fill-1 mr-1"></i>
                                                Plan de pago capital fijo
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4>Socio</h4>
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
                                                <p>{{ $loan->partner->address }}</p>
                                                <p>Contribución social: <strong>${{ $loan->partner->social_contribution }}</strong></p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="{{ route('partners.solicitud.show', $loan->solicitud) }}" class="btn btn-primary">
                                        Ver solicitud
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <h4>Préstamo</h4>
                                    <table class="">
                                        <tr>
                                            <td>Folio:</td>
                                            <td><span class=" badge badge-danger">{{ $loan->numero }}</span></td>
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
                                            <td>{{ $loan->date_made->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Fecha de pago:</td>
                                            <td>{{ $loan->date_payment->format('d/m/Y') }}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <hr>
                            <h3>Avales</h3>
                            <table class="table">
                                <tbody>
                                    @forelse ($loan->solicitud->endorsements as $endorsement)
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
                                    @forelse ($loan->solicitud->warranties as $warranty)
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
                                    <th>N°</th>
                                    <th>Fecha programada</th>
                                    <th>Fecha realizada</th>
                                    <th>Pago de capital</th>
                                    <th>Pago de interés</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @php
                                    $capital = 0;
                                    $interes = 0;
                                    @endphp
                                    @forelse ($loan->payments as $payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $payment->scheduled_date->format('d/m/Y') }}</td>
                                        <td>{{ $payment->made_date->format('d/m/Y') }}</td>
                                        <td class="text-end">$ {{ number_format($payment->principal_amount, 2) }}</td>
                                        <td class="text-end">$ {{ number_format($payment->interest_amount, 2) }}</td>
                                        <td>
                                            <a href="{{ route('payments.show', $payment) }}" class="btn btn-primary">
                                                <i class="fa-light fa-eye"></i>
                                            </a>
                                            <a class="btn btn-danger" wire:click="$emit('deletePayment', {{ $payment }})">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </td>
                                        @php
                                        $capital += $payment->principal_amount;
                                        $interes += $payment->interest_amount;
                                        @endphp
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">No hay pagos registrados</td>
                                    </tr>
                                    @endforelse
                                    <tr>
                                        <td colspan="3" class="text-center"><strong>Totales</strong></td>
                                        <td class="text-end"><strong>${{ number_format($capital, 2) }}</strong></td>
                                        <td class="text-end"><strong>${{ number_format($interes, 2) }}</strong></td>
                                    </tr>
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

        @this.on('deletePayment', payment => {
            Swal.fire({
                title: '¿Estas seguro de eliminar el pago?',
                html: "Se eliminará este pago perteneciente a este préstamo",
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

@endpush