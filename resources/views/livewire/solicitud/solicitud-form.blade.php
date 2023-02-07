@section('title', 'Solicitud de préstamo')

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/css/light/loaders/custom-loader.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/dark/loaders/custom-loader.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/src/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="/src/plugins/src/select2/css/select2.min.css">

<link href="/src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css" />

@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">Socios</a></li>
                <li class="breadcrumb-item"><a href="{{ route('partners.show', $partner) }}">{{ $partner->full_name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Realizar solicitud de préstamo</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->

    <!-- CONTENT AREA -->
    <div class="row layout-top-spacing">

        <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Solicitud de préstamo</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <!-- Begin form -->
                    <form wire:submit.prevent="save" class="row g-3" novalidate>

                        <div class="col-md-4">
                            <label for="solicitud.date_solicitud" class="form-label">Fecha de la solicitud</label>
                            <input type="date" wire:model="solicitud.date_solicitud" class="form-control @error('solicitud.date_solicitud') is-invalid @enderror date" id="solicitud.date_solicitud" required>
                            @error('solicitud.date_solicitud')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="solicitud.period" class="form-label">Periodo (número de meses)</label>
                            <input type="number" wire:model="solicitud.period" wire:change="updateDate" class="form-control @error('solicitud.period') is-invalid @enderror" id="solicitud.period" required>
                            @error('solicitud.period')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="solicitud.date_payment" class="form-label">Fecha de pago</label>
                            <input type="date" wire:model="solicitud.date_payment" class="form-control @error('solicitud.date_payment') is-invalid @enderror date" id="solicitud.date_payment" required>
                            @error('solicitud.date_payment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="solicitud.mount" class="form-label">Monto solicitado</label>
                            <input type="number" wire:model="solicitud.mount" class="form-control @error('solicitud.mount') is-invalid @enderror" id="solicitud.mount" required>
                            @error('solicitud.mount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="solicitud.concept" class="form-label">Concepto</label>
                            <input type="text" wire:model="solicitud.concept" class="form-control @error('solicitud.concept') is-invalid @enderror" id="solicitud.concept" required>
                            @error('solicitud.concept')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div>
                            <button class="btn btn-primary">Realizar solicitud</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT AREA -->


</div>




@push('scripts')
<script src="/js/jquery-3.6.0.min.js"></script>
<script src="/src/plugins/src/flatpickr/flatpickr.js"></script>
<script>
    flatpickr(".date", {
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            },
            months: {
                shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            },
        },
    });

    window.addEventListener('show-modal', () => {
        $('#modal').modal('show');
    });

    window.addEventListener('hide-modal', () => {
        $('#modal').modal('hide');
    });

    window.addEventListener('save-endorsement', event => {
        $('#modal').modal('hide');
        Snackbar.show({
            showAction: false,
            text: event.detail.message,
            pos: 'top-center',
            actionTextColor: '#fff',
            backgroundColor: '#00ab55',

        });
    });
</script>


@endpush