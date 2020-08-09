<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/EvaluacionParcialController.php");
	include("../controller/DetalleEvaluacionParcialController.php");
	include("../controller/AdjuntosController.php");
	include("../controller/AudioController.php");
	include("../controller/DetalleEvaluacionQuincenalController.php");
	
	$evaluacion 		= new EvaluacionParcialController();
	$detalle 			= new DetalleEvaluacionParcialController();
	$adjunto 			= new AdjuntosController();
	$audio 				= new AudioController();
	$ctquincenal 		= new DetalleEvaluacionQuincenalController();

	if(isset($_POST["evaluacion"])) {
		$numero = filter_input(INPUT_POST, ("evaluacion"));
		//validando la existencia de la evaluación parcial
		$global_eva = $evaluacion->listarPorNumero($numero);
		if($global_eva == null) {
			//evaluación vacía
			http_response_code(500);
		}else{
			//VALIDAR SI ESTA EVALUACION ES PARTE DE UNA EVALUACIÓN QUINCENAL (BLOQUEO)
			$blck = $ctquincenal->listarPorNumeroParcial($global_eva[0]->getnumero_evaluacion());
			if($blck != null) {
				echo $blck[0]->getnumero_quincenal();
				http_response_code(206);
			}else{
				$global_status = '';

				//objeto de evaluación parcial
				$global_eva = $global_eva[0];

				//recuperando detalle
				$global_det = $detalle->listarPorNumero($global_eva->getnumero_evaluacion());
				
				//recuperando adjuntos
				$global_adj = $adjunto->listarPorNumeroEvaluacion($global_eva->getnumero_evaluacion());
				
				//recuperando audios
				$global_aud = $audio->listarPorNumeroParcial($global_eva->getnumero_evaluacion());

				if($global_det == null) {
					$global_status = $global_status.'Detalle de la evaluación <strong>está vacío</strong> (NOTHING TO DO ON NULL OBJECT)<br />';
				}else{
					if($detalle->eliminarPorEvaluacion($global_eva)) {
						$global_status = $global_status.'Se eliminaron <strong>'.count($global_det).' items evaluados</strong>.<br />';
					}else{
						$global_status = $global_status.'Ocurrió un error al intentar eliminar el detalle de la evaluación <strong>'.$numero.'</strong>.<br />';
					}
				}

				if($global_adj == null) {
					$global_status = $global_status.'<strong>No se cargaron adjuntos en esta evaluación</strong>.<br />';
				}else{
					foreach ($global_adj as $k) {
						if(file_exists(dirFileAttachments.$k->getarchivo_server())) {
							unlink(dirFileAttachments.$k->getarchivo_server());
							$adjunto->eliminar($k);
						}else{
							$adjunto->eliminar($k);
						}
					}
					$global_status = $global_status.'Se eliminaron <strong>'.count($global_adj).'</strong> archivos adjuntos.<br />';
				}

				if($global_aud == null) {
					$global_status = $global_status.'<strong>No hay audio cargado para esta evaluación</strong>.<br />';
				}else{
					foreach ($global_aud as $k) {
						if(file_exists(dirFileAudio.$k->getnombre_audio())){
							unlink(dirFileAudio.$k->getnombre_audio());
							$audio->eliminar($k);
						}else{
							$audio->eliminar($k);
						}
					}

					$global_status = $global_status.'Se eliminó <strong>'.count($global_aud).' archivo de audio</strong>.<br />';
				}

				if($evaluacion->eliminar($global_eva)) {
					$global_status = $global_status.'<strong>Se ha eliminado la evaluación '.$numero.' exitosamente</strong>.';
				}else{
					$global_status = $global_status.'<strong>Ocurrió un error al eliminar la evaluación '.$numero.'</strong>.';
				}
				
				echo $global_status;
				http_response_code(200);
			}
		}
	}else{
		http_response_code(501);
	}
?>