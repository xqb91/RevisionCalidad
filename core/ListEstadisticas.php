<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."CustomController.php");
	
	try {
		$c = new CustomController();
		session_start();
		$area 	 = $_SESSION['current_area_work'];
		$periodo = $_SESSION['current_periodo_work'];

		$v = $c->estadisticas($periodo, $area);
		echo "["; 
		for($i=0; $i<count($v); $i++) {
			echo '{';
			echo '"item": "'.$v[$i]['item'].'", ';
			echo '"total": '.$v[$i]['total'].' ';
			echo '}';
			if($i<count($v)-1) {
				echo ",";
			}
		}
		echo "]";
		http_response_code(200);
	}catch(Exception $e) {
		http_response_code(500);
	}
?>