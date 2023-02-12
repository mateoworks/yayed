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
        <a href="{{ route('report.simple') }}" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <i class="d-inline fa-light fa-calendar-days"></i>
                <span class="d-inline">Reportes</span>
            </div>
        </a>
    </li>

    <li class="menu {{ (request()->is('endorsements*')) ? 'active' : '' }}">
        <a href="{{ route('endorsements.index') }}" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <i class="d-inline fa-light fa-user-alien"></i>
                <span class="d-inline">Avales</span>
            </div>
        </a>
    </li>

</ul>