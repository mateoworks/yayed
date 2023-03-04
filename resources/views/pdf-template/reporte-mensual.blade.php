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

        .striped td {
            border: lightgray solid 1px;
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

                <h5>Reporte mensual</h5>
                <p>Fecha de emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
            </td>
        </tr>
    </table>
    <p class="text-center m-0"><strong>Comisariado de Bienes Comunales y Consejo de Vigilancia</strong></p>
    <p class="text-center m-0"><strong>Periodod 2021-2024</strong></p>
    <hr>
    <p class="text-center">
        Informe de trabajo de la caja de préstamos Ya'yed del
        {{ $dateStart->locale('es')->isoFormat('D \d\e MMMM \d\e\l Y') }}
        al {{ $dateEnd->locale('es')->isoFormat('D \d\e MMMM \d\e\l Y') }}
    </p>
    <table style="width: 100%;" class="table-container">
        <tr>
            <td class="pe-4">
                <p class="text-center"><strong>Préstamos</strong></p>
                <table style="width: 100%;" class="table-contenido">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th class="text-end">Monto</th>
                        </tr>
                    </thead>
                    @php
                    $totalPrestamo = 0;
                    @endphp
                    @foreach ($prestamosPorMes as $capital)
                    <tr>
                        <td>{{ $capital->mes != null ? ucfirst($months[$capital->mes]) : '' }} {{ $capital->anio }}</td>
                        <td class="text-end">${{ number_format($capital->monto, 2) }}</td>
                        @php
                        $totalPrestamo += $capital->monto;
                        @endphp
                    </tr>
                    @endforeach
                    <tr>
                        <td>
                            <p class="m-0"><strong> Total</strong></p>
                        </td>
                        <td class="text-end">
                            <p class="m-0"><strong>${{ number_format($totalPrestamo, 2) }}</strong></p>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="ps-4">
                <p class="text-center"><strong>Intereses</strong></p>
                <table style="width: 100%;" class="table-contenido">
                    <thead>
                        <th>Mes</th>
                        <th class="text-end">Monto</th>
                    </thead>
                    <tbody>
                        @php
                        $totalInteres = 0;
                        @endphp
                        @foreach ($interesPorMes as $interes)
                        <tr>
                            <td>{{ $interes->mes != null ? ucfirst($months[$interes->mes]) : '' }} {{ $interes->anio }}</td>
                            <td class="text-end">${{ number_format($interes->monto, 2) }}</td>
                            @php
                            $totalInteres += $interes->monto;
                            @endphp
                        </tr>
                        @endforeach
                    </tbody>

                    <tr>
                        <td>
                            <p class="m-0"><strong> Total</strong></p>
                        </td>
                        <td class="text-end">
                            <p class="m-0"><strong>${{ number_format($totalInteres, 2) }}</strong></p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
        <tr>
            <td class="pe-4 pt-4">
                <p class="text-center"><strong>Aportación social</strong></p>
                <table style="width: 100%;" class="table-contenido">
                    <thead>
                        <th>Mes</th>
                        <th class="text-end">Monto</th>
                    </thead>
                    <tbody>
                        @php
                        $totalAportacion = 0;
                        @endphp
                        @foreach ($aportacionPorMes as $aportacion)
                        <tr>
                            <td>{{ $aportacion->mes != null ? ucfirst($months[$aportacion->mes]) : '' }} {{ $aportacion->anio }}</td>
                            <td class="text-end">${{ number_format($aportacion->monto, 2) }}</td>
                            @php
                            $totalAportacion += $aportacion->monto;
                            @endphp
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <p class="m-0"><strong> Total</strong></p>
                            </td>
                            <td class="text-end">
                                <p class="m-0"><strong>${{ number_format($totalAportacion, 2) }}</strong></p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </td>
            <td class="ps-4 pt-4">
                <p class="text-center"><strong>Capital recuperado en préstamo</strong></p>
                <table style="width: 100%;" class="table-contenido">
                    <thead>
                        <th>Mes</th>
                        <th class="text-end">Monto</th>
                    </thead>
                    <tbody>
                        @php
                        $totalCapital = 0;
                        @endphp
                        @foreach ($capitalPorMes as $capital)
                        <tr>
                            <td>{{ $capital->mes != null ? ucfirst($months[$capital->mes]) : '' }} {{ $capital->anio }}</td>
                            <td class="text-end">${{ number_format($capital->monto, 2) }}</td>
                            @php
                            $totalCapital += $capital->monto;
                            @endphp
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <p class="m-0"><strong> Total</strong></p>
                            </td>
                            <td class="text-end">
                                <p class="m-0"><strong>${{ number_format($totalCapital, 2) }}</strong></p>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>

    @if(isset($payments))
    <hr>
    <p class="text-center"><strong>Pagos realizados en el periodo</strong></p>
    <table class="striped" style="width: 100%;">
        <thead>
            <tr>
                <th>Fecha programada</th>
                <th>Fecha realizada</th>
                <th>Socio</th>
                <th>Cantidad capital pagado</th>
                <th>Cantidad interés pagado</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $p)
            <tr>
                <td>{{ $p->scheduled_date->format('d/m/Y') }}</td>
                <td>{{ $p->made_date->format('d/m/Y') }}</td>
                <td>{{ $p->loan->partner->full_name }}</td>
                <td class="text-end">${{ number_format($p->principal_amount, 2) }}</td>
                <td class="text-end">${{ number_format($p->interest_amount, 2) }}</td>
                <td class="text-end">${{ number_format($p->interest_amount + $p->principal_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    @if (isset($loans))
    <hr>
    <p class="text-center"><strong>Préstamos realizados en el periodo</strong></p>
    <table class="striped" style="width: 100%;">
        <thead>
            <tr>
                <th>Socio</th>
                <th>Fecha realizada</th>
                <th>Fecha programada de pago</th>
                <th>Periodos</th>
                <th>Monto préstado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $p)
            <tr>
                <td>{{ $p->partner->full_name }}</td>
                <td>{{ $p->date_made->format('d/m/Y') }}</td>
                <td>{{ $p->date_payment->format('d/m/Y') }}</td>
                <td>{{ $p->date_made->diffInMonths($p->date_payment) }}</td>
                <td class="text-end">${{ number_format($p->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</body>

</html>