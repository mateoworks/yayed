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

                <h5>Plan de pagos</h5>
                <p>Fecha de emisión: {{ \Carbon\Carbon::now() }}</p>
            </td>
        </tr>
    </table>
    <hr>
    <table style="width:100%">
        <tr>
            <td>
                <h5>Socio</h5>
                <p class="m-0">{{ $loan->partner->full_name }}</p>
                <p class="m-0">{{ $loan->partner->address }}</p>
                <p class="m-0">{{ $loan->partner->phone ?? '' }}</p>
            </td>
            <td class="text-end">
                <h5>Detalles del préstamo</h5>
                <p class="m-0">Cantidad capital: ${{ number_format($loan->amount, 2) }}</p>
                <p class="m-0">Fecha que se otorgó el préstamo: {{ $loan->date_made->format('Y-m-d') }}</p>
                <p class="m-0">Interés: {{ $loan->interest }}%</p>
            </td>
        </tr>
    </table>
    <hr>
    <table class="striped">
        <thead>
            <th>N° pago</th>
            <th>Fecha programada</th>
            <th class="text-end">Capital actual</th>
            <th class="text-end">Pago de capital</th>
            <th class="text-end">Pago de interés</th>
        </thead>
        <tbody>
            @foreach ($plan as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->mes->addMonth()->format('Y-m-d') }}</td>
                <td class="text-end">${{ number_format($p->capital, 2) }}</td>
                <td class="text-end">${{ number_format($p->pagoCapital, 2) }}</td>
                <td class="text-end">${{ number_format($p->interes, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        <small>Se recomienda realizar los pagos en las fechas programadas para facilitar el cumpliemiento,
            cualquier duda puede preguntar las 24hrs. con la gran cajera.
        </small>
    </div>
</body>

</html>