<?php
	session_start();
	if(isset($_SESSION['current_area_work']) && isset($_SESSION['current_periodo_work'])) {
		$area 		= $_SESSION['current_area_work'];
		$periodo 	= $_SESSION['current_periodo_work'];
		if(empty($area) || empty($periodo)) {
			http_response_code(403);
		}else{
			include("../config/Globales.php");
			include("../config/basicos.php");
			include(dirController."AreaController.php");
			$c = new AreaController();
			$var = $c->listarPorCodigo($area);
			if($var == null) {
				http_response_code(402);
			}else{
				echo $var[0]->serializar();
				http_response_code(200);
			}
		}
	}else{
		http_response_code(500);
	}
?>