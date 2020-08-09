<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/AdjuntosController.php");
	session_start();
	$control = new AdjuntosController();



	if(!isset($_FILES['fileadjuntos']['name'])) {
		http_response_code(500);
	}else{
		if(!isset($_POST["evaluacion"])) {
			http_response_code(501);
		}else{
			//nro evaluacion
			$numero_evaluacion = filter_input(INPUT_POST, ("evaluacion"));

			//información del adjunto
			$nombre 		= md5(date("Ymdhis")."-".basename($_FILES['fileadjuntos']['name'])).".".explode(".", basename($_FILES['fileadjuntos']['name']))[count(explode(".", basename($_FILES['fileadjuntos']['name'])))-1];
			$original		= basename($_FILES['fileadjuntos']['name']);
			$fichero_subido = dirFileAttachments.$nombre;

			//definicion para registro de archivo en la base de datos
			$arreglo = null;
			$arreglo['codigo_adjunto']		= 0;
			$arreglo['numero_evaluacion']	= $numero_evaluacion;
			$arreglo['fecha_carga']			= date("Y-m-d");
			$arreglo['periodo']				= $_SESSION['current_periodo_work']; 
			$arreglo['nombre_original']		= $original;
			$arreglo['archivo_server']		= $nombre;

			$obj = new Adjuntos($arreglo);
			
			if($control->ingresar($obj)) {
				if (move_uploaded_file($_FILES['fileadjuntos']['tmp_name'], $fichero_subido)) {
				    $json = '{';
				    $json = $json.'"nombre_fichero":"'.$original.'", ';
				    $json = $json.'"nombre_unico":"'.$nombre.'", ';
				    $json = $json.'"url": "'.str_replace($_SERVER["DOCUMENT_ROOT"]."/calidad/", "", dirFileAttachments)."".$nombre.'", ';
				    $json = $json.'"peso":"'.formatBytes($_FILES['fileadjuntos']['size']).'"';
				    $json = $json.'}'; 
				    echo $json;
				    http_response_code(200);
				} else {
				    http_response_code(301);
				}
			}else{
				http_response_code(302);
			}
		}
	}



	function formatBytes($size, $precision = 1)
	{
	    $base = log($size, 1024);
	    $suffixes = array('', 'Kb', 'Mb', 'Gb', 'Tb');   

	    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
	}
?>