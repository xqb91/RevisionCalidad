<?php
  include("config/Globales.php");
  //error_reporting(0);
  session_start();
  $_SESSION['rauliUser'] = 'avatar';
  //---- NO OLVIDAR SETEAR ESTA VARIABLE DE SESION CUANDO INICIE EN EL SISTEMA VIEJO!!!!!!!!!
  $_SESSION['lastActivity'] = date('Y-m-d H:i:s');

  if(isset($_SESSION['current_area_work'])) {
    header('Location: home.php');
    exit;
  }

  if(isset($_SESSION['current_periodo_work'])) {
    header('Location: home.php');
    exit;
  }
?>
<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistema de Calidad :: Módulo de Revisión de Evaluaciones</title>

  <!-- Custom fonts for this template-->
  <link href="facade/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="facade/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4" id="lblSaludoUser">Cargando...</h1>
                    <p id="mensajeUsuario"><img src="facade/img/loading2.gif"><br />Espera un momento mientras te autenticamos...</p>
                    <form class="user" id="formInit">
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                      <label for="slcPeriodo"><strong>Periodo</strong></label>
                      <select class="form-control" id="slcPeriodo" name="slcPeriodo">
                      </select>
                    </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                      <label for="slcArea"><strong>Área</strong></label>
                      <select class="form-control" id="slcArea" name="slcArea">
                      </select>
                    </div>
                    </div>
                  </div>
                    <button type="button" class="btn btn-primary btn-lg btn-block" id="btnComenzar">Comenzar <i class="fas fa-arrow-right"></i></button>
                  </form>
                  </div>
                  <hr>
                  <p>&copy; 2020 Tricot Managemet Information Systems</p>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>


  <!-- Modal -->
<div class="modal fade" id="modalIndex" tabindex="-1" role="dialog" aria-labelledby="modalIndexTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalIndexTitle">Titulo</h5>
        <button type="button" id="modalIndexCerrarVentana" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalIndexContenido">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" id="modalIndexBtnCerrar" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="modalIndexBtnAccion">Save changes</button>
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
  <script src="transaction/funciones.js"></script>
  <script src="transaction/indexTransaction.js"></script>

</body>

</html>
