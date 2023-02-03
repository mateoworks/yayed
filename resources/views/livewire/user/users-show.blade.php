@section('title', 'Usuario: ' . $user->name)

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
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
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
                            <h4>Datos de {{ $user->name }}</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="card style-3">
                        @if ($user->image)
                        <img src="{{ Storage::disk('public')->url($user->image) }}" class="card-img-top" alt="{{ $user->name }}">
                        @else

                        @endif

                        <div class="card-body px-0 py-0 align-self-center">
                            <p class="card-category mb-1">
                                <i class="fa-regular fa-briefcase"></i> {{ $user->job }}
                            </p>
                            <h5 class="card-title mb-3">
                                <i class="fa-regular fa-user"></i> {{ $user->name }} {{ $user->surname }}
                            </h5>
                            <div class="media mt-4 mb-0 pt-1">

                                <h5><i class="fa-regular fa-envelope"></i> {{ $user->email }}</h5>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT AREA -->
</div>