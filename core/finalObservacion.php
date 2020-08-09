<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/EvaluacionFinalController.php");
	session_start();
	$control = new EvaluacionFinalController();

	if(!isset($_POST["evaluacion"])) {
		http_response_code(500);
	}else{
		$numero = filter_input(INPUT_POST, ("evaluacion"));
		$obj = $control->listarPorNumero($numero);
		if($obj == null) {
			http_response_code(501);
		}else{
			$obj = $obj[0];
			echo html_entity_decode($obj->getobservaciones(), ENT_QUOTES, 'UTF-8');
		}	
	}

?>