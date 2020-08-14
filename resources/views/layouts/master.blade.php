<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Consultorio</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <link rel="stylesheet" href="{{asset('css/estilos.css')}}">

    <script src="https://kit.fontawesome.com/4e3c5501e7.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">



    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper" id="app">

      <nav class="main-header navbar navbar-expand navbar-dark navbar-light" style="background: #001f3f;">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto" style="height: 50px;">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <button class="btn btn-danger"> <i class="nav-icon fas fa-power-off"></i> Cerrar sesión </button>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4 nav-collapse-hide-child" style="background: #001f3f;">
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">

                <div class="image">
                  <img src="{{asset('img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
                </div>

                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p> Dashboard </p>
                        </router-link>
                    </li>

                    @if( Auth::user()->type == '1')
                    <li class="nav-item">
                        <router-link to="/user" class="nav-link ">
                        <i class="nav-icon fas fa-users"></i>
                            <p>Usuarios</p>
                        </router-link>
                    </li>
                    @endif

                    @if( Auth::user()->type == '2' || Auth::user()->type == '1')
                    <li class="nav-item">
                        <router-link to="/pacientes" class="nav-link ">
                          <i class="nav-icon fas fa-procedures"></i>
                            <p>Pacientes</p>
                        </router-link>
                    </li>
                    @endif

                    @if( Auth::user()->type == '2' || Auth::user()->type == '1')
                    <li class="nav-item">
                        <router-link to="/enfermedades" class="nav-link ">
                          <i class="fas fa-viruses nav-icon"></i>
                            <p>Enfermedades</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/medicinas" class="nav-link ">
                          <i class="fas fa-tablets nav-icon"></i>
                            <p>Medicinas</p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/alergias" class="nav-link ">
                          <i class="fas fa-allergies nav-icon"></i>
                            <p>Alergias</p>
                        </router-link>
                    </li>
                    @endif

                    @if( Auth::user()->type == '4' || Auth::user()->type == '1' || Auth::user()->type == '2' )
                    <li class="nav-item">
                        <router-link to="/citas" class="nav-link ">
                            <i class="nav-icon fas fa-clock"></i>
                            <p>Agendar cita</p>
                        </router-link>
                    </li>
                    @endif

                    @if( Auth::user()->type == '2' || Auth::user()->type == '1')
                    <li class="nav-item">
                        <router-link to="/listacitas" class="nav-link ">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Lista de citas</p>
                        </router-link>
                    </li>
                    @endif

                    @if( Auth::user()->type == '3' || Auth::user()->type == '1')
                    <li class="nav-item">
                        <router-link to="/expedientes" class="nav-link ">
                          <i class="fas fa-file-medical-alt nav-icon"></i>
                            <p>Expedientes</p>
                        </router-link>
                    </li>
                    @endif

                    @if( Auth::user()->type == '4' || Auth::user()->type == '1')
                    <li class="nav-item">
                        <router-link to="/pagos" class="nav-link ">
                          <i class="far fa-money-bill-alt nav-icon"></i>
                            <p>Pagos</p>
                        </router-link>
                    </li>
                    @endif

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>


    <!-- Seccion donde se renderiza el contenido del compoenente de vue js-->
    <router-view :tipo="'{{Auth::user()->type}}'" :id="'{{Auth::user()->id}}'" ></router-view>
    <vue-progress-bar></vue-progress-bar>


</div>
  <script src="{{asset('js/app.js')}}"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>



</body>
</html>
