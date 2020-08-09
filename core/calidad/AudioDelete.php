<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/AudioController.php");
	$control = new AudioController();
	
	$nombre 		= filter_input(INPUT_POST, ("file"));
	$evaluacion 	= filter_input(INPUT_POST, ("evaluacion"));
	$nombre = basename($nombre);
	if($nombre == '') {
		http_response_code(500);
	}else{
		if($evaluacion == '') {
			http_response_code(501);
		}else{
			if(file_exists(dirFileAudio.$nombre)) {
				if(unlink(dirFileAudio.$nombre)) {
					$obj = $control->listarPorNombre($nombre);
					if($obj == null) {
						http_response_code(204);
					}else{
						if($control->eliminar($obj[0])) {
							http_response_code(200);
						}else{
							http_response_code(203);
						}
					}
				}else{
					http_response_code(401);
				}
			}else{
				http_response_code(301);
			}
		}
	}
?>