@section('title', 'Guardar usuario')

@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />

<link href="/src/plugins/css/light/loaders/custom-loader.css" rel="stylesheet" type="text/css" />
<link href="/src/plugins/css/dark/loaders/custom-loader.css" rel="stylesheet" type="text/css" />

@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
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
                            <h4>Guardar usuario</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <!-- Begin form -->
                    <form class="row g-3 user-save" wire:submit.prevent="save" novalidate>
                        <div class="col-md-6">
                            <label for="user.name" class="form-label">Nombre</label>
                            <input type="text" wire:model="user.name" class="form-control @error('user.name') is-invalid @enderror" id="user.name" required>
                            @error('user.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>
                        <div class="col-md-6">
                            <label for="user.surname" class="form-label">Apellidos</label>
                            <input type="text" wire:model="user.surname" class="form-control @error('user.surname') is-invalid @enderror" id="user.surname">
                            @error('user.surname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="user.email" class="form-label">Correo electrónico</label>
                            <input type="email" wire:model="user.email" class="form-control @error('user.email') is-invalid @enderror" id="user.email">
                            @error('user.email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password">Password</label>
                            <input id="password" wire:model="password" type="password" class="form-control @error('user.password') is-invalid @enderror">
                            @error('user.password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="user.job" class="form-label">Puesto en la empresa</label>
                            <input type="text" wire:model="user.job" class="form-control @error('user.job') is-invalid @enderror" id="user.job">
                            @error('user.job')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            @if ($image)
                            <a wire:click="$set('image', null)" class="btn btn-warning">Quitar</a>
                            <img src="{{ $image->temporaryUrl() }}" height="150px" alt="...">
                            @elseif ($user->image)
                            <a class="btn btn-danger" wire:click="deleteImg">Quitar</a>
                            <img src="{{ Storage::disk('public')->url($user->image) }}" height="150px" alt="...">
                            @endif

                            <label for="image" class="form-label">Foto</label>
                            <input type="file" wire:model="image" class="form-control-file @error('image') is-invalid @enderror" id="image" accept="image/png,image/jpeg">
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