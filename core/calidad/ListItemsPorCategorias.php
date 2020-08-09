<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."ItemEvaluacionController.php");

	if(isset($_POST['categoria'])) {
		$categoria = filter_input(INPUT_POST, ('categoria'));
		if($categoria == '') {
			http_response_code(501);
		}else{
			$controller = new ItemEvaluacionController();
			$array = $controller->listarPorCategoria($categoria);
			echo '[';
			for($i=0; $i<count($array); $i++) {
				$k = $array[$i];
				echo $k->serializar();
				if($i<count($array)-1) {
					echo ',';
				}
			}
			echo ']';
			http_response_code(200);
		}
	}else{
		http_response_code(500);
	}
?>