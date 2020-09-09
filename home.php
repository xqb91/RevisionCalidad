<?php 
  include("model/Evaluador.php");
  session_start();
  if(!isset($_SESSION['rauliUser'] )) {
    header('Location: logout.php');
    exit;
  }
  if(!isset($_SESSION['lastActivity'] )) {
    header('Location: logout.php');
    exit;
  }

  if(!isset($_SESSION['current_area_work'])) {
    header('Location: logout.php');
    exit;
  }

  if(!isset($_SESSION['current_periodo_work'])) {
    header('Location: logout.php');
    exit;
  }

  if(!isset($_SESSION['loginUser'])) {
      header('Location: logout.php');
      exit;
  }else{
    $evaluador = $_SESSION['loginUser'];
  }

  if(!isset($_SESSION['current_access'])) {
    header('Location: logout.php');
    exit;
  }else{
    if($_SESSION['current_access'] != 1) {
      header('Location: logout.php');
      exit;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistema de Calidad :: Módulo de Revisión</title>

  <!-- Custom fonts for this template-->
  <link href="facade/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="facade/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
         <img src="facade/img/tricard_logo.png" width="90%" />
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Global</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">          

              <div class="input-group mb-3">
                <div class="input-group-prepend"><label class="input-group-text" for="inputGroupSelect01">Área</label> </div>
                <select class="custom-select" id="slcArea"></select>
                <div class="input-group-prepend"><label class="input-group-text" for="inputGroupSelect01">Periodo</label> </div>
                <select class="custom-select" id="slcPeriodo"></select>
              </div>
            </div>
          </form>


          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                
                <span class="badge badge-secondary"><i class="fas fa-tired"></i> Apelaciones</span>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter" id="lblApelacionesCounter">0</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  <i class="fas fa-tired"></i> Centro de Apelaciones
                </h6>
                  <p id="lblCentroApelaciones"></p>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="lblEvaluadorLogin"></span>
                <img class="img-profile rounded-circle" src="facade/img/avatar.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="logout.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Salir
                </a>
                <a class="dropdown-item" href="../calidad/home.php">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Abrir módulo de evaluaciones
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><strong>Módulo de Revisión de Evaluaciones</strong></h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="btnForceUpdate"><i class="fas fa-sync-alt"></i> Actualizar</a>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">En Proceso</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800" id="lblTotalEnProceso"><img src="facade/img/loading2.gif"></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-hourglass-half"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">En Revisión</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800" id="lblTotalEnRevision"><img src="facade/img/loading2.gif"></div>
                    </div>
                    <div class="col-auto">
                      <i class="far fa-eye"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Corregidas</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800" id="lblTotalCorregidas"><img src="facade/img/loading2.gif"></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-check"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-2 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Apeladas</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800" id="lblTotalApeladas"><img src="facade/img/loading2.gif"></div>
                    </div>
                    <div class="col-auto">
                     <i class="fas fa-tired"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Cerradas</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="lblTotalCerradas"><img src="facade/img/loading2.gif"></div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" id="lblTotalEnProcesoBar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <!-- Content Row -->

          <div class="navbar navbar-expand-lg navbar-light bg-dark">
            <form class="form-inline">
              <div class="input-group mb-3 input-group-sm">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="slcEvaluador">Evaluador</label>
                </div>
                <select class="custom-select" id="slcEvaluador">
                  <option value="*">Todos</option>
                </select>
                <div class="input-group-prepend">
                  <label class="input-group-text" for="slcEjecutivo">Ejecutivo</label>
                </div>
                <select class="custom-select" id="slcEjecutivo">
                  <option></option>
                </select>
                <div class="input-group-prepend">
                  <label class="input-group-text" for="slcEstado">Estado</label>
                </div>
                <select class="custom-select" id="slcEstado">
                  <option value="*">Cualquiera</option>
                  <option value="1">Generada</option>
                  <option value="2">En Revisión</option>
                  <option value="4">Corregida</option>
                  <option value="5">Disponible</option>
                  <option value="6">Apelada</option>
                  <option value="7">Apelación Aceptada</option>
                  <option value="8">Apelación Terminada</option>
                  <option value="9">Conformidad</option>
                </select>
              </div>
            </form>
          </div>


          <div class="row">
            <!-- Pie Chart -->
            <div class="col-xl-12 col-lg-12">
              <div class="card shadow mb-12">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary" id="lblTitleTablaDetalle">Detalle de Evaluaciones</h6>
                </div>
                <!-- Card Body -->
                <table class="table table-hover table-sm" id="tablaEvaluaciones">
                  <thead>
                    <tr>

                      <th scope="col">Tipo</th>
                      <th scope="col">Evaluación</th>
                      <th scope="col">Nota</th>
                      <th scope="col">Periodo</th>
                      <th scope="col">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>&copy; 2020 Tricot Management Information System</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
<div class="modal fade bd-example-modal-sm" id="modalHome" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm modal-dialog-scrollable" role="document" id="modalHomeConfig">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHomeTitle">Modal title</h5>
        <button type="button" id="modalHomeCerrarVentana" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalHomeContenido">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" id="modalHomeBtnCerrar" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" id="modalHomeBtnAccion" class="btn btn-primary btn-sm">Save changes</button>
      </div>
    </div>
  </div>
</div>


  <!-- Bootstrap core JavaScript-->
  <script src="facade/vendor/jquery/jquery.min.js"></script>
  <script src="facade/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="facade/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="facade/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="facade/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="facade/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <script src="transaction/homeTransaction.js"></script>
  <script src="framework/play-sound/jquery.playSound.js"></script>

</body>

</html>
