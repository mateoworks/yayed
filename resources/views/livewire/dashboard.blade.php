@section('title', 'Inicio')

@push('styles')
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<link href="/src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
<link href="/src/assets/css/light/components/list-group.css" rel="stylesheet" type="text/css">
<link href="/src/assets/css/light/dashboard/dash_2.css" rel="stylesheet" type="text/css" />

<link href="/src/assets/css/dark/components/list-group.css" rel="stylesheet" type="text/css">
<link href="/src/assets/css/dark/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
@endpush

<div class="middle-content container-xxl p-0">

    <div class="row layout-top-spacing">

        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-one">
                <div class="widget-heading">

                    <h5 class="">Préstamos realizados</h5>
                    <div class="task-action">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="renvenue" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="19" cy="12" r="1"></circle>
                                    <circle cx="5" cy="12" r="1"></circle>
                                </svg>
                            </a>
                            <div class="dropdown-menu left" aria-labelledby="renvenue" style="will-change: transform;">
                                <a class="dropdown-item" href="javascript:void(0);">Última semana</a>
                                <a class="dropdown-item" href="javascript:void(0);">Último mes</a>
                                <a class="dropdown-item" href="javascript:void(0);">Último año</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-content">
                    <div id="prestamos_pagos"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-two">
                <div class="widget-heading">
                    <h5 class="">Préstamos según su estado</h5>
                </div>
                <div class="widget-content">
                    <div id="por-estado" class=""></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">

            <div class="widget widget-wallet-one">

                <div class="wallet-info text-center mb-3">

                    <p class="wallet-title mb-3">Balance total</p>

                    <p class="total-amount mb-3">$ 26,177.88</p>

                    <a href="#" class="wallet-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up me-2">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline>
                        </svg> Incremento del 6%</a>

                </div>

                <hr>

                <button class="btn btn-secondary w-100 mt-3">Ver movimientos históricos</button>

            </div>
        </div>

        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-two">

                <div class="widget-heading">
                    <h5 class="">Últimos préstamos</h5>
                </div>

                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="th-content">Socio</div>
                                    </th>
                                    <th>
                                        <div class="th-content">Teléfono</div>
                                    </th>
                                    <th>
                                        <div class="th-content th-heading">Cantidad</div>
                                    </th>
                                    <th>
                                        <div class="th-content"></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)
                                <tr>
                                    <td>
                                        <div class="td-content customer-name">
                                            @if ($loan->partner->image)
                                            <img src="{{ Storage::disk('public')->url($loan->partner->image) }}" alt="avatar">
                                            @else
                                            <span class="avatar-title rounded-circle bg-primary">{{ $loan->partner->names[0] ?? '' }}{{ $loan->partner->surname_father[0] }}</span>
                                            @endif
                                            <span>{{ $loan->partner->full_name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content product-invoice">{{ $loan->partner->phone }}</div>
                                    </td>
                                    <td>
                                        <div class="td-content pricing"><span class="">${{ number_format($loan->amount, 2) }}</span></div>
                                    </td>
                                    <td>
                                        <div class="td-content">
                                            <a class="btn btn-success btn-sm" href="{{ route('loans.show', $loan) }}">Ver</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-table-three">

                <div class="widget-heading">
                    <h5 class="">Socios pendientes de pago</h5>
                </div>

                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-scroll">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="th-content">Socio</div>
                                    </th>
                                    <th>
                                        <div class="th-content th-heading">Cantidad capital</div>
                                    </th>
                                    <th>
                                        <div class="th-content th-heading">Capital pagado</div>
                                    </th>
                                    <th>
                                        <div class="th-content">Fecha último pago</div>
                                    </th>
                                    <th>
                                        <div class="th-content"></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pagosPendintes as $ultimo)
                                <tr>
                                    <td>
                                        <div class="td-content product-name">
                                            <div class="align-self-center">
                                                <p class="prd-name">{{ $ultimo->fullname }}</p>
                                                <p class="prd-category text-primary">{{ $ultimo->phone }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content"><span class="pricing">${{ number_format($ultimo->amount, 2) }}</span></div>
                                    </td>
                                    <td>
                                        <div class="td-content"><span class="discount-pricing">${{ number_format($ultimo->capital_pagado, 2) }}</span></div>
                                    </td>
                                    <td>
                                        <div class="td-content">{{ $ultimo->ultimo_pago }}</div>
                                    </td>
                                    <td>
                                        <div class="td-content"><a href="javascript:void(0);" class="text-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-danger feather feather-chevrons-right">
                                                    <polyline points="13 17 18 12 13 7"></polyline>
                                                    <polyline points="6 17 11 12 6 7"></polyline>
                                                </svg> Ver</a></div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="/src/plugins/src/apex/apexcharts.min.js"></script>

<script>
    window.addEventListener("load", function() {

        try {
            getcorkThemeObject = localStorage.getItem("theme");
            getParseObject = JSON.parse(getcorkThemeObject)
            ParsedObject = getParseObject;

            let porEstadoMonto = @json($statusPrestamos['monto']);
            let porEstadoLabel = @json($statusPrestamos['status']);

            let porMesValores = @json($data['value']);
            let porMesLabel = @json($data['lavel']);


            if (ParsedObject.settings.layout.darkMode) {

                var Theme = 'dark';

                Apex.tooltip = {
                    theme: Theme
                }
                /*
          =================================
              Revenue Monthly | Options
          =================================
      */
                var porMes = {
                    chart: {
                        fontFamily: 'Nunito, sans-serif',
                        height: 365,
                        type: 'area',
                        zoom: {
                            enabled: false
                        },
                        dropShadow: {
                            enabled: true,
                            opacity: 0.2,
                            blur: 10,
                            left: -7,
                            top: 22
                        },
                        toolbar: {
                            show: false
                        },
                    },
                    colors: ['#e7515a', '#2196f3'],
                    dataLabels: {
                        enabled: false
                    },
                    markers: {
                        discrete: [{
                            seriesIndex: 0,
                            dataPointIndex: 7,
                            fillColor: '#000',
                            strokeColor: '#000',
                            size: 5
                        }, {
                            seriesIndex: 2,
                            dataPointIndex: 11,
                            fillColor: '#000',
                            strokeColor: '#000',
                            size: 4
                        }]
                    },
                    subtitle: {
                        text: '$10,840',
                        align: 'left',
                        margin: 0,
                        offsetX: 100,
                        offsetY: 20,
                        floating: false,
                        style: {
                            fontSize: '18px',
                            color: '#00ab55'
                        }
                    },
                    title: {
                        text: 'Total de prestamos',
                        align: 'left',
                        margin: 0,
                        offsetX: -10,
                        offsetY: 20,
                        floating: false,
                        style: {
                            fontSize: '18px',
                            color: '#bfc9d4'
                        },
                    },
                    stroke: {
                        show: true,
                        curve: 'smooth',
                        width: 2,
                        lineCap: 'square'
                    },
                    series: [{
                        name: 'Monto $',
                        data: porMesValores,
                    }],
                    labels: porMesLabel,
                    xaxis: {
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        crosshairs: {
                            show: true
                        },
                        labels: {
                            offsetX: 0,
                            offsetY: 5,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Nunito, sans-serif',
                                cssClass: 'apexcharts-xaxis-title',
                            },
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value, index) {
                                return (value / 1000) + 'K'
                            },
                            offsetX: -15,
                            offsetY: 0,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Nunito, sans-serif',
                                cssClass: 'apexcharts-yaxis-title',
                            },
                        }
                    },
                    grid: {
                        borderColor: '#191e3a',
                        strokeDashArray: 5,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: false,
                            }
                        },
                        padding: {
                            top: -50,
                            right: 0,
                            bottom: 0,
                            left: 5
                        },
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        offsetY: -50,
                        fontSize: '16px',
                        fontFamily: 'Quicksand, sans-serif',
                        markers: {
                            width: 10,
                            height: 10,
                            strokeWidth: 0,
                            strokeColor: '#fff',
                            fillColors: undefined,
                            radius: 12,
                            onClick: undefined,
                            offsetX: -5,
                            offsetY: 0
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 20
                        }

                    },
                    tooltip: {
                        theme: Theme,
                        marker: {
                            show: true,
                        },
                        x: {
                            show: false,
                        }
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            type: "vertical",
                            shadeIntensity: 1,
                            inverseColors: !1,
                            opacityFrom: .19,
                            opacityTo: .05,
                            stops: [100, 100]
                        }
                    },
                    responsive: [{
                        breakpoint: 575,
                        options: {
                            legend: {
                                offsetY: -50,
                            },
                        },
                    }]
                }

                /* Por estado de prestamo */
                var porEstado = {
                    chart: {
                        type: 'donut',
                        width: 370,
                        height: 430
                    },
                    colors: ['#622bd7', '#e2a03f', '#e7515a', '#e2a03f'],
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        fontSize: '14px',
                        markers: {
                            width: 10,
                            height: 10,
                            offsetX: -5,
                            offsetY: 0
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 30
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '75%',
                                background: 'transparent',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '29px',
                                        fontFamily: 'Nunito, sans-serif',
                                        color: undefined,
                                        offsetY: -10
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '26px',
                                        fontFamily: 'Nunito, sans-serif',
                                        color: '#bfc9d4',
                                        offsetY: 16,
                                        formatter: function(val) {
                                            return val
                                        }
                                    },
                                    total: {
                                        show: true,
                                        showAlways: true,
                                        label: 'Total',
                                        color: '#888ea8',
                                        formatter: function(w) {
                                            return w.globals.seriesTotals.reduce(function(a, b) {
                                                return a + b
                                            }, 0)
                                        }
                                    }
                                }
                            }
                        }
                    },
                    stroke: {
                        show: true,
                        width: 15,
                        colors: '#0e1726'
                    },
                    series: porEstadoMonto,
                    labels: porEstadoLabel,

                    responsive: [{
                            breakpoint: 1440,
                            options: {
                                chart: {
                                    width: 325
                                },
                            }
                        },
                        {
                            breakpoint: 1199,
                            options: {
                                chart: {
                                    width: 380
                                },
                            }
                        },
                        {
                            breakpoint: 575,
                            options: {
                                chart: {
                                    width: 320
                                },
                            }
                        },
                    ],
                }

            } else {
                var Theme = 'dark';

                Apex.tooltip = {
                    theme: Theme
                }
                /*
          =================================
              Por mes | Options
          =================================
      */
                var porMes = {
                    chart: {
                        fontFamily: 'Nunito, sans-serif',
                        height: 365,
                        type: 'area',
                        zoom: {
                            enabled: false
                        },
                        dropShadow: {
                            enabled: true,
                            opacity: 0.2,
                            blur: 10,
                            left: -7,
                            top: 22
                        },
                        toolbar: {
                            show: false
                        },
                    },
                    colors: ['#1b55e2', '#e7515a'],
                    dataLabels: {
                        enabled: false
                    },
                    markers: {
                        discrete: [{
                            seriesIndex: 0,
                            dataPointIndex: 7,
                            fillColor: '#000',
                            strokeColor: '#000',
                            size: 5
                        }, {
                            seriesIndex: 2,
                            dataPointIndex: 11,
                            fillColor: '#000',
                            strokeColor: '#000',
                            size: 4
                        }]
                    },
                    subtitle: {
                        text: '$10,840',
                        align: 'left',
                        margin: 0,
                        offsetX: 100,
                        offsetY: 20,
                        floating: false,
                        style: {
                            fontSize: '18px',
                            color: '#4361ee'
                        }
                    },
                    title: {
                        text: 'Total prestamos',
                        align: 'left',
                        margin: 0,
                        offsetX: -10,
                        offsetY: 20,
                        floating: false,
                        style: {
                            fontSize: '18px',
                            color: '#0e1726'
                        },
                    },
                    stroke: {
                        show: true,
                        curve: 'smooth',
                        width: 2,
                        lineCap: 'square'
                    },
                    series: [{
                        name: 'Monto $',
                        data: porMesValores,
                    }, ],
                    labels: porMesLabel,
                    xaxis: {
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        crosshairs: {
                            show: true
                        },
                        labels: {
                            offsetX: 0,
                            offsetY: 5,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Nunito, sans-serif',
                                cssClass: 'apexcharts-xaxis-title',
                            },
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value, index) {
                                return (value / 1000) + 'K'
                            },
                            offsetX: -15,
                            offsetY: 0,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Nunito, sans-serif',
                                cssClass: 'apexcharts-yaxis-title',
                            },
                        }
                    },
                    grid: {
                        borderColor: '#e0e6ed',
                        strokeDashArray: 5,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: false,
                            }
                        },
                        padding: {
                            top: -50,
                            right: 0,
                            bottom: 0,
                            left: 5
                        },
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        offsetY: -50,
                        fontSize: '16px',
                        fontFamily: 'Quicksand, sans-serif',
                        markers: {
                            width: 10,
                            height: 10,
                            strokeWidth: 0,
                            strokeColor: '#fff',
                            fillColors: undefined,
                            radius: 12,
                            onClick: undefined,
                            offsetX: -5,
                            offsetY: 0
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 20
                        }

                    },
                    tooltip: {
                        theme: Theme,
                        marker: {
                            show: true,
                        },
                        x: {
                            show: false,
                        }
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            type: "vertical",
                            shadeIntensity: 1,
                            inverseColors: !1,
                            opacityFrom: .19,
                            opacityTo: .05,
                            stops: [100, 100]
                        }
                    },
                    responsive: [{
                        breakpoint: 575,
                        options: {
                            legend: {
                                offsetY: -50,
                            },
                        },
                    }]
                }

                var porEstado = {
                    chart: {
                        type: 'donut',
                        width: 370,
                        height: 430
                    },
                    colors: ['#622bd7', '#e2a03f', '#e7515a', '#e2a03f'],
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        fontSize: '14px',
                        markers: {
                            width: 10,
                            height: 10,
                            offsetX: -5,
                            offsetY: 0
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 30
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '75%',
                                background: 'transparent',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '29px',
                                        fontFamily: 'Nunito, sans-serif',
                                        color: undefined,
                                        offsetY: -10
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '26px',
                                        fontFamily: 'Nunito, sans-serif',
                                        color: '#0e1726',
                                        offsetY: 16,
                                        formatter: function(val) {
                                            return val
                                        }
                                    },
                                    total: {
                                        show: true,
                                        showAlways: true,
                                        label: 'Total',
                                        color: '#888ea8',
                                        formatter: function(w) {
                                            return w.globals.seriesTotals.reduce(function(a, b) {
                                                return a + b
                                            }, 0)
                                        }
                                    }
                                }
                            }
                        }
                    },
                    stroke: {
                        show: true,
                        width: 15,
                        colors: '#fff'
                    },
                    series: porEstadoMonto,
                    labels: porEstadoLabel,

                    responsive: [{
                            breakpoint: 1440,
                            options: {
                                chart: {
                                    width: 325
                                },
                            }
                        },
                        {
                            breakpoint: 1199,
                            options: {
                                chart: {
                                    width: 380
                                },
                            }
                        },
                        {
                            breakpoint: 575,
                            options: {
                                chart: {
                                    width: 320
                                },
                            }
                        },
                    ],
                }
            }

            /**
      ==============================
      |    @Render Charts Script    |
      ==============================
  */
            var porMesChart = new ApexCharts(
                document.querySelector("#prestamos_pagos"),
                porMes
            );

            porMesChart.render();

            /* Por estado render */
            var chart = new ApexCharts(
                document.querySelector("#por-estado"),
                porEstado
            );

            chart.render();

        } catch (e) {
            console.log(e);
        }
    });
</script>
@endpush