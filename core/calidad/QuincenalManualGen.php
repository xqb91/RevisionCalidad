<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EvaluacionQuincenalController.php");
	include(dirController."EvaluacionesAreaController.php");
	include(dirController."DetalleEvaluacionQuincenalController.php");
	include(dirController."EvaluacionParcialController.php");

	include(dirModel.'Evaluador.php');
	session_start();
	
	if(isset($_POST["evas"]) && isset($_POST["ejecutivo"]) && isset($_POST["area"])) {

		//información proveniente de ajax
		$arrayReceived = filter_input(INPUT_POST, ("evas"));
		$ejecutivo	   = filter_input(INPUT_POST, ("ejecutivo"));
		$area 		   = filter_input(INPUT_POST, ("area"));
		$evaluador 	   = $_SESSION['loginUser'];

		$arrayReceived = json_decode($arrayReceived);

		//instanciando controladores
		$ctrlQuincenal 		= new EvaluacionQuincenalController();
		$ctrlDetQuincenal 	= new DetalleEvaluacionQuincenalController();
		$ctrlEvalPacial		= new EvaluacionParcialController();

		//validar que ninguna de las evaluaciones parciales ingresadas haya sido utilizada 
		//anteriormente
		$bandera = false;

		if($bandera) {
			//retorno indicando que una o mas parciales estan en uso 
			//recoger el valor HTML mediante AJAX
			echo "<strong>No se pudo completar su solicitud</strong>";
			http_response_code(201);
		}else{
			//procede con ejecución... creando la evaluación quincenal
			//calculando la nota quincenal
			$prom 	= 0;
			$count 	= 0; 
			$bandera = true;
			foreach ($arrayReceived as $k) {
				$temp = $ctrlEvalPacial->listarPorNumero($k);
				if($temp != null) {
					$prom = $prom + $temp[0]->getnota_final();
					$count++;
				}else{
					$bandera = false;
				}
			}
			//end calculo de nota quincenal
			//evitando error matemático
			if($count == 0) {
				echo "Ninguna de las ".count($arrayReceived)." evaluaciones fueron encontradas en el sistema. <strong>No se pudo proceder con su solicitud</strong>";
				http_response_code(202);
			}else{
				if($bandera == true) {
					//continuar
					$promedio		= $prom/$count;

					$quincenalToCommit = $ctrlQuincenal->listarPorEjecutivo($ejecutivo, $_SESSION['current_periodo_work']);
					$quincenalToCommit = $quincenalToCommit[0];

					if($quincenalToCommit == null) {
						//INSERT
						//procede con ejecución... creando la evaluación quincenal
						$arreglo['numero_quincenal']	= 0;
						$arreglo['rut_ejecutivo']		= $ejecutivo;
						$arreglo['fecha_creacion']		= date('Y-m-d');
						$arreglo['rut_evaluador']		= $evaluador->getrut_evaluador();
						$arreglo['periodo']				= $_SESSION['current_periodo_work'];
						$arreglo['codigo_area']			= $area;

						//calculando la nota quincenal
						$prom 	= 0;
						$count 	= 0; 
						$bandera = true;
						foreach ($arrayReceived as $k) {
							$temp = $ctrlEvalPacial->listarPorNumero($k);
							if($temp != null) {
								$prom = $prom + $temp[0]->getnota_final();
								$count++;
							}else{
								$bandera = false;
							}
						}
						//end calculo de nota quincenal
						//evitando error matemático
						if($count == 0) {
							echo "Ninguna de las ".count($arrayReceived)." evaluaciones fueron encontradas en el sistema. <strong>No se pudo proceder con su solicitud</strong>";
							http_response_code(202);
						}else{
							if($bandera == true) {
								//continuar
								$arreglo['nota_quincenal']		= $prom/$count;

								$quincenalToCommit = new EvaluacionQuincenal($arreglo);
								if($ctrlQuincenal->ingresar($quincenalToCommit)) {
									$last = $ctrlQuincenal->ultimaEvaluacionGenerada($_SESSION['current_periodo_work'], $ejecutivo, $evaluador->getrut_evaluador(), $area); 

									//insertar detalle
									if($last == null) {
										echo "No se encontró la última evaluación. <strong>No se pudo proceder con su solicitud</strong>";
										http_response_code(404);
									}else{
										foreach ($arrayReceived as $k) {
											$arreglo['numero_quincenal'] 	= $last[0]->getnumero_quincenal();
											$arreglo['numero_evaluacion'] 	= $k;
											$temp = new DetalleEvaluacionQuincenal($arreglo);
											$ctrlDetQuincenal->ingresar($temp);
										}
										echo "<strong>Se generó satisfactoriamente la evaluación quincenal ".$last[0]->getnumero_quincenal()."</strong>";
										http_response_code(200);
									}
								}else{
									echo "La evaluación quincenal no se generó en el sistema. <strong>No se pudo proceder con su solicitud</strong>";
									http_response_code(205);
								}
							}else{
								//una o mas evaluaciones vacías (nulas)
							echo "Una o mas de las ".count($arrayReceived)." evaluaciones no fueron encontradas en el sistema. <strong>No se pudo proceder con su solicitud</strong>";
								http_response_code(206);
							}
						}
					}else{ 
						//UPDATE
						$quincenalToCommit->setfecha_creacion(date('Y-m-d'));
						$quincenalToCommit->setrut_evaluador($evaluador->getrut_evaluador());
						$quincenalToCommit->setnota_quincenal($promedio);

						if($ctrlQuincenal->actualizar($quincenalToCommit)) {

							$last = $quincenalToCommit->getnumero_quincenal();
							//insertar detalle
							if($last == null) {
								echo "No se encontró la última evaluación. <strong>No se pudo proceder con su solicitud</strong>";
								http_response_code(404);
							}else{
								$ctrlDetQuincenal->eliminarPorNumeroQuincenal($last);

								foreach ($arrayReceived as $k) {
									$arreglo['numero_quincenal'] 	= $last;
									$arreglo['numero_evaluacion'] 	= $k;
									$temp = new DetalleEvaluacionQuincenal($arreglo);
									$ctrlDetQuincenal->ingresar($temp);
								}
								echo "<strong>Se regeneró satisfactoriamente la evaluación quincenal ".$last."</strong>";
								http_response_code(200);
							}
						}else{
							echo "La evaluación quincenal no se generó en el sistema. <strong>No se pudo proceder con su solicitud</strong>";
							http_response_code(205);
						}
					}
				}else{
					//una o mas evaluaciones vacías (nulas)
				echo "Una o mas de las ".count($arrayReceived)." evaluaciones no fueron encontradas en el sistema. <strong>No se pudo proceder con su solicitud</strong>";
					http_response_code(206);
				}
			}
		}
	}else{
		http_response_code(500);
	}

?>