<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan</title>
    <link href="{{ asset('src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('src/assets/css/light/apps/invoice-preview.css') }}" rel="stylesheet" type="text/css" />
    <style>
        body {
            padding: 2rem;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        .striped {
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        .striped th,
        .striped td {
            text-align: left;
            padding: 16px;
        }

        .striped tr {
            background-color: lightgray;
        }

        .striped tr:nth-child(even) {
            background-color: white;
        }

        .suspendido {
            color: red;
            background-color: lightpink;
            padding: .2rem;
            font-weight: 800;
        }

        .activo {
            color: blue;
            background-color: lightblue;
            padding: .2rem;
            font-weight: 800;
        }

        .liquidado {
            color: green;
            background-color: lightgreen;
            padding: .2rem;
            font-weight: 800;
        }

        .table-border {
            border: black 1px solid;
        }

        .table-border td {
            border: black 1px solid;
        }

        .table-border-second {
            border-left: black 1px solid;
            border-bottom: black 1px solid;
            border-right: black 1px solid;
        }

        .table-border-second td {
            border-left: black 1px solid;
            border-bottom: black 1px solid;
            border-right: black 1px solid;
        }
    </style>
</head>

<body>

    <table style="width:100%">
        <tr>
            <td>
                <img src="{{ url('src/assets/img/cork-logo.png') }}" height="150" alt="">
            </td>
            <td>
                <h4 class="m-0">CAJA DE</h4>
                <h4 class="m-0">PRÉSTAMOS</h4>
                <h4 class="m-0">YA' YED</h4>
                <p class="m-0">
                    C. Independencia S/N, San Baltazar Loxicha
                </p>
            </td>
            <td class="text-end">

                <h5>Reporte de socio</h5>
                <h6 style="color: red;">{{ $partner->number }}</h6>
                <p>Fecha de emisión: {{ \Carbon\Carbon::now()->format('d/m/y H:m:s') }}</p>
            </td>
        </tr>
    </table>
    <hr>

    <table style="width: 100%;">
        <tr>
            <td style="width: 280px;">
                @if ($partner->image)
                <img src="{{ Storage::disk('public')->url($partner->image) }}" width="250" alt="">
                @else
                <img src="{{ url('img/partner-placeholder.png') }}" width="250" alt="">
                @endif
            </td>
            <td>
                <table class="table-border" style="width: 100%;">
                    <tr>
                        <td>
                            <small>Folio:</small>
                            <p class="m-0">
                                <strong style="color: red;">{{ $partner->number ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Nombre(s):</small>
                            <p class="m-0">
                                <strong>{{ $partner->names ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Primer apellido:</small>
                            <p class="m-0">
                                <strong>{{ $partner->surname_father ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Segundo apellido:</small>
                            <p class="m-0">
                                <strong>{{ $partner->surname_mother ?? '' }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>

                <table class="table-border-second" style="width: 100%;">
                    <tr>
                        <td>
                            <small>Teléfono:</small>
                            <p class="m-0">
                                <strong>{{ $partner->phone ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Calle:</small>
                            <p class="m-0">
                                <strong>{{ $partner->address ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Número:</small>
                            <p class="m-0">
                                <strong>{{ $partner->address_number ?? '' }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>

                <table class="table-border-second" style="width: 100%;">
                    <tr>
                        <td>
                            <small>Barrio:</small>
                            <p class="m-0">
                                <strong>{{ $partner->barrio ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Código postal:</small>
                            <p class="m-0">
                                <strong>{{ $partner->cp ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Colonia:</small>
                            <p class="m-0">
                                <strong>{{ $partner->suburb ?? '' }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>

                <table class="table-border-second" style="width: 100%;">
                    <tr>
                        <td>
                            <small>Municipio:</small>
                            <p class="m-0">
                                <strong>{{ $partner->municipio ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Estado:</small>
                            <p class="m-0">
                                <strong>{{ $partner->estado ?? '' }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>

                <table class="table-border-second" style="width: 100%;">
                    <tr>
                        <td>
                            <small>Fecha de nacimiento:</small>
                            <p class="m-0">
                                <strong>{{ $partner->birthday ? $partner->birthday->format('d/m/Y') : '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Edad:</small>
                            <p class="m-0">
                                <strong>{{ $partner->birthday ? $partner->age : '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Estado civil:</small>
                            <p class="m-0">
                                <strong>{{ $partner->civil_status ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Género:</small>
                            <p class="m-0">
                                <strong>{{ $partner->gender ?? '' }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>

                <table class="table-border-second" style="width: 100%;">
                    <tr>
                        <td>
                            <small>CURP:</small>
                            <p class="m-0">
                                <strong>{{ $partner->curp ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Clave INE:</small>
                            <p class="m-0">
                                <strong>{{ $partner->key_ine ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Ocupación:</small>
                            <p class="m-0">
                                <strong>{{ $partner->job ?? '' }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>

                <table class="table-border-second" style="width: 100%;">
                    <tr>
                        <td>
                            <small>Casa:</small>
                            <p class="m-0">
                                <strong>{{ $partner->dwelling ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Dependientes:</small>
                            <p class="m-0">
                                <strong>{{ $partner->dependents ?? '' }}</strong>
                            </p>
                        </td>
                        <td>
                            <small>Email:</small>
                            <p class="m-0">
                                <strong>{{ $partner->email ?? '' }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr>
    <h5>Préstamos realizados</h5>
    @forelse ($partner->loans as $loan)
    <p>
        Número de préstamo: <strong style="color: red;">{{ $loan->number }}</strong> realizado el
        <u>{{ $loan->date_made->locale('es')->isoFormat('D \d\e MMMM \d\e\l Y') }}</u>
        - capital: <strong>${{ number_format($loan->amount, 2) }}</strong>
        @if ($loan->status == 'activo')
        <span class="activo">Activo</span>
        @elseif ($loan->status == 'suspendido')
        <span class="suspendido">Suspendido</span>
        @elseif ($loan->status == 'liquidado')
        <span class="liquidado">Liquidado</span>
        @endif
    </p>
    <h6>Pagos realizados</h6>
    <table style="width: 100%;">
        <thead>
            <th>N°</th>
            <th>Fecha programada</th>
            <th>Fecha realizada</th>
            <th>Pago capital</th>
            <th>Pago interés</th>
            <th>Importe</th>
        </thead>
        @forelse ($loan->payments as $payment)

        <tbody>
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->scheduled_date->format('d/m/Y') }}</td>
                <td>{{ $payment->made_date->format('d/m/Y') }}</td>
                <td>${{ number_format($payment->principal_amount, 2) }}</td>
                <td>${{ number_format($payment->interest_amount, 2) }}</td>
                <td>${{ number_format($payment->interest_amount + $payment->principal_amount, 2) }}</td>
            </tr>
        </tbody>
        @empty
        <p>No hay pagos realizados</p>
        @endforelse

    </table>
    <hr>
    @empty
    <p>No hay préstamos realizados</p>
    @endforelse
</body>

</html>