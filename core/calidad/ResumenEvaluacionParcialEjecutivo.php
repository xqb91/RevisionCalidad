<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/EvaluacionParcialController.php");
	include("../controller/EvaluacionQuincenalController.php");
	include("../controller/EvaluacionFinalController.php");
	include("../controller/EjecutivoController.php");
	session_start();

	//instancias
	$controlParcial 	= new EvaluacionParcialController();
	$controlQuincenal	= new EvaluacionQuincenalController();
	$controlFinal 		= new EvaluacionFinalController();
	$ejecutivoControl 	= new EjecutivoController();

	if(!isset($_POST["ejecutivo"])) {
		http_response_code(500);
	}else{
		$ejecutivo = filter_input(INPUT_POST, ("ejecutivo"));
		$periodo   = $_SESSION['current_periodo_work'];
	
		$final 	= $controlFinal->listarPorEjecutivo($ejecutivo, $periodo);
		$quinc  = $controlQuincenal->listarPorEjecutivo($ejecutivo, $periodo);
		$parci  = $controlParcial->listarPorEjecutivo($ejecutivo, $periodo);
		echo "{ ";

			if($ejecutivoControl->bloqueado($ejecutivo, $periodo)) {
				echo '"bloqueado_final" : 1, ';
			}else{
				echo '"bloqueado_final" : 0, ';
			}

			if($final == null) {
				echo '"efinal": null,';
			}else{
				echo '"efinal": { "evaluaucion" : '.$final[0]->getnumero_final().', "fecha_creacion" : "'.$final[0]->getfecha_creacion().'", "periodo" : "'.$final[0]->getperiodo().'", "nota" : '.$final[0]->getnotafinal().' },';
			}

			if($quinc == null) {
				echo '"quincenal": null, ';
			}else{
				echo '"quincenal": { "evaluacion" : '.$quinc[0]->getnumero_quincenal().', "fecha_creacion" : "'.$quinc[0]->getfecha_creacion().'", "periodo" : "'.$quinc[0]->getperiodo().'", "nota" : '.$quinc[0]->getnota_quincenal().' },';
			}


			if($parci == null) {
				echo '"parciales" : null';
			}else{
				echo '"parciales" : [';
				
				for($i=0; $i<count($parci); $i++) {
					//etapa de Evaluacion
					if($parci[$i]->getOrden() == null) { $orden = 0; }else{ $orden = $parci[$i]->getOrden(); }
					echo ' { "evaluacion" : '.$parci[$i]->getnumero_evaluacion().', "fecha_evaluacion" : "'.$parci[$i]->getfecha_evaluacion().'", "periodo" : "'.$parci[$i]->getperiodo().'", "nota" : '.$parci[$i]->getnota_final().', "bloqueado" : 0, "orden":  '.$orden.', "estado" : '.$parci[$i]->getEstado().' }';
					if($i<count($parci)-1) {
						echo ",";
					}
				}
				echo "]";
			}
		echo "}";
	}
?>