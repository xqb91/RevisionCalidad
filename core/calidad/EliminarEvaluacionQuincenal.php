<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/EvaluacionQuincenalController.php");
	include("../controller/DetalleEvaluacionQuincenalController.php");
	
	$cabecera 		= new EvaluacionQuincenalController();
	$posiciones		= new DetalleEvaluacionQuincenalController();

	if(isset($_POST["evaluacion"])) {
		$numero = filter_input(INPUT_POST, ("evaluacion"));
		//validando la existencia de la evaluación quincenal
		$global_eva = $cabecera->listarPorNumero($numero);
		if($global_eva == null) {
			//evaluación vacía
			http_response_code(500);
		}else{
			//VALIDAR SI ESTA EVALUACION ES PARTE DE UNA EVALUACIÓN QUINCENAL (BLOQUEO)

			$global_status = '';

			//objeto de evaluación quincenal
			$global_eva = $global_eva[0];

			//recuperando detalle
			$global_det = $posiciones->listarPorNumeroQUincenal($global_eva->getnumero_quincenal());
			
			if($global_det == null) {
				$global_status = $global_status.'Detalle de la evaluación <strong>está vacío pero fue eliminado</strong> (NOTHING TO DO ON NULL OBJECT)<br />';
			}else{
				if($posiciones->eliminarPorNumeroQuincenal($global_eva->getnumero_quincenal())) {
					$global_status = $global_status.'Se desbloquearon <strong>'.count($global_det).' evaluaciones parciales</strong>.<br />';
					foreach ($global_det as $k) {
						echo "* Evaluación parcial #".$k->getevaluacion_parcial()." desbloqueada<br />";
					}
				}else{
					$global_status = $global_status.'Ocurrió un error al intentar eliminar el detalle de la evaluación quincenal <strong>'.$numero.'</strong>.<br />';
				}
			}


			if($cabecera->eliminar($global_eva)) {
				$global_status = $global_status.'<strong>Se ha eliminado la evaluación quincenal #'.$numero.' exitosamente</strong>.';
			}else{
				$global_status = $global_status.'<strong>Ocurrió un error al eliminar la evaluación quincenal #'.$numero.'</strong>.';
			}
			
			echo $global_status;
			http_response_code(200);
		}
	}else{
		http_response_code(501);
	}
?>