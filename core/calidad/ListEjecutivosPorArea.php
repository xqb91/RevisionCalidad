<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EjecutivoController.php");
	session_start();

	$c 	= new EjecutivoController();
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
					if($c->bloqueado($temp->getrut_ejecutivo(), $_SESSION['current_periodo_work'])) { $bloqueo = 1; }else{ $bloqueo = 0; }
					echo '{ "rut_ejecutivo" : '.$temp->getrut_ejecutivo().', "nombre_ejecutivo":"'.$temp->getnombre_ejecutivo().'","fecha_inicio":"'.$temp->getfecha_inicio().'","codigo_estado": '.$temp->getcodigo_estado().',"correo": "'.$temp->getcorreo().'","codigo_ciclo": '.$temp->getcodigo_ciclo().',"codigo_area": '.$temp->getcodigo_area().',"codigo_jornada": '.$temp->getcodigo_jornada().', "bloqueado" : '.$bloqueo.' } ';
					//echo $temp->serializar();
					if($i<count($evaluadores)-1) {echo ",";}
				}
				echo "]";
				http_response_code(200);
				//var_dump($evaluadores);
			}
		}
	}

?>