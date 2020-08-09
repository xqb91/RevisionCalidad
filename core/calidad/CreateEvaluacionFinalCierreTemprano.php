<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	
	//including models necesaries
	include(dirModel."Evaluador.php");

	//including controllers
	include(dirController."EvaluacionFinalController.php");
	include(dirController."EvaluacionesAreaController.php");
	include(dirController."EvaluacionParcialController.php");
	include(dirController."DetalleEvaluacionFinalController.php");
	include(dirController."EjecutivoController.php");
	include(dirController."CicloController.php");
	include(dirController."AreaController.php");
	include(dirController."JornadaController.php");
	//recuperando session PHP
	session_start();
	
	//instancias de control
	$cabecera		= new EvaluacionFinalController();
	$posicion 		= new DetalleEvaluacionFinalController();
	$limiter 		= new EvaluacionesAreaController();
	$registro 		= new EvaluacionParcialController();
	$ejectrl        = new EjecutivoController();
	$ciclo 			= new CicloController();
	$areactl		= new AreaController();
	$jornada 		= new JornadaController();

	if(isset($_POST["ejecutivo"])) {
		

		$area 			= $_SESSION['current_area_work'];
		$ejecutivo 		= filter_input(INPUT_POST, ("ejecutivo"));
		$periodo 		= $_SESSION['current_periodo_work'];
		$evaluador 		= $_SESSION['loginUser'];


		if($cabecera->listarPorEjecutivo($ejecutivo, $periodo) == null) {
			//validar la cantidad de parciales necesarias para generar la final (SIN CIERRE TEMPRANO)
			$max = $limiter->listarPorCodigoAreaPeriodo($area, $periodo);
			if($max == null) {
				//no hay limite de notas definido para este periodo
				http_response_code(503);
			}else{
				$max = $max[0]->getcantidad_finales();
				$parciales = $registro->listarPorEjecutivo($ejecutivo, $periodo);
				if(count($parciales) == 0) {
					//bloqueo.... no se puede porque no tiene el mínimo de notas solicitadas
					//para un cierre NORMAL
					http_response_code(502);
				}else{
					$dataNotas 		= $cabecera->calcularNotaFinal($ejecutivo, $periodo);

					//crea la evaluación final
					$arreglo['numero_final']	= 0;
					$arreglo['fecha_creacion']	= date('Y-m-d H:i:s');
					$arreglo['periodo']			= $periodo;
					$arreglo['rut_ejecutivo']	= $ejecutivo;
					$arreglo['rut_evaluador']	= $evaluador->getrut_evaluador();
					$arreglo['codigo_area']		= $area;
					$arreglo['observaciones']	= "";
					$arreglo['nota_final']		= $dataNotas[0]["final"];

					$evaluacionfinal = new EvaluacionFinal($arreglo);
					if($cabecera->ingresar($evaluacionfinal)) {
						//recuperando el número de la evaluación final ya ingresada
						$last = $cabecera->listarPorEjecutivo($ejecutivo, $periodo);
						
						//ingresando el detalle de la evaluación final...
						$bandera = true;
						foreach ($parciales as $k) {
							$arreglo['numero_evaluacion']	= $k->getnumero_evaluacion();
							$arreglo['numero_final']		= $last[0]->getnumero_final();
							$temp = new DetalleEvaluacionFinal($arreglo);
							$bandera = $posicion->ingresar($temp);
						}
						if($bandera) {
							$dataEjecutivo 	= $ejectrl->listarPorRut($ejecutivo);
							$dataCliclo    	= $ciclo->listarPorCodigo($dataEjecutivo[0]->getcodigo_ciclo());
							$dataArea 	   	= $areactl->listarPorCodigo($dataEjecutivo[0]->getcodigo_area());
							$dataJornada 	= $jornada->listarPorCodigo($dataEjecutivo[0]->getcodigo_jornada());
							//generación de JSON
							echo '{';
							echo '  "evaluacion": '.$last[0]->getnumero_final().',';
							echo '  "ejecutivo": {';
							echo '    "rut": "'.$ejecutivo.'",';
							echo '    "nombre": "'.$dataEjecutivo[0]->getnombre_ejecutivo().'",';
							echo '    "area": "'.$dataArea[0]->getnombre_area().'",';
							echo '    "ciclo": "'.$dataCliclo[0]->getnombre_ciclo().'",';
							echo '    "jornada": "'.$dataJornada[0]->getnombre_jornada().'"';
							echo '  },';
							echo '  "periodo": "'.$periodo.'",';
							echo '  "parciales": [';

							for($i=0; $i<count($dataNotas); $i++) {
								echo '{';
								echo ' "categoria": "'.$dataNotas[$i]["nombre_categoria"].'",';
								echo ' "nota": '.$dataNotas[$i]["promedio"].'';
								echo ' }';
								if($i<count($dataNotas)-1) {
									echo ',';
								}
							}
							echo '  ],';
							echo '  "nota_final": '.$dataNotas[0]["final"].'';
							echo '}';
							http_response_code(200);
						}else{
							http_response_code(406);
						}
					}else{
						//falló la generación de la evaluación final (cabecera!)
						http_response_code(403);
					}
				}
			}
		}else{
			//ejecutivo ya tiene una evaluación final para este periodo
			http_response_code(401);
		}

	}else{
		http_response_code(501);
	}
?>