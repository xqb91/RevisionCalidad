<?php
	function generarLogAudio($evaluacion = null) {
		include("../config/Globales.php");
		include("../config/basicos.php");
		include(dirController."AudioController.php");
		include(dirController."LogAudioController.php");
		include(dirController."EvaluadorController.php");
		session_start();
		
		if(isset($_SESSION['loginUser'])) {
			if($evaluacion == null) {

				$eva = filter_input(INPUT_POST, ("evaluacion"));
				if($eva == "") {
					$control = new AudioController();
					$log 	 = new LogAudioController();

					$eje = $_SESSION['loginUser'];
					$eva = $evaluacion;

					$obj = $control->listarPorNumeroParcial($eva);
					if($obj==null) {
						return false;
					}else{
						$obj = $obj[0];

						$arreglo['id']					= 0;
						$arreglo['fecha']				= date('Y-m-d H:i:s');
						$arreglo['usuario']				= $eje->getrut_evaluador();
						$arreglo['numero_evaluacion']	= $obj->getnumero_evaluacion();
						$arreglo['fecha_carga']			= $obj->getfecha();
						$arreglo['nombre_audio']		= $obj->getnombre_audio();
						$arreglo['periodo']				= $obj->getperiodo();

						$commit = new LogAudio($arreglo);
						if($log->ingresar($commit)) {
							return true;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
?>