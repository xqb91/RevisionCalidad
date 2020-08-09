<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/AdjuntosController.php");
	$control = new AdjuntosController();

	
	$nombre = filter_input(INPUT_POST, ("file"));
	$nombre = basename($nombre);
	if($nombre == '') {
		http_response_code(500);
	}else{
		$obj = $control->listarPorArchivoServer($nombre);
		if($obj == null) {
			http_response_code(501);
		}else{
			if($control->eliminar($obj[0])) {
				if(file_exists(dirFileAttachments.$nombre)) {
					if(unlink(dirFileAttachments.$nombre)) {
						http_response_code(200);
					}else{
						http_response_code(401);
					}
				}else{
					http_response_code(301);
				}
			}else{
				http_response_code(502);
			}
		}
	}
?>