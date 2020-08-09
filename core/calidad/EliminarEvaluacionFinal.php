<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	
	//including models necesaries
	include(dirModel."Evaluador.php");

	//including controllers
	include(dirController."EvaluacionFinalController.php");
	include(dirController."DetalleEvaluacionFinalController.php");
	//recuperando session PHP

	if(isset($_POST["evaluacion"])) {
		//instanciar controladores
		$cabecera = new EvaluacionFinalController();
		$posicion = new DetalleEvaluacionFinalController();
		$evaluacion = filter_input(INPUT_POST, ("evaluacion"));

		$temp = $cabecera->listarPorNumero($evaluacion);
		if($temp != null) {
			//iniciando eliminación de posiciones
			$pos = $posicion->listarPorNumeroFinal($evaluacion);
			if($pos == null) {
				echo "La evaluación final ha perdido sus posiciones o ya fueron eliminadas. <br />";
			}else{
				$posicion->eliminarPorFinal($evaluacion);
				echo "Se han desbloqueado ".count($pos)." evaluaciones parciales: <br />";		
			}
			if($cabecera->eliminar($temp[0])) {
				echo "La evaluación final ".$evaluacion." ha sido eliminada de forma satisfactoria.";
				http_response_code(200);
			}else{
				http_response_code(201);
				echo "La evaluación final ".$evaluacion." no ha poodido ser eliminada.";
			}
		}else{
			//Evaluacion ya eliminada o no existe
			http_response_code(302);
		}
	}else{
		//falta parametro
		http_response_code(301);
	}
?>