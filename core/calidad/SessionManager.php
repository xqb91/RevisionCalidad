<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EvaluadorController.php");
	session_start();
	if(isset($_SESSION["rauliUser"])) {
		if(isset($_SESSION['loginUser']) && isset($_SESSION['lastActivity'])) {
			//Sesiones iniciadas... Validando tiempo de inactividad
			$usuario 	=	$_SESSION['rauliUser'];
			$actividad  = 	$_SESSION['lastActivity'];

			if($usuario == null) {
				session_destroy();
				http_response_code(403);
			}else{
				if($actividad == null) {
					session_destroy();
					http_response_code(403);
				}else{
					$last 		= new DateTime($actividad);
					$now 		= new DateTime(date('Y-m-d H:i:s'));
					if($last->diff($now)->i <= maxTiempoInactividad) {
						$evaluador 	=  $_SESSION["rauliUser"];
						$_SESSION['lastActivity'] = date('Y-m-d H:i:s');
						http_response_code(200);
					}else{
						session_destroy();
						http_response_code(401);
					}
				}
			}
		}else{
			$c 			= new EvaluadorController();
			//evaluador logueado en sistema de calidad anterior
			$evaluador 	=  $_SESSION["rauliUser"];
			$recu = $c->listarPorUsuario($evaluador);
			if($recu != null) {
				$_SESSION['loginUser'] = $recu;
				$_SESSION['lastActivity'] = date('Y-m-d H:i:s');
				http_response_code(200);
			}else{
				session_destroy();
				http_response_code(500);
			}
		}
	}else{
		http_response_code(503);
	}
?>