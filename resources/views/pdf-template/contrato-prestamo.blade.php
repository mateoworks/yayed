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
                <img src="{{ url('src/assets/img/cork-logo.png') }}" height="100" alt="">
            </td>
            <td>
                <h5 class="m-0">CAJA DE</h5>
                <h5 class="m-0">PRÉSTAMOS</h5>
                <h5 class="m-0">YA' YED</h5>
                <p class="m-0">
                    C. Independencia S/N, San Baltazar Loxicha
                </p>
            </td>
            <td class="text-end">
                <h5>Contrato de préstamo</h5>
                <samll>Fecha de emisión: {{ \Carbon\Carbon::now() }}</small>
            </td>
        </tr>
    </table>

    @php
    $diaActual = Carbon\Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
    $fechaNacimiento = $loan->partner->birthday->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
    $fechaPrestamo = $loan->date_made->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
    @endphp

    <p style="text-align: justify;" class="mt-2">
        Mediante el presente contrato de préstamo celebrado en <strong>San Baltazar Loxicha,
            Calle Centro</strong>, a {{ $diaActual }} por una parte el C. Eutiquio,
        a quien en lo sucesivo se le denominará prestamista o acreedor con documento Nacional
        de Identidad número JAH930428 domiciliado en San Baltazar, Calle centro, segunda planta
        y por otra parte el C. {{ $loan->partner->full_name }}, a quien en adelante se
        le denominará prestatario con documento Nacional de identidad número {{ $loan->partner->curp }}
        domiciliado en {{ $loan->partner->address }}, {{ $loan->partner->suburb }}, San Baltazar Loxicha ambas partes reconocen ser mayores
        de edad con la capacidad legal necesaria para formalizar dicho contrato.
    </p>

    <p><strong>DECLARACIONES</strong></p>
    <p><strong>Declara el prestamista:</strong></p>
    <p style="text-align: justify;">
        Ser una persona moral con nombre fiscal: YAYED,
        con domicilio en San Baltazar, registrado el 1 de enero del 2000,
        presentando como documento legal de identidad número JKAGYJHDU con capacidad legal.
    </p>
    <p><strong>Declara el prestatario</strong></p>
    <p style="text-align: justify;">
        Ser una persona física de nombre {{ $loan->partner->full_name }} de nacionalidad
        mexicana, nacida en San Baltazar Loxicha donde esta enterrado su ombligo, el {{ $fechaNacimiento }},
        con domicilio en {{ $loan->partner->address }}, {{ $loan->partner->suburb }}, San Baltazar Loxicha presentando
        como documento legal de identidad CURP {{ $loan->partner->curp }} con capacidad legal.
    </p>
    <p style="text-align: justify;">Dicho lo anterior, ambas partes deciden celebrar el
        presente contrato de préstamo a tenor de las siguientes clausulas.</p>
    <p><strong>CLÁUSULAS</strong></p>
    <p style="text-align: justify;">
        <strong>Primera</strong> - El prestamista entrega al prestatario
        {{ $loan->amount_letter }} PESOS MEXICANOS (${{number_format($loan->amount, 2)}} MXN) mediante este contrato
        SIMPLE con fecha {{ $fechaPrestamo }}, cuyo costo comercial es de {{ $loan->amount_letter }} PESOS MEXICANOS (${{number_format($loan->amount, 2)}} MXN).
    </p>
    <p style="text-align: justify;">
        <strong>Segunda</strong>. - El prestatario manifiesta que los {{ strtolower($loan->amount_letter) }} pesos mexicanos
        (${{number_format($loan->amount, 2)}} MXN) tienen como finalidad mejorar la producción del campo,
        por ende, solo el prestatario podrá hacer uso del mismo.
    </p>
    <p style="text-align: justify;">
        <strong>Tercera</strong>. -
    </p>
    <p style="text-align: justify;">
        <strong>Cuarta</strong>. -
    </p>
    <p style="text-align: justify;">
        <strong>Quinta</strong>. -
    </p>
    <p style="text-align: justify;">
        <strong>Sexta</strong>. -
    </p>
    <table class="table">
        <tr>
            <td>
                <p class="text-center">El prestamista</p>
                <p class="text-center mt-3"><strong>YAYED</strong></p>
            </td>
            <td>
                <p class="text-center">El prestatario</p>
                <p class="text-center mt-3"><strong>C. {{ $loan->partner->full_name }}</strong></p>
            </td>
        </tr>
    </table>

</body>

</html>