@section('title', 'Reporte de prestamo: ' . $loan->id)
@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

<link href="/src/assets/css/light/apps/invoice-preview.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/apps/invoice-preview.css" rel="stylesheet" type="text/css" />
<style>
    body {
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .invoice-container {
        color: black;
    }
</style>
@endpush
<div class="middle-content container-xxl p-0">

    <div class="row invoice layout-top-spacing layout-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="doc-container">

                <div class="row">

                    <div class="col-xl-9">

                        <div class="invoice-container">
                            <div class="invoice-inbox">

                                <div id="ct" class="">

                                    <div class="invoice-00001">
                                        <div class="content-section">

                                            <div class="inv--head-section inv--detail-section">

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
                                                            <p class="text-center"><strong>YAYED</strong></p>
                                                        </td>
                                                        <td>
                                                            <p class="text-center">El prestatario</p>
                                                            <p class="text-center"><strong>C. {{ $loan->partner->full_name }}</strong></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <p>Avales</p>
                                                <div class="card-group">
                                                    @foreach ($loan->endorsements as $endorsement)
                                                    <div class="card">

                                                        <p>{{ $endorsement->full_name }}</p>

                                                    </div>
                                                    @endforeach

                                                </div>

                                            </div>


                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>

                    <div class="col-xl-3">

                        <div class="invoice-actions-btn">

                            <div class="invoice-action-btn">

                                <div class="row">
                                    <div class="col-xl-12 col-md-3 col-sm-6">
                                        <a href="javascript:void(0);" class="btn btn-secondary btn-print  action-print">
                                            <i class="fa-light fa-print"></i>
                                            Imprimir
                                        </a>
                                    </div>
                                    <div class="col-xl-12 col-md-3 col-sm-6">
                                        <a wire:click="exportPDF" class="btn btn-danger btn-print action-print">
                                            <i class="fa-light fa-file-pdf"></i>
                                            PDF
                                        </a>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

@push('scripts')
<script src="/src/assets/js/apps/invoice-preview.js"></script>
@endpush