<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/EvaluacionesAreaController.php");
	session_start();
	$control = new EvaluacionesAreaController();

	if(isset($_POST["area"])) {
		$area = filter_input(INPUT_POST, ("area"));
		
		$obj = $control->listarPorCodigoAreaPeriodo($area, $_SESSION['current_periodo_work']);
		if($obj == null) {
			http_response_code(301);
		}else{
			foreach ($obj as $k) {
				echo $k->serializar();
				break;
			}
		}
	}else{
		http_response_code(302);
	}

?>