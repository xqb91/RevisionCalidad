<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."JornadaController.php");
	
	sleep(1);
	try {
		$c = new JornadaController();
		$v = $c->listar();
		echo "["; 
		for($i=0; $i<count($v); $i++) {
			echo $v[$i]->serializar();
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