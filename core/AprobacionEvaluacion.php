<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/RevEvaluacionStatusController.php");
	include("../controller/EvaluacionParcialController.php");
	include("../controller/EvaluacionQuincenalController.php");
	include("../controller/DetalleEvaluacionQuincenalController.php");
	include("../controller/DetalleEvaluacionFinalController.php");
	include("../controller/EvaluacionFinalController.php");
	include("../model/Evaluador.php");

	session_start();
	error_reporting(E_ALL);
	$controlRevisiones 		= new RevEvaluacionStatusController();
	$controlParcial 		= new EvaluacionParcialController();
	$controlQuincenal 		= new EvaluacionQuincenalController();
	$controlFinal 			= new EvaluacionFinalController();
	$controlDetQuincenal	= new DetalleEvaluacionQuincenalController();
	$controlDetFinal 		= new DetalleEvaluacionFinalController();

	//in periodo / ejecutivo
	//juan cuervo: 14177700 | periodo: 2020-07
	if(isset($_POST["ejecutivo"])) {
		if(isset($_POST["periodo"])) {
			$usuario 	= $_SESSION['loginUser'];
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
				foreach ($parciales as $k => $v) {
					if($v->getEstado() == 2) {
						$banderaParcialRevision = $banderaParcialRevision+1;
					}

					if($v->getEstado() == 6 || $v->getEstado() == 7) {
						$banderaParcialApelacion = $banderaParcialApelacion+1;
					}

					if($v->getEstado() == 9) {
						$banderaParcialBloqueoCierre = $banderaParcialBloqueoCierre+1;
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
												if($proceso == 'final') {
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
																try{
																	foreach ($parciales as $k => $v) {
																		if($v->getestado() != 9) {
																			$v->setEstado(9);
																			$controlParcial->actualizar($v);

																			$array = null;
																			$array['id']					= 0;
																			$array['tipo']					= 1;
																			$array['fecha']					= null;
																			$array['numero_evaluacion']		= $v->getnumero_evaluacion();	
																			$array['estado']				= 9;
																			$array['usuario']				= $v->getrut_ejecutivo();
																			$array['observacion']			= "Ejecutivo conforme con la evaluación parcial, firma el ".date("d-m-Y")." a las ".date("H:i:s")." frente a ".$usuario->getnombre_evaluador().". ";
																			$array = new RevEvaluacionStatus($array);
																			$controlRevisiones->ingresar($array);
																		}
																	}

																	foreach ($final as $k => $v) {
																		$v->setEstado(9);
																		$controlFinal->actualizar($v);
																		$array = null;
																		$array['id']					= 0;
																		$array['tipo']					= 3;
																		$array['fecha']					= null;
																		$array['numero_evaluacion']		= $v->getnumero_final();	
																		$array['estado']				= 9;
																		$array['usuario']				= $v->getejecutivo_rut_ejecutivo();
																		$array['observacion']			= "Ejecutivo conforme con la evaluación final, firma el ".date("d-m-Y")." a las ".date("H:i:s")." frente a ".$usuario->getnombre_evaluador().". ";
																		$array = new RevEvaluacionStatus($array);
																		$controlRevisiones->ingresar($array);
																	}
																	http_response_code(202);
																}catch(Exception $ex) {
																	http_response_code(301);
																}
															}
														}							
													}	
												}else{
													try{
														foreach ($quincenal as $k => $v) {
															$v->setEstado(9);
															$controlQuincenal->actualizar($v);
														}

														$listado = $controlQuincenal->listarPorNumero($quincenal[0]->getnumero_quincenal());
														if($listado == null) {
															$quincenal[0]->setEstado(1);
															$controlQuincenal->actualizar($quincenal[0]);
														}else{
															foreach ($listado as $k => $v) {
																$v->setEstado(9);
																$controlParcial->actualizar($v);
															}
														}
														http_response_code(202);
													}catch(Exception $ex) {
														http_response_code(301);
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
												try{
													//Posiciones de la quincenal
													$listado = $controlDetQuincenal->listarPorNumeroQUincenal($quincenal[0]->getnumero_quincenal());

													if($listado == null) {
														foreach ($quincenal as $k => $v) {
															$v->setEstado(1);
															$controlQuincenal->actualizar($v);
														}
														http_response_code(302);
													}else{
														foreach ($listado as $k => $v) {
															$aux = $v->getevaluacion_parcial();
															$auxParcial = $controlParcial->listarPorNumero($aux);
															$auxParcial = $auxParcial[0];
															$auxParcial->setEstado(9);
															$controlParcial->actualizar($auxParcial);
															$array = null;
															$array['id']					= 0;
															$array['tipo']					= 1;
															$array['fecha']					= null;
															$array['numero_evaluacion']		= $auxParcial->getnumero_evaluacion();	
															$array['estado']				= 9;
															$array['usuario']				= $auxParcial->getrut_ejecutivo();
															$array['observacion']			= "Ejecutivo conforme con la evaluación parcial, firma el ".date("d-m-Y")." a las ".date("H:i:s")." frente a ".$usuario->getnombre_evaluador().". ";
															$array = new RevEvaluacionStatus($array);
															$controlRevisiones->ingresar($array);
														}
														
														foreach ($quincenal as $k => $v) {
															$v->setEstado(9);
															$controlQuincenal->actualizar($v);
															$array = null;
															$array['id']					= 0;
															$array['tipo']					= 2;
															$array['fecha']					= null;
															$array['numero_evaluacion']		= $v->getnumero_quincenal();	
															$array['estado']				= 9;
															$array['usuario']				= $v->getrut_ejecutivo();
															$array['observacion']			= "Ejecutivo conforme con la evaluación quincenal, firma el ".date("d-m-Y")." a las ".date("H:i:s")." frente a ".$usuario->getnombre_evaluador().". ";
															$array = new RevEvaluacionStatus($array);
															$controlRevisiones->ingresar($array);
														}
														http_response_code(202);
													}
												}catch(Exception $ex) {
													http_response_code(301);
												}
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
			http_response_code(515);
		}
	}else{
		http_response_code(520);
	}
?>