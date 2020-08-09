<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EvaluacionParcialController.php");

	if(isset($_POST["periodo"])) {
		if(isset($_POST["ejecutivo"])) {
			$periodo = filter_input(INPUT_POST, ("periodo"));
			$ejecutivo = filter_input(INPUT_POST, ("ejecutivo"));

			$control = new EvaluacionParcialController();
			if($control->haCompletadoEvaluacionesPorPeriodo($ejecutivo, $periodo)) {
				http_response_code(200);
			}else{
				http_response_code(301);
			}
		}
	}

?>