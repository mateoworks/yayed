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

                <h5>Reporte de préstamo</h5>
                <h6 style="color: red;">{{ $loan->number }}</h6>
                <p>Fecha de emisión: {{ \Carbon\Carbon::now() }}</p>
            </td>
        </tr>
    </table>
    <hr>
    <table style="width:100%">
        <tr>
            <td>
                <strong>Socio</strong>
                <p class="m-0">{{ $loan->partner->full_name }}</p>
                <p class="m-0">{{ $loan->partner->address }}</p>
                <p class="m-0">{{ $loan->partner->phone }}</p>
            </td>
            <td class="text-end">
                <strong>Detalles del préstamo</strong>
                <p class="m-0">$ {{ number_format($loan->amount, 2) }}</p>
                <p class="m-0">Otorgado: {{ $loan->date_made->format('Y-m-d') }}</p>
                <p class="m-0">Interés: {{ $loan->interest }}%</p>
                <p class="m-0">Programado pago: {{ $loan->date_payment->format('Y-m-d') }}</p>
                @if ($loan->status == 'activo')
                <span class="activo">Activo</span>
                @elseif ($loan->status == 'suspendido')
                <span class="suspendido">Suspendido</span>
                @elseif ($loan->status == 'liquidado')
                <span class="liquidado">Liquidado</span>
                @endif
            </td>
        </tr>
    </table>
    <hr>
    @if ($loan->payments->count() > 0)
    <table class="striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Fecha programada</th>
                <th class="text-end">Fecha realizada</th>
                <th class="text-end">Cantidad capital</th>
                <th class="text-end">Cantidad interés</th>
            </tr>
        </thead>
        <tbody>
            @php
            $capital_pagado = 0;
            @endphp
            @foreach ($loan->payments as $payment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->scheduled_date->format('Y-m-d') }}</td>
                <td class="text-end">{{ $payment->made_date->format('Y-m-d') }}</td>
                <td class="text-end">$ {{ number_format($payment->principal_amount, 2) }}</td>
                <td class="text-end">$ {{ number_format($payment->interest_amount, 2) }}</td>
            </tr>
            @php
            $capital_pagado += $payment->principal_amount;
            @endphp
            @endforeach
        </tbody>
    </table>

    <table style="width:100%" class="mt-3">
        <tr>
            <td class="text-end">Capital pagado:</td>
            <td width="100" class="text-end">$ {{ number_format($loan->payments->sum('principal_amount'), 2) }}</td>
        </tr>
        <tr>
            <td class="text-end">Pendiente capital :</td>
            <td width="100" class="text-end">$ {{ number_format($loan->amount - $capital_pagado, 2) }}</td>
        </tr>
        <tr>
            <td class="text-end">Total interés pagado :</td>
            <td width="100" class="text-end">$ {{ number_format($loan->payments->sum('interest_amount'), 2) }}</td>
        </tr>
        <tr>
            <td class="text-end">Pagos por otros conceptos :</td>
            <td width="100" class="text-end">$ {{ number_format($loan->payments->sum('other_amount'), 2) }}</td>
        </tr>
    </table>

    @else
    <h6>No hay pagos realizados</h6>
    @endif

</body>

</html>