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

        .striped th {
            background-color: #14549C;
            color: white;
        }

        .striped th,
        .striped td {
            text-align: left;
            border: lightgray solid 1px;
            padding: 3px;
        }

        .striped tr {
            background-color: lightgray;
        }

        .striped tr:nth-child(even) {
            background-color: white;
        }

        .negrita {
            font-weight: bold;
        }

        .striped tfoot td {
            background-color: #14549C;
            color: white;
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
                <p class="m-0"><strong>{{ $periodoComisariado }}</strong></p>
            </td>
            <td class="text-end">

                <h5>Tabla de amortización</h5>
                <p class="m-0">Folio préstamo: <strong>{{ $loan->numero }}</strong></p>
                <p class="m-0">Fecha de emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
            </td>
        </tr>
    </table>
    <hr>
    <table style="width:100%">
        <tr>
            <td>
                <h5>Socio</h5>
                <p class="m-0"><strong>Num. socio: {{ $loan->partner->numero }}</strong></p>
                <p class="m-0">{{ $loan->partner->full_name }}</p>
                <p class="m-0">{{ $loan->partner->address }}</p>
                <p class="m-0">{{ $loan->partner->phone ?? '' }}</p>
            </td>
            <td class="text-end">
                <h5>Detalles del préstamo</h5>
                <p class="m-0">Cantidad capital: ${{ number_format($loan->amount, 2) }}</p>
                <p class="m-0">Interés mensual: {{ $loan->interest }}%</p>
                <p class="m-0">Fecha que se otorgó el préstamo: {{ $loan->date_made->format('d/m/Y') }}</p>
                <p class="m-0">Fecha programada de pago: {{ $loan->date_payment->format('d/m/Y') }}</p>
            </td>
        </tr>
    </table>
    <hr>
    <table class="striped">
        <thead>
            <th>Periodo</th>
            <th>Fechas</th>
            <th class="text-end">Saldo inicial</th>
            <th class="text-end">Interés</th>
            <th class="text-end">Amortización</th>
            <th class="text-end">Saldo a pagar</th>
            <th class="text-end">Saldo final</th>
            <th style="width: 90px;"></th>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-end">${{ number_format($loan->amount, 2) }}</td>
                <td></td>
            </tr>
            @foreach ($amortizacion as $amor)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $amor->fecha->addMonth()->format('d/m/Y') }}</td>
                <td class="text-end">${{ number_format($amor->saldoInicial, 2) }}</td>
                <td class="text-end">${{ number_format($amor->interes, 2) }}</td>
                <td class="text-end">${{ number_format($amor->amortizacion, 2) }}</td>
                <td class="text-end">${{ number_format($amor->saldoPagar, 2) }}</td>
                <td class="text-end">${{ number_format($amor->saldoFinal, 2) }}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td class="negrita">Sumas</td>
                <td class="text-end negrita">${{ number_format($sumInteres, 2) }}</td>
                <td class="text-end negrita">${{ number_format($sumAmortizacion, 2) }}</td>
                <td class="text-end negrita">${{ number_format($sumInteres + $sumAmortizacion, 2) }}</td>
                <td></td>
                <td></td>
            </tr>

        </tfoot>

    </table>
    <div class="mt-4">
        <small>Se recomienda realizar los pagos en las fechas programadas para facilitar el cumplimiento
            del préstamo, cualquier duda puede consultar en la oficina de la caja de ahorro.
        </small>
    </div>
</body>

</html>
