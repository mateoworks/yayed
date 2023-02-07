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

        table tfoot {
            background-color: lightgreen;
        }

        .border-table td {
            border-bottom: black 1px solid;
            border-left: black 1px solid;
            border-right: black 1px solid;
        }

        .border-bottom-td {
            border-bottom: black 1px solid;
        }

        .border-all {
            border: black 1px solid;
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
                <h4>Solicitud de crédito</h4>
                <table>
                    <tr>
                        <td>Folio de solicitud: </td>
                        <td class="text-end border-bottom-td"><strong> {{ $solicitud->folio }}</strong></td>
                    </tr>
                    <tr>
                        <td>Fecha de solicitud: </td>
                        <td class="text-end border-bottom-td">
                            <strong>{{ $solicitud->date_solicitud->format('d/m/Y') }}</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <h4 class="m-3">DATOS GENERALES</h4>
    <table style="width:100%">
        <tr class="text-center border-table">
            <td><strong>{{ $partner->names }}</strong></td>
            <td><strong>{{ $partner->surname_father }}</strong></td>
            <td><strong>{{ $partner->surname_mother }}</strong></td>
            <td><strong>{{ $partner->number }}</strong></td>
        </tr>
        <tr class="text-center">
            <td><small>Nombre(s)</small></td>
            <td><small>Apellido paterno</small></td>
            <td><small>Apellido materno</small></td>
            <td><small>No. socio</small></td>
        </tr>
    </table>

    <h4 class="m-1">DOMICILIO</h4>
    <table style="width:100%">
        <tr class="text-center border-table">
            <td><strong>{{ $partner->address }}</strong></td>
            <td><strong>{{ $partner->address_number }}</strong></td>
            <td><strong>{{ $partner->barrio }}</strong></td>
            <td><strong>{{ $partner->cp }}</strong></td>
        </tr>
        <tr class="text-center">
            <td><small>Calle</small></td>
            <td><small>Número</small></td>
            <td><small>Barrio</small></td>
            <td><small>Código postal</small></td>
        </tr>
    </table>

    <table style="width:100%">
        <tr class="text-center border-table">
            <td><strong>{{ $partner->suburb }}</strong></td>
            <td><strong>{{ $partner->municipio }}</strong></td>
            <td><strong>{{ $partner->estado }}</strong></td>
        </tr>
        <tr class="text-center">
            <td><small>Colonia</small></td>
            <td><small>Municipio</small></td>
            <td><small>Estado</small></td>
        </tr>
    </table>

    <table style="width:100%" class="mb-3">
        <tr class="text-center border-table">
            <td><strong>{{ $partner->dwelling }}</strong></td>
            <td><strong>{{ $partner->age }} años</strong></td>
            <td><strong>{{ $partner->dependents }}</strong></td>
            <td><strong>{{ $partner->civil_status }}</strong></td>
            <td><strong></strong></td>
        </tr>
        <tr class="text-center">
            <td><small>Vivienda</small></td>
            <td><small>Edad</small></td>
            <td><small>Dependientes</small></td>
            <td><small>Edo. civil</small></td>
            <td><small>Régimen</small></td>
        </tr>
    </table>

    <strong class="mt-1 mb-0">MONTO Y FINALIDAD</strong>
    <hr class="mt-0">
    <p style="text-align: justify;">
        Por la presente solicito un préstamo por la cantidad de
        <strong>${{ number_format($solicitud->mount, 2) }}</strong> a un periodo de
        <strong>{{ $solicitud->period }} MES{{ $solicitud->period > 1 ? 'ES' : '' }}</strong>
        a una tasa ordinaria de 2.00% y una tasa moratoria del 3.00% a partir de la fecha de pago.
        La finalidad del prestamo sera para: <strong>{{ $solicitud->concept }}</strong>
    </p>
    <h4 class="m-3">ACTIVIDAD DEL SOCIO</h4>
    <table style="width:100%">
        <tr class="text-center border-table">
            <td><strong>{{ $partner->job }}</strong></td>
            <td><strong>{{ $partner->phone }}</strong></td>
        </tr>
        <tr class="text-center">
            <td><small>Puesto, ocupación o giro</small></td>
            <td><small>Teléfono</small></td>
        </tr>
    </table>

    <table style="width:100%">
        <tr>
            <td><small>Ingresos mensuales</small></td>
            <td><small><strong>$</strong></small></td>
            <td></td>
            <td>Ingresos extraordinarios</td>
        </tr>
        <tr>
            <td><small>Total de gastos mensuales</small></td>
            <td>$</td>
            <td></td>
            <td rowspan="6" class="border-all">
                <p class="ms-2">Hago constar bajo protesta decir verdad, que mis ingresos y egresos son
                    los reales y en caso de incrementar notificare por este mismo medio
                    asi mismo que toda la informacion que aquí manifiesto es veridica.</p>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><small>Luz</small></td>
            <td class="pe-2"><small>200</small></td>
        </tr>
        <tr>
            <td></td>
            <td><small>Agua</small></td>
            <td class="pe-2"><small>100</small></td>
        </tr>
        <tr>
            <td></td>
            <td><small>Teléfono</small></td>
            <td><small></small></td>
        </tr>
        <tr>
            <td></td>
            <td><small>Gas</small></td>
            <td><small></small></td>
        </tr>
        <tr>
            <td></td>
            <td><small>Alimentación</small></td>
            <td><small></small></td>
        </tr>
        <tr>
            <td></td>
            <td><small>Colegiatura</small></td>
            <td><small></small></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><small>Médico</small></td>
            <td><small></small></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><small>Empleado</small></td>
            <td><small></small></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><small>Otros</small></td>
            <td><small></small></td>
            <td></td>
        </tr>
        <tr>
            <td>Disponible</td>
            <td><strong>$</strong></td>
            <td><small></small></td>
            <td></td>
        </tr>
    </table>

    <p class="text-center mt-5 mb-0">_____________________________</p>
    <p class="text-center mt-0 mb-3">{{ $partner->full_name }}</p>

    <table style="width:100%">
        <tr>
            <td rowspan="3" class="border-all" style="width: 70%;">
                <p class="m-1" style="text-align: justify;">
                    Por medio del presente manifestamos estar conciente de la
                    responsabilidad que adquirimos al fungir como aval, por lo
                    tanto me doy por enterado del contenido del Art. 109 de la Ley de operaciones y títulos de crédito que señala y define al
                </p>
                <p class="m-1" style="text-align: justify;"> AVAL como: La persona que garantiza todo o en parte el cumplimiento del
                    compromiso y obligación señalado en el pagare.</p>
            </td>
            <td class="ps-1"></td>
            <td style="background-color: lightgray;" class="text-end">Solicitud de crédito</td>
        </tr>
        <tr>
            <td class="pe-1"></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td class="border-all text-end">{{ $solicitud->folio }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <strong class="mt-3 mb-0">Avales</strong>
    <hr class="mt-0">

    <strong class="mt-3 mb-0">Garantía</strong>
    <hr class="mt-0">

    <strong class="mt-3 mb-0">Información adicional</strong>
    <hr class="mt-0">
    <p style="text-align: justify;">
        Debera de pagar en la fecha que marque su plan de pagos, ya que de no hacerlo le generara un interes
        moratorio asi mismo es la mejor recomendación para creditos futuros, ya que usted creara su propio
        historial crediticio ademas de disfrutar de beneficios adicionales.
    </p>
    <p style="text-align: justify;">
        Si llegara a registrar morosidad mayor a 90 dias, su crédito se dara por vencido anticipadamente y se le
        exigira su pago total.
    </p>
    <p style="text-align: justify;">
        Si llegara a registrar morosidad sus avalados no podran hacer uso de los servicios asi mismo se les
        notificara de sus atrazos en caso de que haga caso omiso a los recordatorios.
    </p>

    <strong class="mt-3 mb-0">Resolución</strong>
    <p>El crédito es autorizado bajo las siguientes caracteristicas y condiciones:</p>
    <hr class="mt-0">
</body>

</html>