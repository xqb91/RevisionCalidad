<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EvaluadorController.php");
	session_start();
	
	$e  = new EvaluadorController();

	$evaluadores = $e->listar();
	if($evaluadores == null) {
		http_response_code(301);
	}else{
		echo "[";
		for($i=0; $i<count($evaluadores); $i++){
			$temp = $evaluadores[$i];
			//echo $temp->serializar();
			echo '{';
			echo '"rut" : "'.$temp->getrut_evaluador().'", ';
			echo '"nombre" : "'.$temp->getnombre_evaluador().'" ';
			echo '}';

			if($i<count($evaluadores)-1) {echo ",";}
		}
		echo "]";
		http_response_code(200);
	}
?>