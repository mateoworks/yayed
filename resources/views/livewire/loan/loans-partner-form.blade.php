@section('title', 'Realizar préstamo')

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
                <li class="breadcrumb-item"><a href="{{ route('loans.index') }}">Préstamos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Realizar préstamo a {{ $partner->full_name }}</li>
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
                            <h4>Realizar préstamo</h4>
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

                        <div class="form-group row mb-4">
                            <label for="loan.amount" class="col-sm-3 col-form-label">Cantidad prestada</label>
                            <div class="col-sm-6">
                                <input type="number" wire:model="loan.amount" class="form-control @error('loan.amount') is-invalid @enderror" id="loan.amount">
                                @error('loan.amount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="loan.interest" class="col-sm-3 col-form-label">Interés</label>
                            <div class="col-sm-6">
                                <input type="number" wire:model="loan.interest" class="form-control @error('loan.interest') is-invalid @enderror" id="loan.interest" value="3">
                                @error('loan.interest')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="loan.date_made" class="col-sm-3 col-form-label">Fecha de préstamo</label>
                            <div class="col-sm-6">
                                <input type="text" wire:model="loan.date_made" class="form-control @error('loan.date_made') is-invalid @enderror" id="loan-date_made">
                                @error('loan.date_made')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="loan.date_payment" class="col-sm-3 col-form-label">Fecha programada de pago</label>
                            <div class="col-sm-6">
                                <input type="text" wire:model="loan.date_payment" class="form-control @error('loan.date_payment') is-invalid @enderror" id="loan-date_payment">
                                @error('loan.date_payment')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row mb-4">
                            <h4>Agregar avales (opcional)</h4>
                            <div class="col-md-2">
                                <button class="btn text-white btn-info btn-sm" type="button" wire:click.debounce.150ms="add({{$i}})">Agregar</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-success" type="button" wire:click.prevent="$emit('display-modal')">Registrar nuevo aval</button>
                            </div>
                        </div>

                        @foreach($inputs as $key => $value)
                        <div class="form-group row mb-4" wire:key="select-field-model-version-{{ $value }}">
                            <label for="aval.{{ $value }}" class="col-sm-3 col-form-label">Aval</label>
                            <div class="col-sm-6">
                                <select class="form-control @error('aval.' . $value) is-invalid @enderror" wire:model="aval.{{ $value }}" id="aval.{{ $value }}">
                                    <option>Selecciona un aval</option>
                                    @foreach ($endorsements as $endorsement)
                                    <option value="{{ $endorsement->id }}">{{ $endorsement->full_name }}</option>
                                    @endforeach
                                </select>
                                @error('aval.' . $value)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button class="col-sm-2 btn btn-danger" wire:click.prevent="remove({{$key}})">Quitar</button>
                        </div>
                        @endforeach

                        <hr>
                        <div class="form-group row mb-4">
                            <h4>Agregar garantías (opcional)</h4>
                            <div class="col-md-2">
                                <button class="btn text-white btn-info btn-sm" type="button" wire:click.debounce.150ms="addWarranty({{$j}})">Agregar</button>
                            </div>
                        </div>
                        @foreach ($inputsWarranty as $key => $value)
                        <div class="row">
                            <div class="col-md-3">
                                <label for="warranties.{{$value}}.type" class="form-label">Tipo</label>
                                <select class="form-control @error('warranties.' . $value . '.type') is-invalid @enderror" id="warranties.{{$value}}.type" wire:model="warranties.{{$value}}.type">
                                    <option>Selecciona un tipo</option>
                                    <option value="Escritura terreno">Escritura terreno</option>
                                    <option value="Vehículo">Vehículo</option>
                                    <option value="Joyas">Joyas</option>
                                </select>
                                @error('warranties.' . $value . '.type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="warranties.{{$value}}.url_document" class="form-label">Archivo</label>
                                <input type="file" class="form-control @error('warranties.' . $value . '.url_document') is-invalid @enderror" wire:model="warranties.{{$value}}.url_document" id="warranties.{{$value}}.url_document" accept="image/*,.pdf">
                                @error('warranties.' . $value . '.url_document')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="warranties.{{$value}}.description" class="form-label">Descripcion</label>
                                <input type="text" class="form-control @error('warranties.' . $value . '.description') is-invalid @enderror" wire:model="warranties.{{$value}}.description" id="warranties.{{$value}}.description">
                                @error('warranties.' . $value . '.description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-danger" wire:click.prevent="removeWarranty({{$key}})" type="button">Quitar</button>
                            </div>
                        </div>
                        <hr>
                        @endforeach

                        <div>
                            <button class="btn btn-primary">Realizar préstamo</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT AREA -->

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo aval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg> ... </svg>
                    </button>
                </div>
                <form wire:submit.prevent="saveEndorsement">
                    <div class="modal-body">
                        <div class="form-group row mb-1">
                            <label for="endorsement.names" class="col-sm-3 col-form-label">Nombre(s):</label>
                            <div class="col-sm-7">
                                <input type="text" wire:model="endorsement.names" class="form-control @error('endorsement.names') is-invalid @enderror" id="endorsement.names">
                                @error('endorsement.names')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label for="endorsement.surnames" class="col-sm-3 col-form-label">Apellidos:</label>
                            <div class="col-sm-7">
                                <input type="text" wire:model="endorsement.surnames" class="form-control @error('endorsement.surnames') is-invalid @enderror" id="endorsement.surnames">
                                @error('endorsement.surnames')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label for="endorsement.phone" class="col-sm-3 col-form-label">Teléfono:</label>
                            <div class="col-sm-7">
                                <input type="text" wire:model="endorsement.phone" class="form-control @error('endorsement.phone') is-invalid @enderror" id="endorsement.phone">
                                @error('endorsement.phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn" wire:click="hideModal"><i class="flaticon-cancel-12"></i> Discard</button>
                        <button class="btn btn-primary" wire:submit="saveEndorsement" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




@push('scripts')
<script src="/js/jquery-3.6.0.min.js"></script>
<script src="/src/plugins/src/flatpickr/flatpickr.js"></script>
<script>
    flatpickr("#loan-date_made", {
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

    flatpickr("#loan-date_payment", {
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