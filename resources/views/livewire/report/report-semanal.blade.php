@section('title', 'Reporte semanal')

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/src/plugins/src/sweetalerts2/sweetalerts2.css">
<link rel="stylesheet" type="text/css" href="/src/assets/css/light/elements/alert.css">
<link rel="stylesheet" type="text/css" href="/src/assets/css/dark/elements/alert.css">
<link rel="stylesheet" type="text/css" href="/src/assets/css/light/forms/switches.css">
<link rel="stylesheet" type="text/css" href="/src/assets/css/dark/forms/switches.css">
@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Generar reporte semanal</li>
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
                                    <h4>Reporte por semanas</h4>
                                </div>
                                <div class="m-3">
                                    <button class="btn btn-danger" wire:click="exportPDF">
                                        <div wire:loading wire:target="exportPDF">
                                            <div class="spinner-border text-white me-2 align-self-center loader-sm"></div>
                                        </div>
                                        <i class="fa-light fa-file-pdf"></i>
                                        PDF
                                    </button>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">


                    <form class="row g-3" wire:submit.prevent="generar">
                        <div class="col-md-5">
                            <label for="start" class="form-label">Fecha de inicio</label>
                            <input wire:model.defer="dateStart" type="date" class="form-control @error('dateStart') is-invalid @enderror" id="start">
                            @error('dateStart')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label for="end" class="form-label">Fecha de término</label>
                            <input wire:model.defer="dateEnd" type="date" class="form-control @error('dateEnd') is-invalid @enderror" id="end">
                            @error('dateEnd')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Generar</button>
                        </div>
                    </form>


                </div>

            </div>
        </div>




        <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>Actividades</h4>

                                </div>
                            </div>
                            <div class="widget-content widget-content-area">

                                @foreach ($porSemana as $weekNumber => $week)
                                <div>
                                    @foreach ($week as $weekLabel => $weekDates)
                                    <h4>{{ $weekLabel }}</h4>
                                    <table class="table">
                                        @foreach ($weekDates as $date)
                                        @php
                                        $parseFecha = \Carbon\Carbon::parse($date->fecha);
                                        @endphp
                                        <tr>
                                            <td>{{ $parseFecha->format('d/m/Y') }}</td>
                                            <td>{{ $parseFecha->locale('es')->isoFormat('dddd') }}</td>
                                            <td>
                                                @if ($date->tabla == 'payments')
                                                <span class="badge badge-light-primary mb-2 me-4">Pago realizado</span>
                                                @elseif ($date->tabla == 'loans')
                                                <span class="badge badge-light-secondary mb-2 me-4">Préstamo realizado</span>
                                                @elseif ($date->tabla == 'solicituds')
                                                <span class="badge badge-light-success mb-2 me-4">Solicitud realizada</span>
                                                @endif
                                            </td>
                                            <td>{{ $date->nombre }} </td>
                                            <td>${{ number_format($date->monto, 2) }}</td>
                                            <td>
                                                @if ($date->tabla == 'payments')
                                                <a href="{{ route('payments.show', $date->id) }}" class="btn btn-outline-info">Ver</a>
                                                @elseif ($date->tabla == 'loans')
                                                <a href="{{ route('loans.show', $date->id) }}" class="btn btn-outline-info">Ver</a>
                                                @elseif ($date->tabla == 'solicituds')
                                                <a href="{{ route('partners.solicitud.show', $date->id) }}" class="btn btn-outline-info">Ver</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    @endforeach
                                </div>
                                @endforeach

                            </div>
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