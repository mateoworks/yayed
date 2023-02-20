<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Yayed</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        /*
 * Globals
 */


        /* Custom default button */
        .btn-secondary,
        .btn-secondary:hover,
        .btn-secondary:focus {
            color: #333;
            text-shadow: none;
            /* Prevent inheritance from `body` */
        }


        /*
 * Base structure
 */

        body {
            text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
            box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
        }

        .cover-container {
            max-width: 42em;
        }


        /*
 * Header
 */

        .nav-masthead .nav-link {
            color: rgba(255, 255, 255, .5);
            border-bottom: .25rem solid transparent;
        }

        .nav-masthead .nav-link:hover,
        .nav-masthead .nav-link:focus {
            border-bottom-color: rgba(255, 255, 255, .25);
        }

        .nav-masthead .nav-link+.nav-link {
            margin-left: 1rem;
        }

        .nav-masthead .active {
            color: #fff;
            border-bottom-color: #fff;
        }
    </style>
</head>

<body class="d-flex h-100 text-center text-bg-dark">


    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
            <div>
                <h3 class="float-md-start mb-0">Ya' yed</h3>
                @if (Route::has('login'))
                <nav class="nav nav-masthead justify-content-center float-md-end">
                    @auth
                    <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="{{ url('/home') }}">Dashboard</a>
                    @else
                    <a class="nav-link fw-bold py-1 px-0" href="{{ route('login') }}">Login</a>
                    @endauth
                </nav>
                @endif
            </div>
        </header>

        <main class="px-3">
            <img src="/img/logo.png" alt="" class="bd-placeholder-img" height="250px">
            <h1>Ya'yed</h1>
            <p class="lead">Préstamos rápidos</p>
            @if (Route::has('login'))
            <p class="lead">
                @auth
                <a href="{{ url('/home') }}" class="btn btn-lg btn-secondary fw-bold border-white bg-white">Administrar</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-lg btn-secondary fw-bold border-white bg-white">Iniciar sesión</a>
                @endauth
            </p>
            @endif
        </main>

        <footer class="mt-auto text-white-50">

        </footer>
    </div>

</body>

</html>