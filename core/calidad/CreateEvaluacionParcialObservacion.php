<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/EvaluacionParcialController.php");
	$control = new EvaluacionParcialController();

	if(isset($_POST["evaluacion"])) {
		if(isset($_POST["comentarios"])) {
			$comentarios = htmlspecialchars(filter_input(INPUT_POST, ("comentarios")), ENT_QUOTES, "UTF-8");
			$evaluacion  = filter_input(INPUT_POST, ("evaluacion"));

			$obj = $control->listarPorNumero($evaluacion);
			if($obj == null) {
				http_response_code(503);
			}else{
				$obj = $obj[0];
				$obj->setobservacion($comentarios);

				//determinando si es una corrección
				if($obj->getEstado() == 2) {
					$obj->setEstado(4);
				}

				
				if($control->actualizar($obj)) {
					http_response_code(200);
				}else{
					http_response_code(301);
				}
			}
		}else{
			http_response_code(501);
		}
	}else{
		http_response_code(500);
	}
?>