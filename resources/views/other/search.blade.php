@extends('layouts.app3')

@section('content')

<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Buscar</li>
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
                            <h4>Resultados de búsqueda: {{ $term }}</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    @foreach ($partners as $partner)
                    <div class="card style-4 mb-3">
                        <div class="card-body pt-3">

                            <div class="m-o-dropdown-list">
                                <div class="media mt-0 mb-3">
                                    <div class="media-body">

                                        <h4 class="media-heading mb-0">

                                            <div class="media mt-0 mb-3">
                                                <div class="">
                                                    <div class="avatar avatar-md me-3">
                                                        @if ($partner->image)
                                                        <img alt="avatar" src="{{ Storage::disk('public')->url($partner->image) }}" class="rounded-circle avatar-img">
                                                        @else
                                                        <span class="avatar-title rounded-circle">{{ $partner->names[0] ?? '' }}{{ $partner->surname_father[0] }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <a href="{{ route('partners.show', $partner) }}">
                                                        <h4 class="media-heading mb-0"><strong class="display-6">{{ $partner->number }} </strong> {{ $partner->full_name }}</h4>
                                                    </a>
                                                    <p class="media-text">{{ $partner->phone }}</p>

                                                </div>
                                            </div>
                                            <div class="dropdown-list dropdown" role="group">
                                                <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="19" cy="12" r="1"></circle>
                                                        <circle cx="5" cy="12" r="1"></circle>
                                                    </svg>
                                                </a>
                                                <div class="dropdown-menu left" style="">
                                                    <a class="dropdown-item" href="{{ route('partners.show', $partner) }}"><span>Ver socio</span>
                                                        <i class="fa-regular fa-user-cowboy"></i>
                                                    </a>
                                                    @if ($partner->active)
                                                    <a class="dropdown-item" href="{{ route('payments.create', $partner->active) }}"><span>Registrar pago</span>
                                                        <i class="fa-regular fa-square-dollar feather"></i>
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('loans.show', $partner->active) }}"><span>Ver prestamo</span>
                                                        <i class="fa-regular fa-file-invoice-dollar feather"></i>
                                                    </a>
                                                    @else
                                                    <a class="dropdown-item" href="{{ route('partners.solicitud.create', $partner) }}"><span>Realizar solicitud</span>
                                                        <i class="fa-light fa-hand-holding-dollar"></i>
                                                    </a>
                                                    @endif


                                                </div>
                                            </div>

                                        </h4>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT AREA -->
</div>

@endsection

@push('styles')
<!--  BEGIN CUSTOM STYLE FILE  -->
<link href="/src/assets/css/light/components/media_object.css" rel="stylesheet" type="text/css">
<link href="/src/assets/css/dark/components/media_object.css" rel="stylesheet" type="text/css">
@endpush