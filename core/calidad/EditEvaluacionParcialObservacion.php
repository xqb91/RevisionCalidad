<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/EvaluacionParcialController.php");
	session_start();
	$control = new EvaluacionParcialController();

	if(!isset($_POST["evaluacion"])) {
		http_response_code(500);
	}else{
		$numero = filter_input(INPUT_POST, ("evaluacion"));
		$obj = $control->listarPorNumero($numero);
		if($obj == null) {
			http_response_code(501);
		}else{
			$obj = $obj[0];
			echo html_entity_decode($obj->getObservacion(), ENT_QUOTES, 'UTF-8');
		}	
	}

	//echo htmlspecialchars('<p>Hola este es un texto de prueba</p><ol><li>uno</li><li>dos</li><li>tres</li><li>cuatro</li></ol><p><strong>texto </strong><em>super </em><u>hiper </u><strong><em><u>duper </u></em></strong><a href="http://google.com/" target="_blank">formateado</a></p>', ENT_QUOTES, "UTF-8");

?>