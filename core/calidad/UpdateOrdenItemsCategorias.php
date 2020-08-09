<?php 
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."ItemEvaluacionController.php");

	$c 	= new ItemEvaluacionController();

	if(isset($_POST["orden"])) {
		if(isset($_POST["categoria"])) {
			$array = json_decode(filter_input(INPUT_POST, ("orden")));
			for($i=1; $i<count($array); $i++) {
				$obj = $c->listarPorCodigo($array[$i]);
				$obj[0]->setorden($i);
				$c->actualizar($obj[0]);
			}
			http_response_code(200);
		}else{
			http_response_code(501);
		}
	}else{
		http_response_code(500);
	}
?>