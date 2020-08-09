<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirModel."Evaluador.php");
	include(dirController."LogDesbloqueoController.php");
	session_start();
	

	if(isset($_POST["ejecutivo"])) {
		//instancias de controladores
		$ctrlParcial 	= new LogDesbloqueoController();

		$usuario = $_SESSION['loginUser'];
		if($usuario == null) {
			http_response_code(203);
		}else{
			try {
				$arreglo['id']			= 0;
				$arreglo['fecha']		= '';
				$arreglo['evaluador']	= $usuario->getrut_evaluador();
				$arreglo['ejecutivo']	= filter_input(INPUT_POST, ("ejecutivo"));
				$arreglo['periodo']		= $_SESSION['current_periodo_work'];

				$obj = new LogDesbloqueo($arreglo);
				if($ctrlParcial->ingresar($obj)) {
					http_response_code(200);
				}else{
					http_response_code(204);
				}
			}catch(Exception $e) {
				http_response_code(400);
			}
		}
	}else{
		echo "Se ha rechazado la petición, no se especificó el ejecutivo con el que se debe trabajar";
		http_response_code(201);
	}


?>