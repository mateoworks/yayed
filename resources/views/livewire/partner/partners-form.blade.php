@section('title', 'Guardar socios')

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
                <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">Socios</a></li>
                <li class="breadcrumb-item active" aria-current="page">Guardar</li>
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
                            <h4>Guardar socio</h4>
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
                    <form class="row g-3" wire:submit.prevent="save" novalidate>


                        <div class="col-md-4">
                            <label for="partner.names" class="form-label">Nombre(s)</label>
                            <input type="text" wire:model="partner.names" class="form-control @error('partner.names') is-invalid @enderror" id="partner.names" required>
                            @error('partner.names')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="partner.surname_father" class="form-label">Apellido paterno</label>
                            <input type="text" wire:model="partner.surname_father" class="form-control @error('partner.surname_father') is-invalid @enderror" id="partner.surname_father">
                            @error('partner.surname_father')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="partner.surname_mother" class="form-label">Apellido materno</label>
                            <input type="text" wire:model="partner.surname_mother" class="form-control @error('partner.surname_mother') is-invalid @enderror" id="partner.surname_mother">
                            @error('partner.surname_mother')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="partner.number" class="form-label">
                                <i class="fa-light fa-input-numeric"></i>Número del socio
                            </label>
                            <input type="number" wire:model="partner.number" class="form-control @error('partner.number') is-invalid @enderror" id="partner.number" required>
                            @error('partner.number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="my-1 d-flex align-items-center" for="partner.address">
                                <i class="fa-regular fa-location-dot"></i> Calle</label>
                            <input type="text" wire:model="partner.address" class="form-control @error('partner.address') is-invalid @enderror" id="partner.address">
                            <small id="sh-text1" class="form-text text-muted">Calle</small>
                            @error('partner.address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="partner.address_number" class="form-label">
                                <i class="fa-light fa-hashtag"></i>Número
                            </label>
                            <input type="text" wire:model="partner.address_number" class="form-control @error('partner.address_number') is-invalid @enderror" id="partner.address_number" required>
                            @error('partner.address_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="partner.barrio" class="form-label">
                                <i class="fa-light fa-location-dot"></i>Barrio
                            </label>
                            <input type="text" wire:model="partner.barrio" class="form-control @error('partner.barrio') is-invalid @enderror" id="partner.barrio" required>
                            @error('partner.barrio')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="partner.cp" class="form-label">
                                <i class="fa-light fa-map-location-dot"></i>Código postal
                            </label>
                            <input type="number" wire:model="partner.cp" class="form-control @error('partner.cp') is-invalid @enderror" id="partner.cp" required>
                            @error('partner.cp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4" wire:ignore>
                            <label for="partner.colonia_id" class="form-label">
                                <i class="fa-regular fa-map-location-dot"></i> Colonia
                            </label>
                            <select wire:model="partner.colonia_id" class="form-select @error('partner.colonia_id') is-invalid @enderror colonia" id="partner.colonia_id">
                                <option selected disabled>Selecciona una colonia</option>
                                @foreach ($colonias as $colonia)
                                <option value="{{$colonia->id}}">{{ $colonia->name }}</option>
                                @endforeach
                            </select>
                            @error('partner.colonia_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="partner.municipio" class="form-label">
                                <i class="fa-regular fa-building"></i>Municipio
                            </label>
                            <input type="text" wire:model="partner.municipio" class="form-control @error('partner.municipio') is-invalid @enderror" id="partner.municipio" required>
                            @error('partner.municipio')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="partner.estado" class="form-label">
                                <i class="fa-light fa-building-columns"></i>Estado
                            </label>
                            <input type="text" wire:model="partner.estado" class="form-control @error('partner.estado') is-invalid @enderror" id="partner.estado" required>
                            @error('partner.estado')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="partner.dwelling" class="form-label">
                                <i class="fa-light fa-house-heart"></i>Vivienda
                            </label>
                            <select wire:model="partner.dwelling" class="form-select @error('partner.dwelling') is-invalid @enderror" id="partner.dwelling" required>
                                <option>Seleccione una opción</option>
                                <option value="Rentada">Rentada</option>
                                <option value="Prestada">Prestada</option>
                                <option value="Propia">Propia</option>
                            </select>
                            @error('partner.dwelling')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="my-1 d-flex align-items-center" for="partner-birthday">
                                <i class="fa-solid fa-calendar-days"></i> Fecha de nacimiento</label>
                            <input type="text" wire:model="partner.birthday" class="form-control @error('partner.birthday') is-invalid @enderror" id="partner-birthday">
                            @error('partner.birthday')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="partner.dependents" class="form-label">
                                <i class="fa-thin fa-people-roof"></i>Dependientes
                            </label>
                            <input type="number" wire:model="partner.dependents" class="form-control @error('partner.dependents') is-invalid @enderror" id="partner.dependents" required>
                            @error('partner.dependents')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label for="partner.civil_status" class="form-label">Estado civil</label>
                            <select wire:model="partner.civil_status" class="form-select @error('partner.civil_status') is-invalid @enderror" id="partner.civil_status" required>
                                <option>Seleccione una opción</option>
                                <option value="Casado(a)">Casado(a)</option>
                                <option value="Divorciado(a)">Divorciado(a)</option>
                                <option value="Soltero(a)">Soltero(a)</option>
                                <option value="Unión libre">Unión libre</option>
                                <option value="Viudo(a)">Viudo(a)</option>
                            </select>
                            @error('partner.civil_status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="partner.gender" class="form-label">
                                <i class="fa-light fa-user-helmet-safety"></i></i> Género
                            </label>
                            <select wire:model="partner.gender" class="form-select @error('partner.gender') is-invalid @enderror" id="partner.gender">
                                <option selected>Selecciona un género</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="No binario">No binario</option>
                            </select>
                            @error('partner.gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="my-1 d-flex align-items-center" for="partner.phone">
                                <i class="fa-regular fa-phone"></i> Teléfono</label>
                            <input type="text" wire:model="partner.phone" class="form-control @error('partner.phone') is-invalid @enderror" id="partner.phone">
                            @error('partner.phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4" wire:ignore>
                            <label for="partner.job_id" class="form-label">
                                <i class="fa-light fa-user-helmet-safety"></i></i> Ocupación
                            </label>
                            <select wire:model="partner.job_id" class="form-select @error('partner.job') is-invalid @enderror job" id="partner.job_id">
                                <option selected>Selecciona una ocupación</option>
                                @foreach ($jobs as $job)
                                <option value="{{$job->id}}">{{$job->name}}</option>
                                @endforeach
                            </select>
                            @error('partner.job_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="my-1 d-flex align-items-center" for="partner.curp">
                                <i class="fa-regular fa-id-card-clip"></i> CURP</label>
                            <input type="text" wire:model="partner.curp" class="form-control @error('partner.curp') is-invalid @enderror" id="partner.curp">
                            @error('partner.curp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="my-1 d-flex align-items-center" for="partner.key_ine">
                                <i class="fa-light fa-address-card"></i> Clave INE</label>
                            <input type="text" wire:model="partner.key_ine" class="form-control @error('partner.key_ine') is-invalid @enderror" id="partner.key_ine">
                            @error('partner.key_ine')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="my-1 d-flex align-items-center" for="partner.email">
                                <i class="fa-regular fa-envelope"></i> Correo electrónico</label>
                            <input type="email" wire:model="partner.email" class="form-control @error('partner.email') is-invalid @enderror" id="partner.email">
                            @error('partner.email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="col-md-6">
                            @if ($image)
                            <a wire:click="$set('image', null)" class="btn btn-warning">Quitar</a>
                            <img src="{{ $image->temporaryUrl() }}" height="150px" alt="...">
                            @elseif ($partner->image)
                            <a class="btn btn-danger" wire:click="deleteImg">Quitar</a>
                            <img src="{{ Storage::disk('public')->url($partner->image) }}" height="150px" alt="...">
                            @endif

                            <label for="image" class="form-label">Foto</label>
                            <input type="file" wire:model="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                            <small id="sh-text1" class="form-text text-muted">Opcional</small>
                            <div wire:loading wire:target="image">
                                <div class="spinner-border spinner-border-reverse align-self-center text-secondary">
                                    Subiendo...
                                </div>
                            </div>
                            @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <hr>

                        <div class="row">
                            <h3>Agregar documentos (opcional)</h3>
                            <div class="col-md-2">
                                <button class="btn text-white btn-info btn-sm" wire:click.prevent="add({{$i}})">Agregar</button>
                            </div>
                        </div>

                        @foreach($inputs as $key => $value)
                        <div class=" add-input">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="type.{{$value}}" class="form-label">Selecciona tipo de documento</label>
                                    <div class="form-group">
                                        <select class="form-select @error('type.' . $value) is-invalid @enderror" wire:model="type.{{ $value }}" aria-label="Tipo de documento" id="type.">
                                            <option selected>Selecciona tipo de documento</option>
                                            <option value="Acta de nacimiento">Acta de nacimiento</option>
                                            <option value="Credencial INE">Credencial INE</option>
                                            <option value="CURP">CURP</option>
                                            <option value="Licencia conducir">Licencia conducir</option>
                                            <option value="Recibo de luz">Recibo de luz</option>
                                        </select>
                                        @error('type.' . $value)
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <label for="file.{{$value}}" class="form-label">Documento</label>
                                    <input type="file" wire:model="file.{{$value}}" class="form-control-file @error('file.' . $value) is-invalid @enderror" id="file.{{$value}}" accept=".jpg,.jpeg,.bmp,.png,.pdf">

                                    <div wire:loading wire:target="file.{{$value}}">
                                        <div class="spinner-border spinner-border-reverse align-self-center text-secondary">
                                            Subiendo...
                                        </div>

                                    </div>
                                    @error('file.' . $value)
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-danger btn-sm" wire:click.prevent="remove({{$key}})">Quitar</button>
                                </div>

                            </div>
                        </div>
                        @endforeach

                        <hr class="mt-3">
                        <div class="row">
                            <div class="col-md-8">
                                <table>
                                    @forelse ($partner->documents as $document)
                                    <tr>
                                        <td>
                                            {{ $document->type }}
                                        </td>
                                        <td>
                                            @php
                                            $ext = pathinfo(Storage::disk('public')->url($document->url), PATHINFO_EXTENSION)
                                            @endphp
                                            @if ($ext == 'jpg' || $ext == 'png' || $ext == 'png')
                                            <img src="{{ Storage::disk('public')->url($document->url) }}" height="40px" alt="...">
                                            @elseif ($ext == 'pdf')
                                            <img src="/img/pdf.png" alt="PDF" height="40px">
                                            @else
                                            <img src="/img/pdf.png" height="40px" alt="No hay previsualización">
                                            @endif

                                        </td>
                                        <td>
                                            <a wire:click.prevent="deleteDocument({{ $document }})" class="btn btn-danger">Eliminar</a>
                                        </td>
                                    </tr>
                                    @empty

                                    @endforelse
                                </table>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
                        </div>
                    </form>
                    <!-- End form -->

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
    flatpickr("#partner-birthday", {
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
        $(".job").select2({
            placeholder: "Selecciona una categoría",
            tags: true
        });
        $('.job').on('change', function(e) {
            @this.set('partner.job_id', e.target.value);
        });

        $(".colonia").select2({
            placeholder: "Selecciona una categoría",
            tags: true
        });
        $('.colonia').on('change', function(e) {
            @this.set('partner.colonia_id', e.target.value);
        });
    });
</script>
@endpush