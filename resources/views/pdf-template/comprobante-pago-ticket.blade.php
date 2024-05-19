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

        .mt-10 {
            margin-top: 10rem;
        }
    </style>
</head>

<body>

    <table style="width:100%">
        <tr>
            <td>
                <img src="{{ url('src/assets/img/cork-logo.png') }}" height="100" alt="Logo">
            </td>
            <td>
                <h6 class="m-0">CAJA DE</h6>
                <h6 class="m-0">PRÉSTAMOS</h6>
                <h6 class="m-0">YA' YED</h6>
                <p class="m-0">
                    C. Independencia S/N, San Baltazar Loxicha
                </p>
                <p class="m-0"><strong>{{ $periodoComisariado }}</strong></p>
            </td>
        </tr>
    </table>
    <h6>Comprobante de pago</h6>
    <h6 style="color: red;">{{ $payment->numero }}</h6>
    <p>Fecha de emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    <table style="width:100%">
        <tr>
            <td>
                <strong>Socio</strong>
                <p class="m-0">{{ $loan->partner->full_name }}</p>
                <p class="m-0">{{ $loan->partner->phone }}</p>
            </td>
            <td class="text-end">


            </td>
        </tr>
    </table>
    <strong>Detalles del préstamo</strong>
    <p class="m-0">$ {{ number_format($loan->amount, 2) }}</p>
    <p class="m-0">Otorgado: {{ $loan->date_made->format('Y/m/d') }}</p>
    <h6>Pago realizado</h6>
    <table>
        <tr>
            <td>Fecha programada:</td>
            <td>{{ $payment->scheduled_date->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Fecha realizada:</td>
            <td>{{ $payment->made_date->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Contribución social:</td>
            <td>{{ $payment->social_contribution }}</td>
        </tr>
        <tr>
            <td>Periodo:</td>
            <td>{{ $payment->period }}</td>
        </tr>
        <tr>
            <td>Concepto:</td>
            <td>{{ $payment->concept }}</td>
        </tr>
    </table>

    <hr>
    <table style="width: 100%;">
        <tr>

            <th>Concepto</th>
            <th class="text-end">Importe</th>
        </tr>
        <tr>

            <td>Pago de capital</td>
            <td class="text-end">$ {{ number_format($payment->principal_amount, 2) }}</td>
        </tr>
        <tr>

            <td>Pago de interés</td>
            <td class="text-end">$ {{ number_format($payment->interest_amount, 2) }}</td>
        </tr>
        @if ($payment->other)
        <tr>

            <td>{{ $payment->other }}</td>
            <td class="text-end">$ {{ number_format(other_amount, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td class="text-center">
                <p><strong>Total</strong></p>

            </td>
            @php
            $total = $payment->principal_amount + $payment->interest_amount + $payment->other_amount;
            @endphp
            <td class="text-end">
                <p><strong>${{ number_format($total, 2) }}</strong></p>
            </td>
        </tr>
    </table>

    <table style="width:100%" class="mt-4">
        <tr>
            <td class="text-center mb-10">Cajero</td>
        </tr>
        <tr>
            <td style="height: 4rem;"></td>
        </tr>
        <tr>
            <td class="text-center mt-10">_________________________</td>
        </tr>
        <tr>
            <td class="text-center">{{ $payment->user->full_name }}</td>
        </tr>
    </table>

</body>

</html>
