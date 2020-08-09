<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/AdjuntosController.php");
	session_start();
	$control = new AdjuntosController();



	if(!isset($_POST["evaluacion"])) {
		http_response_code(500);
	}else{
		$evaluacion = filter_input(INPUT_POST, ("evaluacion"));
		$obj = $control->listarPorNumeroEvaluacion($evaluacion);
		if($obj == null) {
			echo "nulo";
			http_response_code(501);
		}else{
			echo '{ "adjunto" : [ ';
			for($i=0; $i<count($obj); $i++) {
				echo '{ "nombre_fichero" : "'.$obj[$i]->getnombre_original().'", ';
				echo '  "nombre_unico" : "'.$obj[$i]->getarchivo_server().'", ';
				echo '  "url" : "'.str_replace($_SERVER["DOCUMENT_ROOT"]."/calidad/", "", dirFileAttachments)."".$obj[$i]->getarchivo_server().'", ';		
				echo '  "peso" : "'.formatBytes(filesize(dirFileAttachments.$obj[$i]->getarchivo_server())).'" ';		
				echo '}';
				if($i<count($obj)-1) {
					echo ',';
				}
			}
			echo "] }";
		}
	}


	function formatBytes($size, $precision = 1)
	{
	    $base = log($size, 1024);
	    $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb');   

	    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
	}
?>