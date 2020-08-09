<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EvaluacionParcialController.php");
	include(dirController."DetalleEvaluacionParcialController.php");

	$detalle = new DetalleEvaluacionParcialController();
	$parcial = new EvaluacionParcialController();

	if(isset($_POST["evaluacion"])) {
		if(isset($_POST["item"])) {
			if(isset($_POST["nota"])) {
				$evaluacion = filter_input(INPUT_POST, ("evaluacion"));
				$item 		= filter_input(INPUT_POST, ("item"));
				$nota 		= filter_input(INPUT_POST, ("nota"));				
				if($parcial->existeEvaluacion($evaluacion)) {
					if($detalle->existeDetalle($evaluacion, $item)) {
						//existe... actualizar
						$obj = $detalle->listarPorNumeroItem($evaluacion, $item)[0];
						$obj->setnota($nota);
						if($detalle->actualizar($obj)) {
							http_response_code(200);
						}else{
							http_response_code(302);
						}
					}else{
						//no existe... crear detalle
						$arreglo = null;
						$arreglo['id'] 					= 0;
						$arreglo['numero_evaluacion'] 	= $evaluacion;
						$arreglo['codigo_item'] 		= $item;
						$arreglo['nota'] 				= $nota;

						$obj = new DetalleEvaluacionParcial($arreglo);
						if($detalle->ingresar($obj)) {
							http_response_code(200);
						}else{
							http_response_code(301);
						}
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