<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/AudioController.php");
	session_start();
	
	$control = new AudioController();


	if(!isset($_FILES['fileAudio']['name'])) {
		http_response_code(500);
	}else{
		if(isset($_POST["evaluacion"])) {
			if($control->existePorNombre(basename($_FILES['fileAudio']['name'])) == 0) {
				//determinando el nombre del fichero a cargar
				$fichero_subido = dirFileAudio. basename($_FILES['fileAudio']['name']);
				//información a cargar en la base de datos
				$arreglo = null;
				$arreglo['numero_evaluacion']	= filter_input(INPUT_POST, ("evaluacion"));
				$arreglo['fecha'] 				= date("Y-m-d");
				$arreglo['nombre_audio']		= basename($_FILES['fileAudio']['name']);
				$arreglo['periodo']				= $_SESSION['current_periodo_work'];

				$audio = new Audio($arreglo);
				if($control->ingresar($audio)) {
					if (move_uploaded_file($_FILES['fileAudio']['tmp_name'], $fichero_subido)) {
					    $json = '{';
					    $json = $json.'"nombre_fichero":"'.basename($_FILES["fileAudio"]["name"]).'", ';
					    $json = $json.'"url": "'.str_replace($_SERVER["DOCUMENT_ROOT"]."/calidad/", "", dirFileAudio)."".basename($_FILES['fileAudio']['name']).'", ';
					    $json = $json.'"peso":"'.formatBytes($_FILES['fileAudio']['size']).'"';
					    $json = $json.'}'; 
					    echo $json;
					    http_response_code(200);
					} else {
					    http_response_code(301);
					}
				}else{
					http_response_code(502);
				}
			}else{
				http_response_code(302);
			}
		}else{
			http_response_code(501);
		}
	}



	function formatBytes($size, $precision = 2)
	{
	    $base = log($size, 1024);
	    $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb');   

	    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
	}
?>