<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/EvaluacionFinalController.php");
	session_start();
	$control = new EvaluacionFinalController();



	if(!isset($_POST["evaluacion"])) {
		http_response_code(500);
	}else{
		$evaluacion = filter_input(INPUT_POST, ("evaluacion"));
		$obj = $control->listarPorNumero($evaluacion);
		if($obj == null) {
			echo "nulo";
			http_response_code(501);
		}else{
			$obj = $obj[0];
			echo "{";
				echo '"evaluacion" : '.$obj->getnumero_final().', ';
				echo '"fecha" : "'.$obj->getfecha_creacion().'", ';
				echo '"periodo" : "'.$obj->getperiodo().'", ';
				echo '"nota" : '.$obj->getnotafinal().', ';
				echo '"estado" : '.$obj->getestado().' ';
			echo "}";
		}
	}


	function formatBytes($size, $precision = 1)
	{
	    $base = log($size, 1024);
	    $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb');   

	    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
	}
?>