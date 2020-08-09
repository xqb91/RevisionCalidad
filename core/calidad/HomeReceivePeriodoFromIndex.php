<?php
	session_start();
	if(isset($_SESSION['current_area_work']) && isset($_SESSION['current_periodo_work'])) {
		$area 		= $_SESSION['current_area_work'];
		$periodo 	= $_SESSION['current_periodo_work'];
		if(empty($area) || empty($periodo)) {
			http_response_code(403);
		}else{
			if($periodo == '') {
				http_response_code(402);
			}else{
				echo '{"periodos":{"0":"'.$periodo.'"}}';
				http_response_code(200);
			}
		}
	}else{
		http_response_code(500);
	}
?>