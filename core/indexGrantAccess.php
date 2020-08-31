<?php
	sleep(1);
	if(isset($_POST["grantt"])) { 
		session_start();
		$_SESSION['current_access'] 		= filter_input(INPUT_POST, ("grantt"));
		http_response_code(200);
	}else{
		session_start();
		session_destroy();
		http_response_code(403);
	}
?>