<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include("../controller/EvaluacionParcialController.php");
	$control = new EvaluacionParcialController();

	if(isset($_POST["evaluacion"])) {
		$rut = filter_input(INPUT_POST, ("evaluacion"));

		$obj = $control->detalleTotalEvaluacionParcial($rut);
		if($obj == null) {
			echo '[null]';
		}else{
			echo '[';
				for($i=0; $i<count($obj); $i++) {
					$k = $obj[$i];

					if(empty($k["nota_categoria"])) {$nota_categoria = '"No evaluado"'; }else{ $nota_categoria = $k["nota_categoria"]; } 

					echo '{ "numero_evaluacion" : '.$k["numero_evaluacion"].', "nota_parcial" : '.$k["nota_parcial"].', "nombre_categoria" : "'.$k["nombre_categoria"].'", "peso_categoria" : '.$k["peso_categoria"].', "nota_categoria" : '. $nota_categoria.', "audio" : "'.$k["audio"].'" }';
					if($i<count($obj)-1) {
						echo ',';
					}
				}

			echo ']';
		}
	}else{
		http_response_code(301);
	}



?>