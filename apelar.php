<?php
  if(!isset($_GET['evaluacion'])) {
    http_response_code(403);
  }else{
    if(!isset($_GET['tipo'])) {
      http_response_code(404);
    }else{
      $evaluacion = filter_input(INPUT_GET, ("evaluacion"));
      $tipo       = filter_input(INPUT_GET, ("tipo"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <input type="hidden" id="irqljob" value="<?php echo $evaluacion; ?>">
  <input type="hidden" id="irqltype" value="<?php echo $tipo; ?>">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Opciones</title>

  <!-- Custom fonts for this template-->
  <link href="facade/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

 <!-- Quill Framework -->
  <link href="framework/quill/quill.snow.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="facade/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row">

            <div class="col-xl-12 col-lg-12">
              <!-- Bar Chart -->
              <div class="card shadow mb-4">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary" id="lblTitleTablaDetalle">Opciones de Evaluación #<?php echo $evaluacion; ?></h6>
                </div>
                  <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <form class="form-inline my-2 my-sm-0">
                          <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Estado</label>
                          <input type="text" class="form-control form-control-sm" id="txtEstadoEvaluacion" readonly="readonly">
                      </form>
                    </div>
                  </nav>
              
                    <div class="row">
                      
                      <div class="col-lg-4">
                          <div class="card mb-4">
                            <div class="card-header" id="lblTitleEditor"><strong>Notas para revisión</strong>
                            </div>
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="entrarAProceso" value="1">
                              <label class="custom-control-label" for="entrarAProceso" id="entrarAProcesoLabel">Debe ser revisada</label>
                            </div>
                            <div id="lblTextArea" class="card-body" style="height: 300px; width: 100%;"></div>
                            <button type="button" class="btn btn-primary" id="btnEjecutarProceso">Enviar a Revisión</button>
                          </div>
                        </div>
                      
                      <div class="col-lg-8">
                        <div class="row">
                            <div class="container">
                           

                              <div class="col-lg-12">
                                <div class="card mb-4">
                                  <div class="card-header">
                                    <strong>Recursos asociados a la evaluación</strong>
                                  </div>
                                  
                                    <div class="accordion card-body" id="accordionExample">
                                        <div class="card">
                                          <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                              <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Observación de la interacción Telefónica
                                              </button>
                                            </h2>
                                          </div>

                                          <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body" id="lblObservacionEvaluacion" style="text-align: justify;">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="card">
                                          <div class="card-header" id="headingTwo">
                                            <h2 class="mb-0">
                                              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Audio y Adjuntos
                                              </button>
                                            </h2>
                                          </div>
                                          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                            <div class="card-body">
                                              <div class="col-xl-12 col-lg-12">
                                                <!-- Bar Chart -->
                                                <div class="card shadow mb-4">
                                                  <div class="card-header">
                                                    <h6 class="m-0 font-weight-bold text-primary">Audio</h6>
                                                  </div>
                                                  <div class="card-body">
                                                    <div class="media">
                                                     <button type="button" class="btn btn-primary mr-3" title="Descarga Audio Evaluado" id="btnAudioDownload"><i class="fas fa-file-download"></i><br /></button>

                                                      <div class="media-body">
                                                        <h5 class="mt-0" id="lblAudioNombre">Nombre del Audio</h5>
                                                        <p id="lblAudioPeso">Peso de Audio.</p>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-xl-12 col-lg-12">
                                                <!-- Bar Chart -->
                                                <div class="card shadow mb-4">
                                                  <div class="card-header">
                                                    <h6 class="m-0 font-weight-bold text-primary">Adjuntos</h6>
                                                  </div>
                                                  <div class="card-body">
                                                    <table class="table table-sm" id="tablaAdjuntos">
                                                      <thead>
                                                        <tr>
                                                          <th scope="col">Adjunto</th>
                                                          <th scope="col">Acción</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>
                                                      </tbody>
                                                    </table>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="card">
                                          <div class="card-header" id="headingThree">
                                            <h2 class="mb-0">
                                              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Historial
                                              </button>
                                            </h2>
                                          </div>
                                          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                            <div class="card-body">
                                              <table class="table table-sm table-hover" id="tablaHistorial">
                                                <thead>
                                                  <tr>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Estado</th>
                                                    <th scope="col">Mandante</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="card">
                                          <div class="card-header" id="headingFour">
                                            <h2 class="mb-0">
                                              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                PDF de la Evaluación
                                              </button>
                                            </h2>
                                          </div>
                                          <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                            <div class="card-body">
                                              <ul class="nav"><button type="button" class="btn btn-outline-primary btn-sm" id="btnPDFDownloader"><i class="fas fa-file-pdf"></i> Descargar documento PDF</button></ul>
                                              <p id="pdfViewer"></p>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="card">
                                          <div class="card-header" id="headingFive">
                                            <h2 class="mb-0">
                                              <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                Motivo de la apelación
                                              </button>
                                            </h2>
                                          </div>
                                          <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                            <div class="card-body" id="lblMotivoApelacion">
                                              <strong>Motivo de la apelación no pudo ser encontrado</strong>
                                            </div>
                                          </div>
                                        </div>

                                      </div>
                                 
                                </div>
                              </div>
                            
                            </div>
                        </div>
                      </div>

                    </div>
              </div>

            </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
</div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <form action="core/forceDownload.php" method="POST" id="formDownloadFile"> 
    <input type="hidden" name="evaluacion" id="nroEvaluacion" value="">
  </form>

  <form action="core/forceDownloadAdjunto.php" method="POST" id="formDownloadAdjunto"> 
    <input type="hidden" name="url" id="urlAdjunto" value="">
    <input type="hidden" name="original" id="originalAdjunto" value="">
  </form>
  <!-- Bootstrap core JavaScript-->
  <script src="facade/vendor/jquery/jquery.min.js"></script>
  <script src="facade/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="facade/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="facade/js/sb-admin-2.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="framework/quill/quill.js"></script>
  <script src="transaction/apelaciones.js"></script>

</body>

</html>
<?php 
    }
  }
?>