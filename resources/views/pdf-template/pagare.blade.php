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

                <h5>Pagaré</h5>
                <h6 style="color: red;">{{ $loan->numero }}</h6>
                <p>Fecha de emisión: {{ $loan->date_made->format('d/m/Y') }}</p>
            </td>
        </tr>
    </table>
    <hr>
    <p style="text-align: justify;">
        Debo y pagaré incondicionalmente por este pagaré, a la orden de LA CAJA DE PRESTAMO "YA' YED"
        DEL COMISARIADO DE BIENES COMUNALES , en esta ciudad de SAN BALTAZAR LOXICHA en el domicilio marcado
        calle INDEPENDENCIA, CENTRO, TERCERA PLANTA A UN LADO DE LA BIBLIOTECA PUBLICA MUNICIPAL S/N.

    </p>
    <p style="text-align: justify;">
        La cantidad de ${{ number_format($loan->amount, 2) }} ({{ $loan->amount_letter }} PESOS), cantidad recibida en efectivo a mi entera
        satisfacción, debiendo realizar el pago el día.
    </p>
    <table style="width: 100%;" class="table-amortizacion">
        <thead>
            <th>Periodos</th>
            <th>Fechas</th>
            <th>Saldo inicial</th>
            <th>Interés</th>
            <th>Amortización</th>
            <th>Saldo a pagar</th>
        </thead>
        <tbody>
            @forelse ($amortizacion as $amor)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $amor->fecha->addMonth()->format('d/m/Y') }}</td>
                <td class="text-end">${{ number_format($amor->saldoInicial, 2) }}</td>
                <td class="text-end">${{ number_format($amor->interes, 2) }}</td>
                <td class="text-end">${{ number_format($amor->amortizacion, 2) }}</td>
                <td class="text-end">${{ number_format($amor->saldoPagar, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No hay datos, algo anda mal con el periodo</td>
            </tr>
            @endforelse
        </tbody>
    </table>



    <p style="text-align: justify;" class="mt-1">
        Valor recibido a mi entera satisfacción, este pagare forma parte de una serie numerada del
        1 al {{ $loan->number }} y todos están sujetos a la condición de que, al no pagarse cualquiera de ellos a
        su vencimiento, serán exigibles todos los que le sigan en número, además de los ya vencidos,
        desde la fecha de vencimiento de este documento hasta el día de su liquidación.
    </p>
    <p style="text-align: justify;">
        Este pagaré generará un interés ordinario de 2% (dos por ciento) mensual por concepto
        de interés ordinario por todo el tiempo que permanezca insoluto el adeudo. Igualmente
        obligándome a pagar para el caso de mora un interés moratorio equivalente al 3%
        tres por ciento) mensual a partir de la fecha en que se constituya en mora y hasta su total liquidación.
    </p>
    <p style="text-align: justify;">
        La cantidad resultante de los intereses podrá ser capitalizada de conformidad al artículo
        363 del código de comercio. Los deudores renuncian al fuero que por razón de su domicilio
        presente o futuro pudiera corresponderles y se someten a la jurisdicción de los tribunales
        competentes del Primer Partido Judicial del Estado de SAN BALTAZAR LOXICHA.
    </p>

    @if ($periodos<=8) <div style="page-break-after:always;">
        </div>
        @endif


        <p>
            Suscrito en SAN BALTAZAR LOXICHA,
            {{ $loan->date_made->format('d') == 1 ? 'a' : 'a los' }}
            ({{ $loan->date_made->format('d') }})
            {{ $loan->date_made->format('d') == 1 ? 'día' : 'días' }}
            del mes de {{ $loan->date_made->locale('es')->isoFormat('MMMM') }} del año {{ $loan->date_made->format('Y') }}.
        </p>
        <p><strong>Suscriptor (Deudor principal): </strong>{{ $partner->full_name }}</p>
        <p><strong>Dirección: </strong>{{ $partner->address }} {{ $partner->address_number }}</p>
        <p><strong>Municipio:</strong>{{ $partner->municipio }}</p>
        <p class="mt-5"><strong>Firma:</strong>___________________________</p>

        <table>
            @foreach ($avales as $aval)
            <tr>
                <td class="pt-3">
                    <p class="m-0">AVAL: {{$aval->full_name}}</p>
                    <p class="m-0">DIRECCION: {{ $aval->address }}</p>
                    <p class="m-0">MUNICIPIO: SAN BALTAZAR LOXICHA</p>
                    <p class="m-0">CELULAR: {{ $aval->phone }}</p>

                </td>
                <td class="ps-3">
                    <p><strong>Firma:</strong></p>__________________________
                </td>
            </tr>
            @endforeach
        </table>
        @if ($garantias)
        <p class="mt-4"><strong>GARANTÍA: </strong>
            @foreach ($garantias as $garantia)
            @if ($loop->last)
            {{ $garantia->description }}.
            @else
            {{ $garantia->description }},
            @endif
            @endforeach
        </p>
        @endif

        <p class="mt-4">
            <strong>
                Firma:______________________________
            </strong>
        </p>
</body>

</html>