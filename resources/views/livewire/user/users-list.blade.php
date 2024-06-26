@section('title', 'Usuarios')
@push('styles')
<link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/src/plugins/src/sweetalerts2/sweetalerts2.css">
@endpush
<div class="middle-content container-xxl p-0">

    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
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
                        <div class="col">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Lista de usuarios</h4>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <a class="btn btn-success mt-2 me-4" href="{{ route('users.create') }}">
                                <i class="fa-regular fa-user-plus"></i>
                                <span class="btn-text-inner">Agregar usuarios</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Cargo</th>

                                    <th class="text-center" scope="col"></th>
                                </tr>
                                <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                            </thead>
                            <tbody>

                                @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="avatar">
                                                @if ($user->image)
                                                <img alt="avatar" src="{{ Storage::disk('public')->url($user->image) }}" class="rounded-circle" />
                                                @else
                                                <span class="avatar-title rounded-circle">{{ $user->name[0] ?? '' }}{{ $user->surname[0] }}</span>
                                                @endif
                                            </div>
                                            <div class="media-body align-self-center ms-3">
                                                <h6 class="mb-0">{{ $user->name }} {{ $user->surname }}</h6>
                                                <span>{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">{{ $user->job }}</p>
                                    </td>
                                    <td class="text-center">

                                        <div class="btn-group" role="group" aria-label="Basic example">

                                            <a href="{{ route('users.show', $user) }}" class="bs-tooltip btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ver">
                                                <i class="fa-light fa-eye"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user) }}" class="bs-tooltip btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="fa-light fa-pen-to-square"></i>
                                            </a>
                                            @if (auth()->user()->id == $user->id)
                                            <button wire:click="$emit('triggerDelete', '{{ $user->id }}')" class="bs-tooltip btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" disabled>
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                            @else
                                            <button wire:click="$emit('triggerDelete', '{{ $user->id }}')" class="bs-tooltip btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                            @endif

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
    </div>
    <!-- CONTENT AREA -->
</div>
@push('scripts')
<script src="/src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {

        @this.on('triggerDelete', id => {
            Swal.fire({
                title: '¿Estas seguro de eliminar este usuario?',
                html: "Se intetará eliminar, si tiene algún dato relacionado como pagos, no se eliminará.",
                icon: 'warning',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    @this.call('destroy', id)
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
            backgroundColor: '#' + event.detail.backgroundColor,

        });
    });
</script>



@if(session()->has('message'))
<script>
    Snackbar.show({
        showAction: false,
        text: "{{ session('message') }}",
        pos: 'top-center',
        actionTextColor: '#fff',
        backgroundColor: '#00ab55',

    });
</script>
@endif

@endpush