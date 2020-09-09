<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."CustomController.php");
	//session_start();
	
	$e  = new CustomController();

	if(isset($_POST["evaluador"])) {
		if(isset($_POST["area"])) {
			if(isset($_POST["periodo"])) {
				if(isset($_POST["ejecutivo"])) {
					if(isset($_POST["estado"])) {
						$evaluador 	= filter_input(INPUT_POST, ("evaluador"));
						$area 		= filter_input(INPUT_POST, ("area"));
						$periodo 	= filter_input(INPUT_POST, ("periodo"));
						$ejecutivo  = filter_input(INPUT_POST, ("ejecutivo"));
						$estado     = filter_input(INPUT_POST, ("estado"));

						$ejecutivos = $e->filtrarEvaluaciones($periodo, $area, $evaluador, $ejecutivo, $estado);
						if($ejecutivos == null) {
							http_response_code(301);
						}else{
							echo "[";
							for($i=0; $i<count($ejecutivos); $i++){
								$temp = $ejecutivos[$i];
								echo '{';
								echo '"tipo" : '.$temp['tipo'].', ';
								echo '"evaluacion" : '.$temp['evaluacion'].', ';
								echo '"fecha_creacion" : "'.$temp['fecha_creacion'].'", ';
								echo '"periodo" : "'.$temp['periodo'].'", ';
								echo '"rut_ejecutivo" : '.$temp['rut_ejecutivo'].', ';
								echo '"nombre_ejecutivo" : "'.$temp['nombre_ejecutivo'].'", ';
								echo '"rut_evaluador" : '.$temp['rut_evaluador'].', ';
								echo '"nombre_evaluador" : "'.$temp['nombre_evaluador'].'", ';
								echo '"nota" : '.$temp['nota'].', ';
								echo '"codigo_area" : '.$temp['codigo_area'].', ';
								echo '"orden" : '.$temp['orden'].', ';
								echo '"estado" : '.$temp['estado'].' ';
								echo '}';

								if($i<count($ejecutivos)-1) {echo ",";}
							}
							echo "]";
							http_response_code(200);
						}
					}else{
						http_response_code(204);
					}
				}else{
					http_response_code(205);
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
				if(isset($_POST["ejecutivo"])) {
					if(isset($_POST["estado"])) {
						$area 		= filter_input(INPUT_POST, ("area"));
						$periodo 	= filter_input(INPUT_POST, ("periodo"));
						$ejecutivo  = filter_input(INPUT_POST, ("ejecutivo"));
						$estado     = filter_input(INPUT_POST, ("estado"));
						$ejecutivos = $e->filtrarEvaluacionesSupervisor($periodo, $area, $ejecutivo, $estado);
						if($ejecutivos == null) {
							http_response_code(301);
						}else{
							echo "[";
							for($i=0; $i<count($ejecutivos); $i++){
								$temp = $ejecutivos[$i];
								echo '{';
								echo '"tipo" : "'.$temp['tipo'].'", ';
								echo '"evaluacion" : '.$temp['numero_evaluacion'].', ';
								echo '"entrega" : "'.$temp['entrega'].'", ';
								echo '"fecha_creacion" : "'.$temp['fecha_evaluacion'].'", ';
								echo '"periodo" : "'.$temp['periodo'].'", ';
								echo '"rut_ejecutivo" : '.$temp['rut_ejecutivo'].', ';
								echo '"nombre_ejecutivo" : "'.$temp['nombre_ejecutivo'].'", ';
								echo '"rut_evaluador" : '.$temp['rut_evaluador'].', ';
								echo '"nombre_evaluador" : "'.$temp['nombre_evaluador'].'", ';
								echo '"nota" : '.$temp['nota_final'].', ';
								echo '"codigo_area" : '.$temp['codigo_area'].', ';
								echo '"orden" : '.$temp['orden'].', ';
								echo '"estado" : '.$temp['estado'].' ';
								echo '}';

								if($i<count($ejecutivos)-1) {echo ",";}
							}
							echo "]";
							http_response_code(200);
						}
					}else{
						http_response_code(204);
					}
				}else{
					http_response_code(205);
				}
			}else{
				http_response_code(201);
			}
		}else{
			http_response_code(202);
		}
	}
?>