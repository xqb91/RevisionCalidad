<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."CustomController.php");
	//session_start();
	
	$e  = new CustomController();

	if(isset($_POST["evaluacion"])) {
		if(isset($_POST["tipo"])) {

		$evaluacion = filter_input(INPUT_POST, ("evaluacion"));
		$tipo  		= filter_input(INPUT_POST, ("tipo"));

		$historial = $e->historialEvaluacion($evaluacion, $tipo);
		if($historial == null) {
			http_response_code(301);
		}else{
			echo "[";
			for($i=0; $i<count($historial); $i++){
				$temp = $historial[$i];
				//echo $temp->serializar();
				echo '{';
				echo '"tipo" : '.$temp['tipo_evaluacion'].', ';
				echo '"numero_evaluacion" : '.$temp['evaluacion'].', ';
				echo '"fecha" : "'.$temp['fecha'].'", ';
				echo '"status" : "'.$temp['status'].'", ';
				echo '"autorizador" : "'.$temp['nombre_autorizador'].'", ';
				echo '"detalle" : '.json_encode($temp['detalle']).' ';
				echo '}';

				if($i<count($historial)-1) {echo ",";}
			}
			echo "]";
			http_response_code(200);
		}

		}else{
			http_response_code(500);
		}
	}else{
		http_response_code(501);
	}
?>