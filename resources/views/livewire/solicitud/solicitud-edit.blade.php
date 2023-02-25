@section('title', 'Editar solicitud ' . $solicitud->folio)

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/css/light/loaders/custom-loader.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/dark/loaders/custom-loader.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/src/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="/src/plugins/src/select2/css/select2.min.css">

<link href="/src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/src/plugins/src/sweetalerts2/sweetalerts2.css">

@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">Socios</a></li>
                <li class="breadcrumb-item"><a href="{{ route('partners.show', $partner) }}">{{ $partner->full_name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('partners.solicitud.show', $solicitud) }}">{{ $solicitud->folio }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
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
                            <div class="d-flex justify-content-between">
                                <h4>Solicitud de préstamo</h4>
                                <a href="{{ route('partners.solicitud.show', $solicitud) }}" class="btn btn-info m-3">
                                    Ver solicitud
                                </a>
                            </div>
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
                        <div class="row">

                            <div class="col-md-4">
                                <label for="solicitud.condition" class="form-label">Estado de la solicitud</label>
                                <select wire:model="solicitud.condition" class="form-select @error('solicitud.condition') is-invalid @enderror date" id="solicitud.condition">
                                    <option>Elige un estado</option>
                                    <option value="denegado">Denegado</option>
                                    <option value="autorizado">Autorizado</option>
                                    <option value="en proceso">En proceso</option>
                                </select>
                                @error('solicitud.condition')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="solicitud.folio" class="form-label">Folio solicitud</label>
                                <input type="number" wire:model="solicitud.folio" class="form-control @error('solicitud.folio') is-invalid @enderror date" id="solicitud.folio" required>
                                @error('solicitud.folio')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-4">
                            <label for="solicitud.date_solicitud" class="form-label">Fecha de la solicitud</label>
                            <input type="date" wire:model="solicitud.date_solicitud" class="form-control @error('solicitud.date_solicitud') is-invalid @enderror" id="solicitud.date_solicitud">
                            @error('solicitud.date_solicitud')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="solicitud.period" class="form-label">Periodo (número de meses)</label>
                            <input type="number" wire:model="solicitud.period" wire:change="updateDate" class="form-control @error('solicitud.period') is-invalid @enderror" id="solicitud.period">
                            @error('solicitud.period')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="solicitud.date_payment" class="form-label">Fecha de pago</label>
                            <input type="date" wire:model="solicitud.date_payment" class="form-control @error('solicitud.date_payment') is-invalid @enderror date" id="solicitud.date_payment">
                            @error('solicitud.date_payment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="solicitud.mount" class="form-label">Monto solicitado</label>
                            <input type="number" wire:model="solicitud.mount" class="form-control @error('solicitud.mount') is-invalid @enderror" id="solicitud.mount">
                            @error('solicitud.mount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="solicitud.concept" class="form-label">Concepto</label>
                            <input type="text" wire:model="solicitud.concept" class="form-control @error('solicitud.concept') is-invalid @enderror" id="solicitud.concept">
                            @error('solicitud.concept')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
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

                        <table class="table">
                            <tbody>
                                @forelse ($solicitud->endorsements as $endorsement)
                                <tr>
                                    <td>{{ $endorsement->names }}</td>
                                    <td>{{ $endorsement->surnames }}</td>
                                    <td>{{ $endorsement->phone }}</td>
                                    <td><a wire:click="$emit('endorsementQuit', {{ $endorsement }})" class="btn btn-danger btn-sm">Quitar</a></td>
                                </tr>

                                @empty
                                <tr>
                                    <td>
                                        No hay avales asignados a esta solicitud.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

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
                                <div wire:loading wire:target="warranties.{{$value}}.url_document">
                                    <div class="spinner-border spinner-border-reverse align-self-center text-secondary">
                                        Subiendo...
                                    </div>
                                </div>
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
                            <div class="col-md-2">
                                <button class="btn btn-danger" wire:click.prevent="removeWarranty({{$key}})" type="button">Quitar</button>
                            </div>
                        </div>
                        <hr>
                        @endforeach

                        <table class="table">
                            <tbody>
                                @forelse ($solicitud->warranties as $warranty)
                                <tr>
                                    <td>{{ $warranty->type }}</td>
                                    <td>
                                        @if ($warranty->url_document)
                                        @php
                                        $ext = pathinfo(Storage::disk('public')->url($warranty->url_document), PATHINFO_EXTENSION)
                                        @endphp

                                        @if ($ext == 'jpg' || $ext == 'png' || $ext == 'bmp')
                                        <img src="{{ Storage::disk('public')->url($warranty->url_document) }}" height="70" alt="...">
                                        <a href="{{ route('warranties.download', $warranty) }}">Descargar</a>
                                        @elseif($ext == 'pdf')
                                        <img src="/img/pdf.png" height="70" alt="...">
                                        <a href="{{ route('warranties.download', $warranty) }}">Descargar</a>
                                        @else
                                        <img src="/img/no_preview.png" height="70" alt="...">
                                        @endif

                                        @endif
                                    </td>
                                    <td>{{ $warranty->description }}</td>
                                    <td><a wire:click="$emit('warrantyDelete', {{ $warranty }})" class="btn btn-danger btn-sm">Eliminar</a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td>
                                        No hay garantías asignados a esta solicitud.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="col-md-3">
                            <button class="btn btn-primary">Actualizar solicitud</button>
                        </div>
                </div>

                </form>

            </div>
        </div>
    </div>


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
                            <label for="endorsement.address" class="col-sm-3 col-form-label">Dirección:</label>
                            <div class="col-sm-7">
                                <input type="text" wire:model="endorsement.address" class="form-control @error('endorsement.address') is-invalid @enderror" id="endorsement.address">
                                @error('endorsement.address')
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

                    <div class="form-group row mb-1">
                        <label for="endorsement.key_ine" class="col-sm-3 col-form-label">Clave INE:</label>
                        <div class="col-sm-7">
                            <input type="text" wire:model="endorsement.key_ine" class="form-control @error('endorsement.key_ine') is-invalid @enderror" id="endorsement.key_ine">
                            @error('endorsement.key_ine')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn" wire:click="hideModal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                        <button class="btn btn-primary" wire:submit="saveEndorsement" type="submit">Guardar</button>
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
<script src="/src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>


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

    document.addEventListener('DOMContentLoaded', function() {

        @this.on('warrantyDelete', warranty => {
            Swal.fire({
                title: '¿Estas seguro de eliminar?',
                html: "Se eliminará esta garantía con el archivo adjunto",
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    @this.call('destroyWarranty', warranty)
                }
            });
        });

        @this.on('endorsementQuit', endorsement => {
            Swal.fire({
                title: '¿Estas seguro de quitar?',
                html: "El aval se desvinvulará de este socio en este préstamo",
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    @this.call('quitEndorsement', endorsement)
                }
            });
        });
    });

    window.addEventListener('message', event => {
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