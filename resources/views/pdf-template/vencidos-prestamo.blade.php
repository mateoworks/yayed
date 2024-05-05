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
            margin-top: 150px;
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
            padding-left: 4px;
            padding-right: 4px;
        }

        .striped td {
            border: lightgray solid 1px;
            padding-right: 4px;
            padding-left: 4px;
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

        .table-contenido td {
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
                    <p class="text-center m-0"><strong>{{ $periodoComisariado }}</strong></p>
                </td>
                <td class="text-end">

                    <h5>Préstamos vencidos</h5>
                    <p>Fecha de emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                </td>
            </tr>
        </table>
    </header>
    <p class="text-center display-6">
        <strong>
            Préstamos con mas de {{ $noDias }} días sin realizar algún pago,
            se recomienda echarle los topiles atrás
        </strong>
    </p>
    <table>
        <table style="width: 100%;" class="striped">
            <thead>
                <tr>
                    <th>N°</th>
                    <th scope="col">Socio</th>
                    <th scope="col">Último pago realizado</th>
                    <th scope="col">Capital</th>
                    <th scope="col">Capital pagado</th>
                    <th scope="col">Capital pendiente</th>
                    <th scope="col">Interés pendiente</th>
                    <th>Total pendiente</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($prestamosVencidos as $loan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <p class="m-0"><mark>{{ $loan->number }}</mark> <strong>{{ $loan->full_name }}</strong></p>
                        <p class="m-0"><small> {{ $loan->phone }}</small></p>
                    </td>
                    @php
                    $ultimoPago = \Carbon\Carbon::parse($loan->ultimo_pago);
                    @endphp
                    <td class="text-end">
                        <p class="m-0">
                            {{ $ultimoPago->format('d/m/Y') }}<br>
                            <small>{{ $ultimoPago->diffForHumans() }}</small>
                        </p>
                    </td>
                    <td class="text-end">
                        ${{ number_format($loan->amount, 2) }}</p>
                    </td>
                    <td class="text-end">
                        ${{ number_format($loan->capital_pagado, 2) }}</p>
                    </td>
                    @php
                    $capitalPendiente = $loan->amount - $loan->capital_pagado;
                    @endphp
                    <td class="text-end">
                        ${{ number_format($capitalPendiente, 2) }}</p>
                    </td>
                    @php
                    if($ultimoPago->diffInDays() > 90){
                    $interesPendiente = ($capitalPendiente * .03) * $ultimoPago->diffInMonths();
                    }else{
                    $interesPendiente = ($capitalPendiente * .02) * $ultimoPago->diffInMonths();
                    }
                    @endphp
                    <td class="text-end">${{ number_format($interesPendiente, 2) }}</td>
                    <td class="text-end">${{ number_format($capitalPendiente + $interesPendiente, 2) }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </table>


</body>

</html>