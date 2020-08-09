<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/AudioController.php");
	session_start();
	
	$control = new AudioController();

	if(!isset($_POST["evaluacion"])) {
		http_response_code(500);
	}else{
		$evaluacion = filter_input(INPUT_POST, ("evaluacion"));
		$obj = $control->listarPorNumeroParcial($evaluacion);
		if($obj == null) {
			http_response_code(500);
		}else{
			$obj = $obj[0];
			//var_dump($obj);
			//echo dirFileAudio.$obj->getnombre_audio();
			if(file_exists(dirFileAudio.$obj->getnombre_audio())) {
				$file = dirFileAudio.$obj->getnombre_audio(); 

				header("Content-Description: File Transfer"); 
				header("Content-Type: application/octet-stream"); 
				header("Content-Disposition: attachment; filename=\"". basename($file) ."\""); 
				readfile ($file);
				exit(); 
			}else{
				echo 'no existe';
				http_response_code(404);
			}
		}
	}
?>