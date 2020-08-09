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

	if(isset($_POST["evaluacion"])) {
		

		$area 			= $_SESSION['current_area_work'];
		$evaluacion		= filter_input(INPUT_POST, ("evaluacion"));
		$periodo 		= $_SESSION['current_periodo_work'];
		$evaluador 		= $_SESSION['loginUser'];


		if($cabecera->listarPorNumero($evaluacion) != null) {
			//validar la cantidad de parciales necesarias para generar la final (SIN CIERRE TEMPRANO)
			$max = $limiter->listarPorCodigoAreaPeriodo($area, $periodo);
			if($max == null) {
				//no hay limite de notas definido para este periodo
				http_response_code(503);
			}else{
				//recuperando el número de la evaluación final a editar
				$last = $cabecera->listarPorNumero($evaluacion);


				$max = $max[0]->getcantidad_finales();
				$parciales = $registro->listarPorEjecutivo($last[0]->getejecutivo_rut_ejecutivo(), $periodo);
				if(count($parciales) < $max) {
					//bloqueo.... no se puede porque no tiene el mínimo de notas solicitadas
					//para un cierre NORMAL
					http_response_code(502);
				}else{
					$dataNotas 		= $cabecera->calcularNotaFinal($last[0]->getejecutivo_rut_ejecutivo(), $periodo);

					$dataEjecutivo 	= $ejectrl->listarPorRut($last[0]->getejecutivo_rut_ejecutivo());
					$dataCliclo    	= $ciclo->listarPorCodigo($dataEjecutivo[0]->getcodigo_ciclo());
					$dataArea 	   	= $areactl->listarPorCodigo($dataEjecutivo[0]->getcodigo_area());
					$dataJornada 	= $jornada->listarPorCodigo($dataEjecutivo[0]->getcodigo_jornada());
					//generación de JSON
					echo '{';
					echo '  "evaluacion": '.$last[0]->getnumero_final().',';
					echo '  "ejecutivo": {';
					echo '    "rut": "'.$last[0]->getejecutivo_rut_ejecutivo().'",';
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
					echo '  "nota_final": '.$dataNotas[0]["final"].',';
					echo '  "observacion": "'.str_replace('"', "'", trim(preg_replace('/\t+/', '', html_entity_decode($last[0]->getobservaciones(), ENT_QUOTES, 'UTF-8')))).'"';
					echo '}';
					http_response_code(200);

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