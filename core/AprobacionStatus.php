<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/RevEvaluacionStatusController.php");
	include("../controller/EvaluacionParcialController.php");
	include("../controller/EvaluacionQuincenalController.php");
	include("../controller/EvaluacionFinalController.php");
	include("../model/Evaluador.php");
	session_start();

	$controlRevisiones 		= new RevEvaluacionStatusController();
	$controlParcial 		= new EvaluacionParcialController();
	$controlQuincenal 		= new EvaluacionQuincenalController();
	$controlFinal 			= new EvaluacionFinalController();

	//in periodo / ejecutivo
	//juan cuervo: 14177700 | periodo: 2020-07
	

	if(isset($_POST["ejecutivo"])) {
		if(isset($_POST["periodo"])) {
			if(isset($_POST["tipo"])) {
				$ejecutivo 	= filter_input(INPUT_POST, ("ejecutivo"));
				$periodo 	= filter_input(INPUT_POST, ("periodo"));
				$proceso 	= filter_input(INPUT_POST, ("tipo"));

				$parciales 	= $controlParcial->listarPorEjecutivoPeriodo($ejecutivo, $periodo);
				if($parciales == null) {
					http_response_code(500);
				}else{
					$banderaParcialApelacion		 = 0;
					$banderaParcialRevision 		 = 0;
					$banderaParcialBloqueoCierre 	 = 0;
					$counterAux 					 = 0;
					foreach ($parciales as $k => $v) {
						if($v->getEstado() == 2) {
							$banderaParcialRevision = $banderaParcialRevision+1;
						}

						if($v->getEstado() == 6 || $v->getEstado() == 7) {
							$banderaParcialApelacion = $banderaParcialApelacion+1;
						}

						if($v->getEstado() == 9) {
							$banderaParcialBloqueoCierre = $banderaParcialBloqueoCierre+1;
							$counterAux++;
						}
					}

					//validando si TODAS las evaluaciones parciales se bloquearon por cierre
					if($counterAux < count($parciales)) {
						$banderaParcialBloqueoCierre = 0;

					}

					$quincenal = $controlQuincenal->listarPorEjecutivoPeriodo($ejecutivo, $periodo);
					if($quincenal == null) {
						http_response_code(501);
					}else{
						$banderaQuincenalApelacion 		 = 0;
						$banderaQuincenalRevision  		 = 0;
						$banderaQuincenalBloqueoCierre 	 = 0;
						foreach ($quincenal as $k => $v) {
							if($v->getEstado() == 2) {
								$banderaQuincenalRevision = $banderaQuincenalRevision+1;
							}

							if($v->getEstado() == 6 || $v->getEstado() == 7) {
								$banderaQuincenalApelacion = $banderaQuincenalApelacion+1;
							}

							if($v->getEstado() == 9) {
								$banderaQuincenalBloqueoCierre = $banderaQuincenalBloqueoCierre+1;
							}
						}
						if($proceso == 'final') {
							$final 	= $controlFinal->listarPorEjecutivo($ejecutivo, $periodo);
							if($final == null) {
								http_response_code(502);
							}else{
								$banderaFinalApelacion 		 = 0;
								$banderaFinalRevision  		 = 0;
								$banderaFinalBloqueoCierre 	 = 0;
								foreach ($final as $k => $v) {
									if($v->getEstado() == 2) {
										$banderaFinalRevision = $banderaFinalRevision+1;
									}

									if($v->getEstado() == 6 || $v->getEstado() == 7) {
										$banderaFinalApelacion = $banderaFinalApelacion+1;
									}

									if($v->getEstado() == 9) {
										$banderaFinalBloqueoCierre = $banderaFinalBloqueoCierre+1;
									}
								}

								//validaciones globales
								if($banderaParcialRevision > 0) { 
									//HTTP 400: Parcial revisión pendiente
									http_response_code(400); 
								}else{
									if($banderaParcialApelacion > 0) { 
										//HTTP 401: Parcial apelación pendiente
										http_response_code(401); 
									}else{
										if($banderaParcialBloqueoCierre > 0) { 
											//HTTP 402: Parcial cerrada
											http_response_code(402); 
										}else{
											if($banderaQuincenalRevision > 0) { 
												//HTTP 403: Quincenal revisión pendiente
												http_response_code(403); 
											}else{
												if($banderaQuincenalApelacion > 0) { 
													//HTTP 404: Quincenal apelación pendiente
													http_response_code(404); 
												}else{
													if($banderaFinalRevision > 0) { 
														//HTTP 406: Final revisión pendiente
														http_response_code(406); 
													}else{
														if($banderaFinalApelacion > 0) { 
															//HTTP 407: Final apelación pendiente
															http_response_code(407); 
														}else{
															if($banderaFinalBloqueoCierre > 0)	{ 
																//HTTP 408: Final apelación pendiente
																http_response_code(408); 
															}else{
																http_response_code(206);
															}
														}							
													}					
												}				
											}			
										}
									}
								}
							}
						}else{
							//validaciones globales
							if($banderaParcialRevision > 0) { 
								//HTTP 400: Parcial revisión pendiente
								http_response_code(400); 
							}else{
								if($banderaParcialApelacion > 0) { 
									//HTTP 401: Parcial apelación pendiente
									http_response_code(401); 
								}else{
									if($banderaParcialBloqueoCierre > 0) { 
										//HTTP 402: Parcial cerrada
										http_response_code(402); 
									}else{
										if($banderaQuincenalRevision > 0) { 
											//HTTP 403: Quincenal revisión pendiente
											http_response_code(403); 
										}else{
											if($banderaQuincenalApelacion > 0) { 
												//HTTP 404: Quincenal apelación pendiente
												http_response_code(404); 
											}else{
												if($banderaQuincenalBloqueoCierre > 0) { 
													//HTTP 405: Parcial cerrada
													http_response_code(405); 
												}else{
													http_response_code(206);					
												}					
											}				
										}			
									}
								}
							}
						}
					}
				}
			}else{
				http_response_code(510);
			}
		}else{
			http_response_code(515);
		}
	}else{
		http_response_code(520);
	}
?>