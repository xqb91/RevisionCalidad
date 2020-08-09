<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EjecutivoController.php");
	include(dirController."EvaluacionParcialController.php");
	session_start();
	
	$c 	= new EjecutivoController();
	$e  = new EvaluacionParcialController();

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
						echo '"promedio_ejecutivo" : 0.00,';
						echo '"cantidad_evaluaciones" : 0, ';
						echo '"bloqueado" : 0 ';
					}else{
						$suma = 0;
						$total = 0;
						foreach ($obj as $k) {
							$suma = $suma+$k->getnota_final();
							$total++;
						}
						$promedio = $suma/$total;
						$promedio = number_format($promedio, 2, '.', '');
						echo '"promedio_ejecutivo" : '.$promedio.',';
						echo '"cantidad_evaluaciones" : '.$total.', ';
						if($c->bloqueado($temp->getrut_ejecutivo(), $_SESSION['current_periodo_work'])) {
							echo '"bloqueado" : 1 ';
						}else{
							echo '"bloqueado" : 0 ';
						}
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