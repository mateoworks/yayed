<ul class="list-unstyled menu-categories" id="accordionExample">

    <li class="menu {{ (request()->is('home')) ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <i class="d-inline fa-regular fa-gauge"></i>
                <span class="d-inline">Dashboard</span>
            </div>
        </a>
    </li>

    <li class="menu {{ (request()->is('users*')) ? 'active' : '' }}">
        <a href="{{ route('users.index') }}" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <i class="d-inline fa-regular fa-user"></i>
                <span class="d-inline">Usuarios</span>
            </div>
        </a>
    </li>

    <li class="menu {{ (request()->is('partners*')) ? 'active' : '' }}">
        <a href="{{ route('partners.index') }}" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <i class="d-inline fa-light fa-user-cowboy"></i>
                <span class="d-inline">Socios</span>
            </div>
        </a>
    </li>

    <li class="menu {{ (request()->is('solicitud*')) ? 'active' : '' }}">
        <a href="{{ route('solicitud.index') }}" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <i class="d-inline fa-light fa-file-export"></i>
                <span class="d-inline">Solicitudes</span>
            </div>
        </a>
    </li>

    <li class="menu {{ (request()->is('loans*')) ? 'active' : '' }}">
        <a href="{{ route('loans.index') }}" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <i class="d-inline fa-regular fa-hand-holding-dollar"></i>
                <span class="d-inline">Prestamos</span>
            </div>
        </a>
    </li>

    <li class="menu {{ (request()->is('payments*')) ? 'active' : '' }}">
        <a href="{{ route('payments.index') }}" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <i class="d-inline fa-light fa-envelope-open-dollar"></i>
                <span class="d-inline">Pagos</span>
            </div>
        </a>
    </li>

    <li class="menu {{ (request()->is('reporte*')) ? 'active' : '' }}">
        <a href="#menuLevel1" data-bs-toggle="collapse" aria-expanded="{{ (request()->is('reporte*')) ? 'true' : '' }}" class="dropdown-toggle">
            <div class="">
                <i class="d-inline fa-light fa-calendar-days"></i>
                <span class="d-inline">Reportes</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled {{ (request()->is('reporte*')) ? 'show' : '' }} menu" id="menuLevel1" data-bs-parent="#accordionExample">
            <li class="{{ (request()->is('reporte/mensual')) ? 'active' : '' }}">
                <a href="{{ route('report.simple') }}"> Mensuales</a>
            </li>
            <li class="{{ (request()->is('reporte/exportar')) ? 'active' : '' }}">
                <a href="{{ route('report.export') }}"> Exportar</a>
            </li>
        </ul>
    </li>

    <li class="menu {{ (request()->is('endorsements*')) ? 'active' : '' }}">
        <a href="{{ route('endorsements.index') }}" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <i class="d-inline fa-light fa-user-alien"></i>
                <span class="d-inline">Avales</span>
            </div>
        </a>
    </li>

    <li class="menu {{ (request()->is('movimientos*')) ? 'active' : '' }}">
        <a href="{{ route('movements.index') }}" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <i class="d-inline fa-light fa-arrows-retweet"></i>
                <span class="d-inline">Movimientos</span>
            </div>
        </a>
    </li>

    <li class="menu {{ (request()->is('utilidades*')) ? 'active' : '' }}">
        <a href="#utilidades" data-bs-toggle="collapse" aria-expanded="{{ (request()->is('utilidades*')) ? 'true' : '' }}" class="dropdown-toggle">
            <div class="">
                <i class="d-inline fa-light fa-wrench"></i>
                <span class="d-inline">Utilidades</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled {{ (request()->is('utilidades*')) ? 'show' : '' }} menu" id="utilidades" data-bs-parent="#accordionExample">
            <li class="{{ (request()->is('utilidades/jobs*')) ? 'active' : '' }}">
                <a href="{{ route('job.index') }}"> Ocupaciones</a>
            </li>
            <li class="{{ (request()->is('utilidades/config*')) ? 'active' : '' }}">
                <a href="{{ route('config') }}"> Configurar</a>
            </li>

        </ul>
    </li>

</ul>