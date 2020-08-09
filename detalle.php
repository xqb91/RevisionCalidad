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

  <title>Detalle de Evaluacion</title>

  <!-- Custom fonts for this template-->
  <link href="facade/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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
                  <h6 class="m-0 font-weight-bold text-primary" id="lblTitleTablaDetalle">PDF</h6>
                </div>
                <div class="card-body">
                  <div class="chart-bar">
                    <div id="pdfViewer"></div>
                  </div>
                  <hr>
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
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <form action="core/forceDownload.php" method="POST" id="formDownloadFile"> 
    <input type="hidden" name="evaluacion" id="nroEvaluacion" value="">
  </form>
  <!-- Bootstrap core JavaScript-->
  <script src="facade/vendor/jquery/jquery.min.js"></script>
  <script src="facade/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="facade/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="facade/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="facade/vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="framework/plyr/dist/plyr.js"></script>
  <link rel="stylesheet" href="framework/plyr/dist/plyr.css" />
  <script src="transaction/revisionTransaction.js"></script>
</body>

</html>
<?php 
    }
  }
?>