<?php 
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."CategoriaController.php");

	$c 	= new CategoriaController();

	if(isset($_POST["orden"])) {
		if(isset($_POST["area"])) {
			$array = json_decode(filter_input(INPUT_POST, ("orden")));
			for($i=1; $i<count($array); $i++) {
				$obj = $c->listarPorCodigo($array[$i]);
				$obj->setorden($i);
				$c->actualizar($obj);
			}
			http_response_code(200);
		}else{
			http_response_code(500);
		}
	}else{
		http_response_code(500);
	}
?>