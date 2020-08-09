<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirModel."Evaluador.php");
	include(dirController."EvaluacionQuincenalController.php");
	include(dirController."EvaluacionFinalController.php");
	session_start();

	if(isset($_GET["ejecutivo"])) {
		
		$ejecutivo = filter_input(INPUT_GET, ("ejecutivo"));
		$periodo   = $_SESSION['current_periodo_work'];

		$ctrlQuincenal 	= new EvaluacionQuincenalController();
		$ctrlFinal 		= new EvaluacionFinalController();

		if($ctrlQuincenal->actualizaPorDesbloqueo($ejecutivo, $periodo) == 1) {
			if($ctrlFinal->actualizaPorDesbloqueo($ejecutivo, $periodo) == 1) {
				http_response_code(200);
			}else{
				http_response_code(202);
			}
		}else{
			http_response_code(203);
		}
	}else{
		http_response_code(201);
	}
?>