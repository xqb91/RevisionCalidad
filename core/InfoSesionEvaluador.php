<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EvaluadorController.php");
	session_start();
	sleep(1);
	if(isset($_SESSION['loginUser'])) {
		$usuario = $_SESSION['loginUser'];
		echo $usuario->serializar();
	}else{
		http_response_code(500);
	}
?>