@section('title', 'Socio: ' . $partner->names . ' ' . $partner->surname_father . ' ' . $partner->surname_mother)

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

<link href="/src/assets/css/light/components/tabs.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/components/tabs.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/light/components/timeline.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/components/timeline.css" rel="stylesheet" type="text/css" />
<style>
    ol .time-line {
        max-width: 100% !important;
        width: 100% !important;
    }
</style>
@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">Socios</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $partner->names }}</li>
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

                                    <a href="{{ route('partners.edit', $partner) }}" class="btn btn-info ms-2 bs-tooltip" data-toggle="tooltip" data-placement="top" title="Editar">
                                        <i class="fa-light fa-pen-to-square"></i>
                                    </a>
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
                                    <a class="btn btn-danger ms-2 bs-tooltip" wire:click="exportPDF" data-toggle="tooltip" data-placement="top" title="Generar reporte">
                                        <div wire:loading wire:target="exportPDF">
                                            <div class="spinner-border text-white me-2 align-self-center loader-sm"></div>
                                        </div>
                                        <i class="fa-light fa-file-pdf"></i>
                                    </a>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="row">
                        <div class="col-sm-12 col-lg-4">
                            @if ($partner->image)
                            <img src="{{ Storage::disk('public')->url($partner->image) }}" class="img-thumbnail" alt="">
                            @else
                            <img src="/img/farmer.png" class="img-thumbnail" alt="">

                            @endif
                        </div>
                        <div class="col-sm-12 col-lg-8">
                            <h4> {{ $partner->fullName }}</h4>


                            <div class="widget-content widget-content-area animated-underline-content">

                                <ul class="nav nav-tabs  mb-3" id="animateLine" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="datos-personales-tab" data-bs-toggle="tab" href="#datos-personales" role="tab" aria-controls="datos-personales" aria-selected="true">
                                            <i class="fa-light fa-address-card"></i> Datos personales</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="contacto-tab" data-bs-toggle="tab" href="#contacto" role="tab" aria-controls="contacto" aria-selected="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone">
                                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                            </svg> Contacto</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="socioeconomico-tab" data-bs-toggle="tab" href="#socioeconomico" role="tab" aria-controls="socioeconomico" aria-selected="false">
                                            <i class="fa-light fa-house-user"></i>Socioeconomico</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="animateLineContent-4">
                                    <div class="tab-pane fade active show" id="datos-personales" role="tabpanel" aria-labelledby="datos-personales-tab">
                                        <table>
                                            <tr>
                                                <td>
                                                    <p>Nombre(s): </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->names }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Primer apellido: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->surname_father }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Segundo apellido: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->surname_mother }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Fecha de nacimiento: </p>
                                                </td>
                                                <td>
                                                    @if ($partner->birthday)
                                                    <p><strong>{{ $partner->birthday->format('d/m/Y') ?? '' }} ({{ $partner->age }} años)</strong></p>
                                                    @endif

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Género: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->gender }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Estado civil: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->civil_status }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>CURP: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->curp }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Clave INE: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->key_ine }}</strong></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="contacto" role="tabpanel" aria-labelledby="contacto-tab">
                                        <table>
                                            <tr>
                                                <td>
                                                    <p>Teléfono: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->phone }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Correo electrónico: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->email }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Calle: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->address }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Número: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->address_number }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Barrio: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->barrio }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Código postal: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->cp }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Colonia: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->suburb }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Municipio: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->municipio }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Estado: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->estado }}</strong></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="socioeconomico" role="tabpanel" aria-labelledby="socioeconomico-tab">
                                        <table>
                                            <tr>
                                                <td>
                                                    <p>Ocupacion: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->job }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Vivienda: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->dwelling }}</strong></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Dependientes: </p>
                                                </td>
                                                <td>
                                                    <p><strong>{{ $partner->dependents }}</strong></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Documentos</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="row">
                        @forelse ($partner->documents as $document)
                        <div class="col-md-4">
                            @php
                            $ext = pathinfo(Storage::disk('public')->url($document->url), PATHINFO_EXTENSION)
                            @endphp
                            <div class="card" style="width: 18rem;">
                                @if ($ext == 'jpg' || $ext == 'png' || $ext == 'bmp')
                                <img src="{{ Storage::disk('public')->url($document->url) }}" class="card-img-top" alt="...">
                                @elseif($ext == 'pdf')
                                <img src="/img/pdf.png" class="card-img-top" alt="...">
                                @else
                                <img src="/img/no_preview.png" class="card-img-top" alt="...">
                                @endif
                                <div class="card-body">
                                    <p class="card-text">{{ $document->type }}</p>
                                    <a class="btn btn-warning" href="{{ route('documents.download', $document) }}">Descargar</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <h6>No hay documentos agregados</h6>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Préstamos realizados</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">

                        <ol class="timeline">

                            @foreach ($partner->loans as $loan)
                            <li class="timeline-item extra-space">
                                <span class="timeline-item-icon filled-icon">
                                    <i class="d-inline fa-regular fa-hand-holding-dollar"></i>
                                </span>
                                <div class="timeline-item-wrapper">
                                    <div class="timeline-item-description">
                                        <span class="align-self-center">
                                            <a href="{{ route('loans.show', $loan) }}">{{ $loan->number }}</a>
                                            realizado el
                                            <span>{{ $loan->date_made->locale('es')->isoFormat('D \d\e MMMM \d\e\l Y') }}</span>
                                            <strong class="fw-3">- capital: ${{ number_format($loan->amount, 2) }}</strong>
                                        </span>
                                        @if ($loan->status == 'activo')
                                        <span class="badge badge-primary mb-2 me-4">Activo</span>
                                        @elseif ($loan->status == 'suspendido')
                                        <span class="badge badge-danger mb-2 me-4">Suspendido</span>
                                        @elseif ($loan->status == 'liquidado')
                                        <span class="badge badge-success mb-2 me-4">Liquidado</span>
                                        @endif

                                    </div>
                                    <p>Solicitud realizada el {{ $loan->solicitud->date_solicitud->format('d/m/Y') }}, folio:
                                        <span>
                                            <a href="{{ route('partners.solicitud.show', $loan->solicitud) }}" class="btn btn-danger">{{ $loan->solicitud->folio }}</a>
                                        </span>
                                    </p>
                                    <div class="comment">
                                        <h6 class="text-center">Pagos realizados</h6>
                                        <table class="table table-striped table-border">
                                            <thead>
                                                <th>NP</th>
                                                <th>Fecha realizada</th>
                                                <th>Fecha programada</th>
                                                <th>Cantidad capital</th>
                                                <th>Cantidad interés</th>
                                                <th>Importe</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                @foreach ($loan->payments as $payment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $payment->scheduled_date->format('d/m/Y') }}</td>
                                                    <td>{{ $payment->made_date->format('d/m/Y') }}</td>
                                                    <td class="text-end">${{ number_format($payment->principal_amount, 2) }}</td>
                                                    <td class="text-end">${{ number_format($payment->interest_amount, 2) }}</td>
                                                    <td class="text-end">${{ number_format($payment->principal_amount + $payment->interest_amount, 2) }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <a href="{{ route('payments.show', $payment) }}" class="btn btn-primary">
                                                                <i class="fa-light fa-eye"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </li>
                            @endforeach

                        </ol>

                    </div>
                </div>
            </div>
        </div>

        <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Solicitudes realizadas</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <table class="table table-striped table-border">
                            <thead>
                                <th>Folio</th>
                                <th>Fecha realizada</th>
                                <th>Periodo</th>
                                <th>Monto solicitado</th>
                                <th>Status</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @forelse ($partner->solicituds as $solicitud)
                                <tr>
                                    <td>{{ $solicitud->folio }}</td>
                                    <td>{{ $solicitud->date_solicitud->format('d/m/Y') }}</td>
                                    <td>{{ $solicitud->period }}</td>
                                    <td class="text-end">${{ number_format($solicitud->mount, 2) }}</td>
                                    <td>{{ $solicitud->condition }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('partners.solicitud.show', $solicitud) }}">
                                            <i class="fa-light fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td>No hay solicitudes realizadas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- CONTENT AREA -->
</div>