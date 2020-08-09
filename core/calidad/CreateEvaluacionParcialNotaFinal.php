<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EvaluacionParcialController.php");

	$array = null;

	if(isset($_POST["evaluacion"])) {
		if(isset($_POST["nota"])) {
			$evaluacion		= filter_input(INPUT_POST, ("evaluacion"));
			$nota	 		= filter_input(INPUT_POST, ("nota"));

			$controlado = new EvaluacionParcialController();
			$obj 		= $controlado->listarPorNumero($evaluacion)[0];
			$obj->setnota_final($nota);
			if($controlado->actualizarNota($obj) == 1) {
				http_response_code(200);
			}else{
				http_response_code(401);
			}
		}else{
			http_response_code(503);
		}
	}else{
		http_response_code(502);
	}
?>