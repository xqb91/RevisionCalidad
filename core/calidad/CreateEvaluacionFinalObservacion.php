<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	
	//including controllers
	include(dirController."EvaluacionFinalController.php");

	if(isset($_POST["evaluacion"])) {
		if(isset($_POST["comentario"])) {
			$evaluacion = filter_input(INPUT_POST, ("evaluacion"));
			$comentario = htmlspecialchars(filter_input(INPUT_POST, ("comentario")), ENT_QUOTES, "UTF-8");

			//instanciando controlador
			$control = new EvaluacionFinalController();
			$temp 	 = $control->listarPorNumero($evaluacion);

			if($evaluacion == null) {
				//error la evaluacion no exixste
			}else{
				//actualizar
				$temp = $temp[0];
				$temp->setobservaciones($comentario);
				if($control->actualizar($temp)) {
					//ok
					http_response_code(200);
				}else{
					//error
					http_response_code(204);
				}
			}
		}else{
			//error al no recibir parámetro de observacion
			http_response_code(301);
		}
	}else{
		//error al no recibir parametro evaluacion
		http_response_code(302);
	}
?>