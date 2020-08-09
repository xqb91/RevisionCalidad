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
				$json = '{';
			    $json = $json.'"nombre_fichero":"'.$obj->getnombre_audio().'", ';
			    $json = $json.'"url": "'.str_replace($_SERVER["DOCUMENT_ROOT"]."/calidad/", "", dirFileAudio)."".$obj->getnombre_audio().'", ';
			    $json = $json.'"peso":"'.formatBytes(filesize(dirFileAudio.$obj->getnombre_audio())).'"';
			    $json = $json.'}'; 
			    echo $json;
			    http_response_code(200);
			}else{
				echo 'no existe';
				http_response_code(404);
			}
		}
	}


	function formatBytes($size, $precision = 2)
	{
	    $base = log($size, 1024);
	    $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb');   

	    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
	}
?>