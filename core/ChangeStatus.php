<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/RevEvaluacionStatusController.php");
	include("../controller/EvaluacionParcialController.php");
	include("../controller/EvaluacionQuincenalController.php");
	include("../controller/EvaluacionFinalController.php");
	include("../model/Evaluador.php");
	session_start();

	if(isset($_POST['evaluacion'])) {
		if(isset($_POST["tipo"])) {
			if(isset($_POST["comentario"])) {
				if(isset($_SESSION['loginUser'])) {
					if(isset($_POST["nuevoestado"])) {
						//recuperacion de variables
						$usuario 		= $_SESSION['loginUser'];
						$comentario 	= filter_input(INPUT_POST, ("comentario"));
						$tipo 			= filter_input(INPUT_POST, ("tipo"));
						$evaluacion 	= filter_input(INPUT_POST, ("evaluacion"));
						$nuevoestado	= filter_input(INPUT_POST, ("nuevoestado"));

						$ctrlRevisiones = new RevEvaluacionStatusController();

						switch ($tipo) {
							case 1:
								$ctrlParcial 	= new EvaluacionParcialController();
								$tempeva 		= $ctrlParcial->listarPorNumero($evaluacion);
								if($tempeva == null) {
									http_response_code(401);
								}else{
									$tempeva = $tempeva[0];
									if($tempeva->getEstado() == 1) {
										$tempeva->setEstado(2);

										$array['id']					= 0;
										$array['tipo']					= 1;
										$array['numero_evaluacion']		= $evaluacion;
										$array['estado']				= 2;
										$array['usuario']				= $usuario->getrut_evaluador();
										$array['observacion']			= $comentario;

										$nuevo = new RevEvaluacionStatus($array);
										if($ctrlRevisiones->ingresar($nuevo) == true) {
											if($ctrlParcial->actualizar($tempeva)) {
												http_response_code(200);
												echo 'Evaluación enviada a revisión';
											}else{
												http_response_code(201);
											}
										}else{
											http_response_code(202);
										}
									}else if($tempeva->getEstado() == 6){
										if($nuevoestado == 'aceptada') {
											$tempeva->setEstado(7);

											$array['id']					= 0;
											$array['tipo']					= 1;
											$array['numero_evaluacion']		= $evaluacion;
											$array['estado']				= 7;
											$array['usuario']				= $usuario->getrut_evaluador();
											$array['observacion']			= $comentario;

											$nuevo = new RevEvaluacionStatus($array);
											if($ctrlRevisiones->ingresar($nuevo) == true) {
												if($ctrlParcial->actualizar($tempeva)) {
													http_response_code(200);
													echo 'Apelación aceptada';
												}else{
													http_response_code(201);
												}
											}else{
												http_response_code(202);
											}
										}else{
											$tempeva->setEstado(8);

											$array['id']					= 0;
											$array['tipo']					= 1;
											$array['numero_evaluacion']		= $evaluacion;
											$array['estado']				= 8;
											$array['usuario']				= $usuario->getrut_evaluador();
											$array['observacion']			= $comentario;

											$nuevo = new RevEvaluacionStatus($array);
											if($ctrlRevisiones->ingresar($nuevo) == true) {
												if($ctrlParcial->actualizar($tempeva)) {
													http_response_code(200);
													echo 'Apelación rechazada';
												}else{
													http_response_code(201);
												}
											}else{
												http_response_code(202);
											}
										}
									}
								}
							break;
							
							case 2:
								$ctrlQuincenal 	= new EvaluacionQuincenalController();
								$tempeva 		= $ctrlQuincenal->listarPorNumero($evaluacion);

								if($tempeva == null) {
									http_response_code(401);
								}else{
									$tempeva = $tempeva[0];
									if($tempeva->getEstado() == 1) {
										$tempeva->setEstado(2);

										$array['id']					= 0;
										$array['tipo']					= 1;
										$array['numero_evaluacion']		= $evaluacion;
										$array['estado']				= 2;
										$array['usuario']				= $usuario->getrut_evaluador();
										$array['observacion']			= $comentario;

										$nuevo = new RevEvaluacionStatus($array);
										if($ctrlRevisiones->ingresar($nuevo) == true) {
											if($ctrlQuincenal->actualizar($tempeva)) {
												http_response_code(200);
												echo 'Evaluación enviada a revisión';
											}else{
												http_response_code(201);
											}
										}else{
											http_response_code(202);
										}
									}else if($tempeva->getEstado() == 6){
										if($nuevoestado == 'aceptada') {
											$tempeva->setEstado(7);

											$array['id']					= 0;
											$array['tipo']					= 1;
											$array['numero_evaluacion']		= $evaluacion;
											$array['estado']				= 7;
											$array['usuario']				= $usuario->getrut_evaluador();
											$array['observacion']			= $comentario;

											$nuevo = new RevEvaluacionStatus($array);
											if($ctrlRevisiones->ingresar($nuevo) == true) {
												if($ctrlQuincenal->actualizar($tempeva)) {
													http_response_code(200);
													echo 'Apelación aceptada';
												}else{
													http_response_code(201);
												}
											}else{
												http_response_code(202);
											}
										}else{
											$tempeva->setEstado(8);

											$array['id']					= 0;
											$array['tipo']					= 1;
											$array['numero_evaluacion']		= $evaluacion;
											$array['estado']				= 8;
											$array['usuario']				= $usuario->getrut_evaluador();
											$array['observacion']			= $comentario;

											$nuevo = new RevEvaluacionStatus($array);
											if($ctrlRevisiones->ingresar($nuevo) == true) {
												if($ctrlQuincenal->actualizar($tempeva)) {
													http_response_code(200);
													echo 'Apelación rechazada';
												}else{
													http_response_code(201);
												}
											}else{
												http_response_code(202);
											}
										}
									}
								}
							break;

							case 3:
								$ctrlFinal 		= new EvaluacionFinalController();
								$tempeva 		= $ctrlFinal->listarPorNumero($evaluacion);

								if($tempeva == null) {
									http_response_code(401);
								}else{
									$tempeva = $tempeva[0];
									if($tempeva->getEstado() == 1) {
										$tempeva->setEstado(2);

										$array['id']					= 0;
										$array['tipo']					= 1;
										$array['numero_evaluacion']		= $evaluacion;
										$array['estado']				= 2;
										$array['usuario']				= $usuario->getrut_evaluador();
										$array['observacion']			= $comentario;

										$nuevo = new RevEvaluacionStatus($array);
										if($ctrlRevisiones->ingresar($nuevo) == true) {
											if($ctrlFinal->actualizar($tempeva)) {
												http_response_code(200);
												echo 'Evaluación enviada a revisión';
											}else{
												http_response_code(201);
											}
										}else{
											http_response_code(202);
										}
									}else if($tempeva->getEstado() == 6){
										if($nuevoestado == 'aceptada') {
											$tempeva->setEstado(7);

											$array['id']					= 0;
											$array['tipo']					= 1;
											$array['numero_evaluacion']		= $evaluacion;
											$array['estado']				= 7;
											$array['usuario']				= $usuario->getrut_evaluador();
											$array['observacion']			= $comentario;

											$nuevo = new RevEvaluacionStatus($array);
											if($ctrlRevisiones->ingresar($nuevo) == true) {
												if($ctrlFinal->actualizar($tempeva)) {
													http_response_code(200);
													echo 'Apelación aceptada';
												}else{
													http_response_code(201);
												}
											}else{
												http_response_code(202);
											}
										}else{
											$tempeva->setEstado(8);

											$array['id']					= 0;
											$array['tipo']					= 1;
											$array['numero_evaluacion']		= $evaluacion;
											$array['estado']				= 8;
											$array['usuario']				= $usuario->getrut_evaluador();
											$array['observacion']			= $comentario;

											$nuevo = new RevEvaluacionStatus($array);
											if($ctrlRevisiones->ingresar($nuevo) == true) {
												if($ctrlFinal->actualizar($tempeva)) {
													http_response_code(200);
													echo 'Apelación rechazada';
												}else{
													http_response_code(201);
												}
											}else{
												http_response_code(202);
											}
										}
									}
								}
							break;

							default:
								http_response_code(500);
							break;
						}
					}else{
						http_response_code(501);
					}
				}else{
					http_response_code(502);
				}
			}else{
				http_response_code(503);
			}
		}else{
			http_response_code(504);
		}
	}else{
		http_response_code(505);
	}

	/*
	$control = new EvaluacionParcialController();

	if(isset($_POST["evaluacion"])) {
		if(isset($_POST["comentarios"])) {
			$comentarios = htmlspecialchars(filter_input(INPUT_POST, ("comentarios")), ENT_QUOTES, "UTF-8");
			$evaluacion  = filter_input(INPUT_POST, ("evaluacion"));

			$obj = $control->listarPorNumero($evaluacion);
			if($obj == null) {
				http_response_code(503);
			}else{
				$obj = $obj[0];
				$obj->setobservacion($comentarios);

				//determinando si es una corrección
				if($obj->getEstado() == 2) {
					$obj->setEstado(4);
				}

				
				if($control->actualizar($obj)) {
					http_response_code(200);
				}else{
					http_response_code(301);
				}
			}
		}else{
			http_response_code(501);
		}
	}else{
		http_response_code(500);
	}
	*/
?>