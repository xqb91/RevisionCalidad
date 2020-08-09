<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EjecutivoController.php");
	include(dirController."EvaluacionFinalController.php");
	session_start();
	
	$c 	= new EjecutivoController();
	$e  = new EvaluacionFinalController();

	if(empty(filter_input(INPUT_POST, ("area")))) {
		http_response_code(500);
	}else{
		$area = filter_input(INPUT_POST, ("area")); 
		$area = preg_replace('/^[a-zA-Z\s]*$/', '', $area);
		if($area == '') {
			http_response_code(401);
		}else{
			$evaluadores = $c->listarPorArea($area);
			if($evaluadores == null) {
				http_response_code(301);
			}else{
				echo "[";
				for($i=0; $i<count($evaluadores); $i++){
					$temp = $evaluadores[$i];
					//echo $temp->serializar();
					echo '{';
					echo '"rut_ejecutivo" : "'.$temp->getrut_ejecutivo().'", ';
					echo '"nombre_ejecutivo" : "'.$temp->getnombre_ejecutivo().'", ';
					echo '"codigo_area" : '.$temp->getcodigo_area().', ';

					
					//obteniendo promedio
					$obj = $e->listarPorEjecutivo($temp->getrut_ejecutivo(), $_SESSION['current_periodo_work']);
					if ($obj == null) {
						echo '"nota_final" : null, "evaluacion" : null';
					}else{
						echo '"nota_final" : '.number_format($obj[0]->getnotafinal(), 2).', "evaluacion" : '.$obj[0]->getnumero_final().'';
					}
					echo '}';

					if($i<count($evaluadores)-1) {echo ",";}
				}
				echo "]";
				http_response_code(200);
			}
		}
	}
?>