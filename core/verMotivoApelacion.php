<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/RevEvaluacionStatusController.php");
	session_start();
	$control = new RevEvaluacionStatusController();

	if(!isset($_POST["evaluacion"])) {
		http_response_code(500);
	}else{
		$numero = filter_input(INPUT_POST, ("evaluacion"));
		$obj = $control->listarPorEvaluacionEstado($numero, 6);
		if($obj == null) {
			http_response_code(501);
		}else{
			$obj = $obj[count($obj)-1];
			echo html_entity_decode($obj->getobservacion(), ENT_QUOTES, 'UTF-8');
		}	
	}

?>