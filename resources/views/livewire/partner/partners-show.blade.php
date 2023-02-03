@section('title', 'Socio: ' . $partner->names . ' ' . $partner->surname_father . ' ' . $partner->surname_mother)

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('partners.index') }}">Socios</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $partner->names }}</li>
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
                        <div class="col-xl-8 col-md-6 col-sm-12 col-8">
                            <h4>Datos de {{ $partner->names }} {{ $partner->surname_father }} {{ $partner->surname_mother }}</h4>
                        </div>
                        <div class="col-4 mt-2">
                            <a href="{{ route('partners.edit', $partner) }}" class="btn btn-info">Editar</a>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="row">
                        <div class="col-sm-12 col-lg-5">
                            @if ($partner->image)
                            <img src="{{ Storage::disk('public')->url($partner->image) }}" class="img-thumbnail" alt="">
                            @else
                            <img src="/img/farmer.png" class="img-thumbnail" alt="">

                            @endif
                        </div>
                        <div class="col-sm-12 col-lg-7">
                            <h2> {{ $partner->fullName }}</h2>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered">
                                    <tbody>

                                        <tr>
                                            <td>Teléfono:</td>
                                            <td>
                                                <h5>{{ $partner->phone }}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dirección:</td>
                                            <td>
                                                <h5>{{ $partner->address }}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Colonia:</td>
                                            <td>
                                                <h5>{{ $partner->suburb }}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ocupación:</td>
                                            <td>
                                                <h5>{{ $partner->job }}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fecha de nacimiento:</td>
                                            <td>
                                                <h5>{{ $partner->birthday->format('Y-m-d') }} ({{ $partner->age }} años)</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Curp:</td>
                                            <td>
                                                <h5>{{ $partner->curp }}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Clave INE:</td>
                                            <td>
                                                <h5>{{ $partner->key_ine }} </h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Correo electrónico:</td>
                                            <td>
                                                <h5>{{ $partner->email }} </h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fecha de registro:</td>
                                            <td>
                                                <h5>{{ $partner->created_at }} </h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ültima actualización:</td>
                                            <td>
                                                <h5>{{ $partner->updated_at }} </h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>ID en el sistema:</td>
                                            <td>
                                                {{ $partner->id }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div id="tableCustomBasic" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Documentos</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="row">
                        @forelse ($partner->documents as $document)
                        <div class="col-md-4">
                            @php
                            $ext = pathinfo(Storage::disk('public')->url($document->url), PATHINFO_EXTENSION)
                            @endphp
                            <div class="card" style="width: 18rem;">
                                @if ($ext == 'jpg' || $ext == 'png' || $ext == 'bmp')
                                <img src="{{ Storage::disk('public')->url($document->url) }}" class="card-img-top" alt="...">
                                @elseif($ext == 'pdf')
                                <img src="/img/pdf.png" class="card-img-top" alt="...">
                                @else
                                <img src="/img/no_preview.png" class="card-img-top" alt="...">
                                @endif
                                <div class="card-body">
                                    <p class="card-text">{{ $document->type }}</p>
                                    <a class="btn btn-warning" href="{{ route('documents.download', $document) }}">Descargar</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <h5>No hay documentos agregados</h5>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- CONTENT AREA -->
</div>