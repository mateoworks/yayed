@section('title', 'Realizar pago')

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/css/light/loaders/custom-loader.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/dark/loaders/custom-loader.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/src/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css">

<link href="/src/assets/css/light/components/media_object.css" rel="stylesheet" type="text/css">
<link href="/src/assets/css/dark/components/media_object.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="/src/assets/css/light/forms/switches.css">
<link rel="stylesheet" type="text/css" href="/src/assets/css/dark/forms/switches.css">

<!--  BEGIN CUSTOM STYLE FILE  -->
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
                <li class="breadcrumb-item active" aria-current="page">Realizar pago</li>
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
                            <h4>Realizar pago del préstamo
                                <a href="{{ route('loans.show', $loan) }}" class="text-decoration-underline">{{ $loan->number }} otorgado a {{ $loan->partner->full_name }}
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    @if ($diasPendientes > 90)
                    <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><svg> ... </svg></button>
                        <strong>Advertencia!</strong> Este préstamo tiene más de 90 días sin realizar algún pago, el interés se calcula en 3%.
                    </div>
                    @endif
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <div class="row">
                        @php
                        $capitalPagado = $loan->payments->sum('principal_amount') ?? 0;
                        $pendienteCapital = $loan->amount - $capitalPagado;
                        $interesMensual = ($pendienteCapital * $loan->interest) / 100;
                        $pendienteInteres = $numMonth * $interesMensual;
                        @endphp
                        <!-- Begin form -->
                        <form wire:submit.prevent="save" class="col-md-7" novalidate>

                            <div class="form-group row mb-4">
                                <label for="interest" class="col-sm-5 col-form-label">Fecha programada de pago</label>
                                <div class="col-sm-7">
                                    <select wire:model="interest" class="form-control @error('interest') is-invalid @enderror" id="interest">
                                        <option value="2">2%</option>
                                        <option value="3">3%</option>
                                    </select>
                                    @error('interest')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="payment.scheduled_date" class="col-sm-5 col-form-label">Fecha programada de pago</label>
                                <div class="col-sm-7">
                                    <input type="date" wire:model="payment.scheduled_date" class="form-control @error('payment.scheduled_date') is-invalid @enderror" id="payment-scheduled_date">
                                    @error('payment.scheduled_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="payment.made_date" class="col-sm-5 col-form-label">Fecha realizada</label>
                                <div class="col-sm-7">
                                    <input type="date" wire:model="payment.made_date" class="form-control @error('payment.made_date') is-invalid @enderror" id="payment-made_date">
                                    @error('payment.made_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="payment.type" class="col-sm-5 col-form-label">Tipo de operacion</label>
                                <div class="col-sm-7">
                                    <input type="text" wire:model="payment.type" class="form-control @error('payment.type') is-invalid @enderror" id="payment.type">
                                    @error('payment.type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="payment.social_contribution" class="col-sm-5 col-form-label">Aportación social retiro</label>
                                <div class="col-sm-7">
                                    <input type="number" wire:model="payment.social_contribution" class="form-control @error('payment.social_contribution') is-invalid @enderror" id="payment.social_contribution">
                                    @error('payment.social_contribution')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="payment.period" class="col-sm-5 col-form-label">N° de periodo</label>
                                <div class="col-sm-7">
                                    <input type="text" wire:model="payment.period" class="form-control @error('payment.period') is-invalid @enderror" id="payment.period">
                                    @error('payment.period')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="payment.concept" class="col-sm-5 col-form-label">Concepto</label>
                                <div class="col-sm-7">
                                    <input type="text" wire:model="payment.concept" class="form-control @error('payment.concept') is-invalid @enderror" id="payment.concept">
                                    @error('payment.concept')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <h4>Operación</h4>

                            <div class="form-group row mb-4">
                                <label for="payment.interest_amount" class="col-sm-5 col-form-label">Pago de interés</label>
                                <div class="col-sm-7">
                                    <input type="number" wire:model="payment.interest_amount" class="form-control @error('payment.interest_amount') is-invalid @enderror" id="payment.interest_amount">
                                    @error('payment.interest_amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="payment.principal_amount" class="col-sm-5 col-form-label">Pago de capital</label>
                                <div class="col-sm-7">
                                    <input type="number" wire:model="payment.principal_amount" wire:change="activar" class="form-control @error('payment.principal_amount') is-invalid @enderror" id="payment.principal_amount">
                                    @error('payment.principal_amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="payment.other" class="col-sm-5 col-form-label">Otro</label>
                                <div class="col-sm-7">
                                    <input type="text" wire:model="payment.other" class="form-control @error('payment.other') is-invalid @enderror" id="payment.other">
                                    @error('payment.other')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            @if ($payment->other != null)
                            <div class="form-group row mb-4">
                                <label for="payment.other_amount" class="col-sm-5 col-form-label">Pago de otro concepto</label>
                                <div class="col-sm-7">
                                    <input type="number" wire:model="payment.other_amount" class="form-control @error('payment.other_amount') is-invalid @enderror" id="payment.other_amount">
                                    @error('payment.other_amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            @endif

                            <div class="form-group row mb-4">
                                <label for="payment.observations" class="col-sm-5 col-form-label">Observaciones</label>
                                <div class="col-sm-7">
                                    <input type="text" wire:model="payment.observations" class="form-control @error('payment.observations') is-invalid @enderror" id="payment.observations">
                                    @error('payment.observations')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <div class="switch form-switch-custom switch-inline form-switch-success">
                                    <input class="switch-input" wire:model="status" type="checkbox" role="switch" id="form-custom-switch-success">
                                    <label class="switch-label" for="form-custom-switch-success">Liquidado</label>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="pagado" class="col-sm-5 col-form-label">
                                    <p>Total a pagar:</p>
                                </label>
                                @php
                                $totalAPagar =
                                $payment->interest_amount +
                                $payment->principal_amount +
                                $payment->other_amount;
                                @endphp
                                <div class="col-sm-7">
                                    <p class="display-6">${{ number_format($totalAPagar , 2) }}</p>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="pagado" class="col-sm-5 col-form-label">Pagó con:</label>
                                <div class="col-sm-7">
                                    <input type="text" wire:model="pagado" class="form-control @error('pagado') is-invalid @enderror" id="pagado">
                                    @error('pagado')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="pagado" class="col-sm-5 col-form-label">
                                    <p>Cambio:</p>
                                </label>
                                @if ($pagado > 0)
                                <div class="col-sm-7">
                                    <p class="display-6">${{ number_format($pagado - $totalAPagar, 2) }}</p>
                                </div>
                                @endif
                            </div>

                            <div>
                                <button class="btn btn-primary" type="submit">Realizar pago</button>
                            </div>

                        </form>

                        <div class="col-md-5 order-sm-first order-last">

                            <!-- Bg Primary -->
                            <div class="card bg-primary">
                                <div class="card-body">
                                    @if ($last_payment != null)
                                    <h5 class="card-text">Último pago realizado</h5>
                                    <table>
                                        <tr class="card-text">
                                            <td>Fecha del último pago realizado:</td>
                                            <td class="text-end">{{ $last_payment->made_date->format('Y-m-d') }}</td>
                                        </tr>
                                        <tr class="card-text">
                                            <td>Cantidad de capital pagado:</td>
                                            <td class="text-end">${{ number_format($last_payment->principal_amount, 2) }}</td>
                                        </tr>
                                        <tr class="card-text">
                                            <td>Cantidad de interés pagado:</td>
                                            <td class="text-end">${{ number_format($last_payment->interest_amount, 2) }}</td>
                                        </tr>
                                        <tr class="card-text">
                                            <td>Otro pago:</td>
                                            <td class="text-end">${{ number_format($last_payment->other_amount, 2) }}</td>
                                        </tr>
                                        <tr class="card-text fw-bolder fs-6">
                                            <td><strong>Total:</strong></td>
                                            <td class="text-end">
                                                <strong>
                                                    ${{ number_format($last_payment->principal_amount + $last_payment->interest_amount + $last_payment->other_amount, 2) }}
                                                </strong>
                                            </td>
                                        </tr>
                                    </table>
                                    <a href="{{ route('payments.show', $last_payment) }}" class="btn btn-danger btn-rounded">Ver detalles del pago</a>
                                    @else
                                    <h5 class="card-text">
                                        No se han realizado pagos :)
                                    </h5>
                                    @endif
                                </div>
                            </div>

                            <div class="card border-secondary mt-3">
                                <div class="card-header">
                                    <h5>Datos del préstamo</h5>
                                </div>
                                <div class="card-body">
                                    <p class="m-0 fw-lighter">Socio:</p>
                                    <strong class="fw-bolder">{{ $loan->partner->full_name }}</strong>
                                    <p class="m-0 fw-lighter">Fecha del préstamo:</p>
                                    <strong class="fw-bolder">{{ $loan->date_made->format('Y-m-d') }}</strong>
                                    <p class="m-0 fw-lighter">Fecha programada de pago:</p>
                                    <strong class="fw-bolder">{{ $loan->date_payment->format('Y-m-d') }}</strong>
                                    <p class="m-0 fw-lighter">Cantidad capital prestado:</p>
                                    <strong class="fw-bolder">${{ number_format($loan->amount, 2) }} {{ $loan->amount_letter }} PESOS MX</strong>
                                    <p>Aportación social: <strong>{{ $loan->partner->social_contribution }}</strong></p>
                                    <hr>
                                    <p class="m-0 fw-lighter">Pagos realizados:</p>
                                    <strong class="fw-bolder">{{ $loan->payments->count() }}</strong>
                                    <p class="m-0 fw-lighter">Total capital pagado:</p>

                                    <strong class="fw-bolder">${{ number_format($capitalPagado, 2) }}; pendiente {{ number_format($pendienteCapital, 2) }}</strong>
                                    <p class="m-0 fw-lighter">Total interés pagado:</p>
                                    <strong class="fw-bolder">${{ number_format($loan->payments->sum('interest_amount'), 2) }}</strong>

                                    <h5>{{ $numMonth }} mes{{ $numMonth > 1 ? 'es' : '' }} pendientes por pagar</h5>
                                    <p>Interés: {{ $loan->interest }}%</p>
                                    <h5>
                                        Pago de interés cada mes: ${{ number_format($interesMensual, 2) }}; por {{ $numMonth }} mes{{ $numMonth > 1 ? 'es' : '' }}
                                        pendientes: ${{ number_format($pendienteInteres, 2) }}
                                    </h5>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row layout-top-spacing">

        <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Tabla de amortización

                            </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lx-12">
                            <table class="table table-bordered">
                                <thead>
                                    <th>Periodos</th>
                                    <th>Fecha programada</th>
                                    <th>Saldo inicial</th>
                                    <th>Interés</th>
                                    <th>Amortización</th>
                                    <th>Saldo a pagar</th>
                                    <th>Saldo final</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>${{ number_format($loan->amount, 2) }}</td>
                                    </tr>
                                    @foreach ($amortizacion as $amor)
                                    <tr class="{{ $payment->period == $loop->iteration ? 'table-danger' : '' }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $amor->fecha->addMonth()->format('d/m/Y') }}</td>
                                        <td>${{ number_format($amor->saldoInicial, 2) }}</td>
                                        <td>${{ number_format($amor->interes, 2) }}</td>
                                        <td>${{ number_format($amor->amortizacion, 2) }}</td>
                                        <td>${{ number_format($amor->saldoPagar, 2) }}</td>
                                        <td>${{ number_format($amor->saldoFinal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>Sumas</td>
                                        <td>${{ number_format(collect($amortizacion)->pluck('interes')->sum(), 2) }}</td>
                                        <td>${{ number_format(collect($amortizacion)->pluck('amortizacion')->sum(), 2) }}</td>
                                        <td>${{ number_format(collect($amortizacion)->pluck('saldoPagar')->sum(), 2) }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
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
<script src="/src/plugins/src/flatpickr/flatpickr.js"></script>
<script>
    flatpickr(".dates", {
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            },
            months: {
                shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            },
        },
    });
</script>
@endpush