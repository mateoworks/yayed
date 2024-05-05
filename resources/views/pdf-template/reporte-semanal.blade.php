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
                </td>
                <td class="text-end">

                    <h5>Reporte por semanas</h5>
                    <p>Fecha de emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                </td>
            </tr>
        </table>
    </header>
    <p class="text-center m-0"><strong>Comisariado de Bienes Comunales y Consejo de Vigilancia</strong></p>
    <p class="text-center m-0"><strong>{{ $periodoComisariado }}</strong></p>
    <hr>
    <p class="text-center">
        Reporte por semana de la caja de préstamos Ya'yed del
        {{ $dateStart->locale('es')->isoFormat('D \d\e MMMM \d\e\l Y') }}
        al {{ $dateEnd->locale('es')->isoFormat('D \d\e MMMM \d\e\l Y') }}
    </p>

    @foreach ($porSemana as $weekNumber => $week)
    <div>
        @foreach ($week as $weekLabel => $weekDates)
        <p><strong>{{ $weekLabel }}</strong></p>
        <table class="table">
            @foreach ($weekDates as $date)
            @php
            $parseFecha = \Carbon\Carbon::parse($date->fecha);
            @endphp
            <tr>
                <td>{{ $parseFecha->format('d/m/Y') }}</td>
                <!-- <td>{{ $parseFecha->locale('es')->isoFormat('dddd') }}</td> -->
                <td>
                    @if ($date->tabla == 'payments')
                    <p><strong>Pago realizado (I+C)</strong></p>
                    @elseif ($date->tabla == 'loans')
                    <p><strong>Préstamo realizado</strong></p>
                    @elseif ($date->tabla == 'solicituds')
                    <p><strong>Solicitud realizada</strong></p>
                    @endif
                </td>
                <td style="width: 40px;"></td>
                <td>{{ $date->nombre }} </td>
                <td>${{ number_format($date->monto, 2) }}</td>
            </tr>
            @endforeach
        </table>
        @endforeach
    </div>
    @endforeach

</body>

</html>
