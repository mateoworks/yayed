@section('title', 'Registrar movimiento')

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/css/light/loaders/custom-loader.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/dark/loaders/custom-loader.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/src/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="/src/plugins/src/select2/css/select2.min.css">

@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('movements.index') }}">Movimientos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registrar movimiento</li>
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
                            <h4>Registrar movimiento
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">


                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <div class="row">

                        <form wire:submit.prevent="save">
                            <div class="form-group row mb-4">
                                <label for="movement.date_movement" class="col-sm-4 col-form-label">Fecha del movimiento</label>
                                <div class="col-sm-4">
                                    <input type="text" wire:model="movement.date_movement" class="form-control @error('movement.date_movement') is-invalid @enderror dates" id="movement.date_movement">
                                    @error('movement.date_movement')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="movement.type" class="col-sm-4 col-form-label">Tipo movimiento</label>
                                <div class="col-sm-4">
                                    <select wire:model="movement.type" class="form-select @error('movement.type') is-invalid @enderror" id="movement.type">
                                        <option selected>Selecciona un tipo de movimiento</option>
                                        <option value="ingreso">Ingreso</option>
                                        <option value="egreso">Egreso</option>
                                    </select>
                                    @error('movement.type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="movement.category_movement_id" class="col-sm-4 col-form-label">Categoría</label>
                                <div class="col-sm-4" wire:ignore>
                                    <select wire:model="movement.category_movement_id" class="form-select @error('movement.category_movement_id') is-invalid @enderror catogoria" id="categoria">
                                        <option selected disabled>Selecciona una categoría</option>
                                        @forelse ($categorias as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @empty
                                        <option>No hay categorías</option>
                                        @endforelse
                                    </select>
                                    @error('movement.category_movement_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="movement.concept" class="col-sm-4 col-form-label">Concepto</label>
                                <div class="col-sm-4">
                                    <input type="text" wire:model="movement.concept" class="form-control @error('movement.concept') is-invalid @enderror" id="movement.concept">
                                    @error('movement.concept')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="movement.amount" class="col-sm-4 col-form-label">Monto</label>
                                <div class="col-sm-4">
                                    <input type="number" wire:model="movement.amount" class="form-control @error('movement.amount') is-invalid @enderror" id="movement.amount">
                                    @error('movement.amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="movement.description" class="col-sm-4 col-form-label">Decripcion</label>
                                <div class="col-sm-4">
                                    <input type="text" wire:model="movement.description" class="form-control @error('movement.description') is-invalid @enderror" id="movement.description">
                                    @error('movement.description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <button class="btn btn-primary" type="submit">Registrar</button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- CONTENT AREA -->
</div>

@push('scripts')
<script src="/src/plugins/src/flatpickr/flatpickr.js"></script>
<script src="/js/jquery-3.6.0.min.js"></script>
<script src="/src/plugins/src/select2/js/select2.min.js"></script>
<script>
    flatpickr(".dates", {
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

    $(document).ready(function() {
        $(".catogoria").select2({
            placeholder: "Selecciona una categoría",
            tags: true
        });
        $('.catogoria').on('change', function(e) {
            @this.set('movement.category_movement_id', e.target.value);
        });
    });
</script>
@endpush