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
            margin-top: 160px;
            padding: 2rem;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        header {
            position: fixed;
            top: 10px;
            left: 2rem;
            right: 2rem;
        }

        .striped {
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        .striped th {
            background-color: #14549C;
            color: white;
        }

        .striped th,
        .striped td {
            text-align: left;
            padding: 8px;
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

        .watermark {
            position: absolute;
            top: 100;
            left: 250;
            bottom: 0;
            right: 0;
            opacity: 0.5;
            font-size: 5em;
            text-align: center;
            transform: rotate(-45deg);
            transform-origin: 50% 50%;
            color: #d9d9d9;
        }

        .pago1 {
            background-color: #006400 !important;
            color: white !important;
        }

        .pago2 {
            background-color: #008000 !important;
            color: white !important;
        }

        .pago3 {
            background-color: #00FF00 !important;
            color: black !important;
        }

        .pago4 {
            background-color: #FFFF00 !important;
            color: black !important;
        }

        .pago5 {
            background-color: #FFA500 !important;
            color: white !important;
        }

        .pago6 {
            background-color: #FF0000 !important;
            color: white !important;
        }

        .table-totales td {
            border-bottom: black dotted 1px;
        }
    </style>
</head>

<body>
    <header>
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
                    <p class="m-0"><strong>{{ $periodoComisariado }}</strong></p>
                </td>
                <td class="text-end">

                    <h5>Reporte de préstamo</h5>
                    <h6 style="color: red;">{{ $loan->numero }}</h6>
                    <p>Fecha de emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    @if ($loan->status == 'liquidado')
    <div class="watermark">Liquidado</div>
    @endif


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
                <p class="m-0">{{ $loan->amount_letter }} PESOS MX</p>
                <p class="m-0">Otorgado: {{ $loan->date_made->format('d/m/Y') }}</p>
                <p class="m-0">Interés: {{ $loan->interest }}%</p>
                <p class="m-0">Programado pago: {{ $loan->date_payment->format('d/m/Y') }}</p>
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
    <p class="text-center"><strong>Pagos realizados</strong></p>
    <table class="striped">
        <thead>
            <tr>
                <th>Periodo</th>
                <th>N°</th>
                <th>Fecha programada</th>
                <th>Fecha realizada</th>
                <th class="text-center">No. días</th>
                <th class="text-end">Cantidad capital</th>
                <th class="text-end">Cantidad interés</th>
            </tr>
        </thead>
        <tbody>
            @php
            $capital_pagado = 0;
            $capital = 0;
            $interes = 0;
            @endphp
            @foreach ($loan->payments as $payment)
            <tr>
                <td>{{ $payment->period }}</td>
                <td>{{ $payment->numero }}</td>
                <td>{{ $payment->scheduled_date->format('d/m/Y') }}</td>
                <td>{{ $payment->made_date->format('Y-m-d') }}</td>
                <td class="text-center {{ $payment->class_color }}">{{ $payment->no_days }}</td>
                <td class="text-end">$ {{ number_format($payment->principal_amount, 2) }}</td>
                <td class="text-end">$ {{ number_format($payment->interest_amount, 2) }}</td>
            </tr>
            @php
            $capital_pagado += $payment->principal_amount;
            $capital += $payment->principal_amount;
            $interes += $payment->interest_amount;
            @endphp
            @endforeach
            <tr>
                <td colspan="5">
                    <p class="text-center">
                        <strong>Totales</strong>
                    </p>
                </td>
                <td class="text-end">${{ number_format($capital, 2) }}</td>
                <td class="text-end">${{ number_format($interes, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table style="float: right;" class="mt-3 table-totales">
        <tr>
            <td class="text-end">
                <p class="m-0">Capital pagado :</p>
            </td>
            <td width="100" class="text-end">
                <p class="m-0"><strong>${{ number_format($loan->payments->sum('principal_amount'), 2) }}</strong></p>
            </td>
        </tr>
        <tr>
            <td class="text-end">
                <p class="m-0">Pendiente capital :</p>
            </td>
            <td width="100" class="text-end">
                <p class="m-0"><strong>${{ number_format($loan->amount - $capital_pagado, 2) }}</strong></p>
            </td>
        </tr>
        <tr>
            <td class="text-end">
                <p class="m-0">Total interés pagado :</p>
            </td>
            <td width="100" class="text-end">
                <p class="m-0"><strong>${{ number_format($loan->payments->sum('interest_amount'), 2) }}</strong></p>
            </td>
        </tr>
        <tr>
            <td class="text-end">
                <p class="m-0">Pagos por otros conceptos :</p>
            </td>
            <td width="100" class="text-end">
                <p class="m-0"><strong>${{ number_format($loan->payments->sum('other_amount'), 2) }}</strong></p>
            </td>
        </tr>
    </table>
    <hr style="clear: both;">

    @else
    <h6>No hay pagos realizados</h6>
    @endif

    <p class="text-center mt-3"><strong>Avales asignados</strong></p>
    @if ($solicitud->endorsements->isNotEmpty())
    <table style="width: 100%;">
        @foreach ($solicitud->endorsements as $endorsement)
        <tr>
            <td>{{ $endorsement->full_name }}</td>
            <td>{{ $endorsement->address }}</td>
            <td>{{ $endorsement->phone }}</td>
        </tr>
        @endforeach
    </table>
    @else
    <p>No hay avales</p>
    @endif

    <p class="text-center mt-3"><strong>Garantías</strong></p>
    @if ($solicitud->warranties->isNotEmpty())
    <table>
        @foreach ($solicitud->warranties as $warranty)
        <tr>
            <td>{{ $warranty->type }}</td>
            <td>{{ $warranty->description }}</td>
            <td>
                @php
                $path = Storage::disk('public')->url($warranty->url_document);
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                @endphp
                @if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg')

                <img src="{{ Storage::disk('public')->url($warranty->url_document) }}" width="250px" alt="">

                @endif

            </td>
        </tr>
        @endforeach
    </table>
    @else
    <p>No hay garantías</p>
    @endif
</body>

</html>