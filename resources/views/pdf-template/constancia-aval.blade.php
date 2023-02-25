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
            font-size: 12pt;
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

        .foot-payment td {
            background-color: #14549C;
            color: white;
        }

        .striped th,
        .striped td {
            text-align: left;
            padding: 7px;
        }

        .striped tr:nth-child(even) {
            background-color: lightgray;
        }

        .suspendido {
            color: red;
            background-color: lightpink;
            padding: .2rem;
            font-weight: 800;
        }

        .table-amortizacion td,
        th {
            padding: 4px;
            border: black solid 1px;
        }
    </style>
</head>

<body>

    @foreach ($endorsements as $endorsement)

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
                <h5>Constancia de aval</h5>
            </td>
        </tr>
    </table>
    <hr>
    <p class="text-end">SAN BALTAZAR LOXICHA A {{ $loan->date_made->format('d') }} DE
        {{ strtoupper($loan->date_made->locale('es')->isoFormat('MMMM')) }}
        DE {{ $loan->date_made->format('Y') }}
    </p>

    <p style="text-align:justify;">
        YO <u>C. {{ strtoupper($endorsement->full_name) }}</u>, CON NUMERO DE IDENTIFICACIÓN {{ $endorsement->key_ine }},
        POR MEDIO DE LA PRESENTE MANIFIESTO ESTAR CONSCIENTE DE LA RESPONSABILIDAD DE FUNGIR COMO
        AVAL, DE C. {{ strtoupper($loan->partner->full_name) }} QUIEN FUE ACREDITADO CON UN CRÉDITO EN LA CAJA
        DE PRÉSTAMOS YA’ YED, CON LAS SIGUIENTES CARACTERÍSTICAS: TIENE UN PERIODO DE {{ $periodo }} MESES A
        PARTIR DE ESTA FECHA, HASTA EL {{ $loan->date_payment->format('d') }}
        DE {{ strtoupper($loan->date_payment->locale('es')->isoFormat('MMMM')) }} DEL {{ $loan->date_payment->format('Y') }},
        POR UN MONTO DE ${{ number_format($loan->amount, 2) }} ({{ $loan->amount_letter }} PESOS MX),
        QUE SE ESTARÁ PAGANDO EN PAGOS MENSUALES LA CANTIDAD DE ${{ number_format($pago, 2) }} (M/N).
        POR LO TANTO, ME HAGO PARTE DEL COMPROMISO Y OBLIGACIÓN SEÑALADO EN EL PAGARE DE LA CAJA DE
        PRÉSTAMOS YA’ YED, UBICADO EN EL CENTRO DE ESTE MUNICIPIO PLANTA ARRIBA.

    </p>

    <p class="text-center mt-5">______________________________</p>
    <p class="text-center m-0">{{ strtoupper($endorsement->full_name) }}</p>

    @if (!$loop->last)
    <div style="page-break-after:always;"></div>
    @endif

    @endforeach

</body>

</html>