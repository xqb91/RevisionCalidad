<?php
	function generarLogDetalleParcial($evaluacion = null) {
		include("../config/Globales.php");
		include("../config/basicos.php");
		include(dirController."EvaluacionParcialController.php");
		include(dirController."DetalleEvaluacionParcialController.php");
		include(dirController."LogDetalleEvaluacionParcialController.php");
		include(dirController."EvaluadorController.php");
		session_start();

		//recuperando información de evaluación
		$ejecutivo 		= $_SESSION['loginUser'];

		//definicion de controllers
		$cteval = new EvaluacionParcialController();
		$ctdet  = new DetalleEvaluacionParcialController();
		$ctlog 	= new LogDetallelEvaluacionParcialController();

		$obj = $cteval->listarPorNumero($evaluacion);
		if($obj != null) {
			$obj = $obj[0];

			//buscando información del detalle
			$afectados = $ctdet->listarPorNumero($obj->getnumero_evaluacion());

			if($afectados == null) {
				return false;
			}else{
				$bandera = 1;
				//generando la estructura de insersión de log
				foreach ($afectados as $k) {

					$arreglo['id']					= 0;
					$arreglo['fecha']				= date('Y-m-d H:i:s');
					$arreglo['usuario']				= $ejecutivo->getrut_evaluador();
					$arreglo['numero_evaluacion']	= $k->getnumero_evaluacion();
					$arreglo['codigo_item']			= $k->getcodigo_item();
					$arreglo['nota']				= $k->getnota();

					$commit = new LogDetalleEvaluacionParcial($arreglo);
					if($bandera == 1) {
						if($ctlog->ingresar($commit)) {
							$bandera = 1;
						}else{
							$bandera = 0;
						}
					}
				}

				if($bandera == 1) {
					return true;
				}else{
					return false;
				}
			}

		}else{
			return false;
		}
	}
?>