<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EvaluacionParcialController.php");
	include(dirController."EvaluacionQuincenalController.php");
	include(dirController."EvaluacionesAreaController.php");
	include(dirController."DetalleEvaluacionQuincenalController.php");

	$array = null;

	if(isset($_POST["periodo"])) {
		if(isset($_POST["ejecutivo"])) {
			if(isset($_POST["evaluador"])) {
				if(isset($_POST["area"])) {
					$periodo 		= filter_input(INPUT_POST, ("periodo"));
					$ejecutivo 		= filter_input(INPUT_POST, ("ejecutivo"));
					$evaluador 		= filter_input(INPUT_POST, ("evaluador"));
					$area 			= filter_input(INPUT_POST, ("area"));

					//valores para inicializar la evaluación a generar
					$array['numero_evaluacion'] = '0';
					$array['fecha_evaluacion']	= date('Y-m-d');
					$array['periodo']			= $periodo;  //<---
					$array['rut_ejecutivo']		= $ejecutivo;	  //<--- 
					$array['rut_evaluador']		= $evaluador;	  //<--- 
					$array['nota_final']		= 0;
					$array['observacion']		= '';
					$array['codigo_area']		= $area;		  //<---

					$evaluacion = new EvaluacionParcial($array);
					$controlado = new EvaluacionParcialController();
					$quincenal  = new EvaluacionQuincenalController();
					$evaArea    = new EvaluacionesAreaController();
					$detaQuinc 	= new DetalleEvaluacionQuincenalController();

					//generando evaluacion quincenal
					$evaluaciones = $evaArea->listarPorCodigoAreaPeriodo($area, $periodo)[0];
					if($evaluaciones != null) {
						if($controlado->listarPorEjecutivo($ejecutivo, $periodo) != null) { 
							if(count($controlado->listarPorEjecutivo($ejecutivo, $periodo)) == $evaluaciones->getcantidad_quincenales()) {
								$arreglo['numero_quincenal'] 	= 0;
								$arreglo['rut_ejecutivo']		= $ejecutivo;
								$arreglo['fecha_creacion']		= date("Y-m-d");
								$arreglo['rut_evaluador']		= $evaluador;
								$arreglo['periodo']				= $periodo;
								$arreglo['codigo_area']			= $area;
								//obtener promedio de notas parciales
								$contador = 0;
								$notas	  = 0;
								foreach ($controlado->listarPorEjecutivo($ejecutivo, $periodo) as $k) {
									$notas = $notas + $k->getnota_final();
									$contador++;
								}
								$arreglo['nota_quincenal']		= ($notas/$contador);

								//ingresando evaluacion
								$obj = new EvaluacionQuincenal($arreglo);
								$quincenal->ingresar($obj);

								//obtener número de última quincenal
								$recienCreada = $quincenal->ultimaEvaluacionGenerada($obj->getperiodo(), $obj->getrut_ejecutivo(), $obj->getrut_evaluador(), $obj->getejecutivo_codigo_area());
								//ingresar detalle a la quincenal
								foreach ($controlado->listarPorEjecutivo($ejecutivo, $periodo) as $k) {
									$arreglo = null;
									$arreglo['numero_quincenal']	= $recienCreada[0]->getnumero_quincenal();
									$arreglo['numero_evaluacion']	= $k->getnumero_evaluacion();
									$obj = new DetalleEvaluacionQuincenal($arreglo);
									$detaQuinc->ingresar($obj);
								}
							}
						}
					}


					if($controlado->ingresar($evaluacion) == 1) {
						$parcial = $controlado->ultimaEvaluacionGenerada($periodo, $ejecutivo, $evaluador, $area);
						$parcial = $controlado->seteaNumeroOrden($parcial[0]);
						if($parcial == null) {
							http_response_code(401);
						}else{
							echo $parcial[0]->serializar();
							http_response_code(200);
						}

					}else{
						http_response_code(401);
					}
				}else{
					http_response_code(503);
				}
			}else{
				http_response_code(502);
			}
		}else{
			http_response_code(501);
		}
	}else{
		http_response_code(500);
	}
?>