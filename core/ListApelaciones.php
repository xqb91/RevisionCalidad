<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."CustomController.php");
	
	sleep(1);
	try {
		$c = new CustomController();
		$v = $c->evaluacionesApeladas();
		echo "["; 
		for($i=0; $i<count($v); $i++) {
			echo '{';
			echo '"tipo": '.$v[$i]['tipo'].', ';
			echo '"evaluacion": '.$v[$i]['evaluacion'].', ';
			echo '"fecha": "'.$v[$i]['fecha'].'", ';
			echo '"periodo": "'.$v[$i]['periodo'].'", ';
			echo '"rut_ejecutivo": '.$v[$i]['rut_ejecutivo'].', ';
			echo '"nombre_ejecutivo": "'.$v[$i]['nombre_ejecutivo'].'" ';
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