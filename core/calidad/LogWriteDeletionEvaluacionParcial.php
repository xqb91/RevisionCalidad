<?php

	function generarLogParcial($evaluacion = null) {
		include("../config/Globales.php");
		include("../config/basicos.php");
		include(dirController."EvaluacionParcialController.php");
		include(dirController."LogEvaluacionParcialController.php");
		include(dirController."EvaluadorController.php");
		session_start();

		//recuperando información de evaluación
		$ejecutivo 		= $_SESSION['loginUser'];

		//definicion de controllers
		$cteval = new EvaluacionParcialController();
		$ctlog 	= new LogEvaluacionParcialController();

		$obj = $cteval->listarPorNumero($evaluacion);
		if($obj != null) {
			$obj = $obj[0];

			//generando la estructura de insersión de log
				$arreglo['id']					= 0;
				$arreglo['fecha']				= date('Y-m-d H:i:s');
				$arreglo['usuario']				= $ejecutivo->getrut_evaluador();
				$arreglo['numero_evaluacion']	= $obj->getnumero_evaluacion();
				$arreglo['fecha_evaluacion']	= $obj->getfecha_evaluacion();
				$arreglo['rut_ejecutivo']		= $obj->getrut_ejecutivo();
				$arreglo['rut_evaluador']		= $obj->getrut_evaluador();
				$arreglo['nota_final']			= $obj->getnota_final();
				$arreglo['observacion']			= $obj->getobservacion();
				$arreglo['codigo_area']			= $obj->getcodigo_area();

				$commit = new LogEvaluacionParcial($arreglo);
				if($ctlog->ingresar($commit)) {
					return true;
				}else{
					return false;
				}
		}else{
			return false;
		}
	}
?>