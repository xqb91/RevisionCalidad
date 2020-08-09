<?php
	sleep(1);
	if(!empty(filter_input(INPUT_POST, ("slcArea")))) {
		if(!empty(filter_input(INPUT_POST, ("slcPeriodo")))) { 
			session_start();
			$_SESSION['current_area_work'] 		= filter_input(INPUT_POST, ("slcArea"));
			$_SESSION['current_periodo_work']	= filter_input(INPUT_POST, ("slcPeriodo"));
			http_response_code(200);
		}else{
			http_response_code(403);
		}
	}else{
		http_response_code(401);
	}
?>