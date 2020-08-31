<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."CustomController.php");
	//session_start();
	
	$e  = new CustomController();

	if(isset($_POST["evaluador"])) {
		if(isset($_POST["area"])) {
			if(isset($_POST["periodo"])) {

				$evaluador 	= filter_input(INPUT_POST, ("evaluador"));
				$area 		= filter_input(INPUT_POST, ("area"));
				$periodo 	= filter_input(INPUT_POST, ("periodo"));

				$ejecutivos = $e->ejecutivosEvaluadosPorEvaluadorEn($evaluador, $area, $periodo);
				if($ejecutivos == null) {
					http_response_code(301);
				}else{
					echo "[";
					for($i=0; $i<count($ejecutivos); $i++){
						$temp = $ejecutivos[$i];
						//echo $temp->serializar();
						echo '{';
						echo '"rut" : "'.$temp['rut_ejecutivo'].'", ';
						echo '"nombre" : "'.$temp['nombre_ejecutivo'].'" ';
						echo '}';

						if($i<count($ejecutivos)-1) {echo ",";}
					}
					echo "]";
					http_response_code(200);
				}
			}else{
				http_response_code(201);
			}
		}else{
			http_response_code(202);
		}
	}else{
		if(isset($_POST["area"])) {
			if(isset($_POST["periodo"])) {

				$area 		= filter_input(INPUT_POST, ("area"));
				$periodo 	= filter_input(INPUT_POST, ("periodo"));

				$ejecutivos = $e->ejecutivosPorArea($area, $periodo);
				if($ejecutivos == null) {
					http_response_code(301);
				}else{
					echo "[";
					for($i=0; $i<count($ejecutivos); $i++){
						$temp = $ejecutivos[$i];
						//echo $temp->serializar();
						echo '{';
						echo '"rut" : "'.$temp['rut_ejecutivo'].'", ';
						echo '"nombre" : "'.$temp['nombre_ejecutivo'].'" ';
						echo '}';

						if($i<count($ejecutivos)-1) {echo ",";}
					}
					echo "]";
					http_response_code(200);
				}
			}else{
				http_response_code(201);
			}
		}else{
			http_response_code(202);
		}
	}
?>