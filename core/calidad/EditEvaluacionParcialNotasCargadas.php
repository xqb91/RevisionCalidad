<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."DetalleEvaluacionParcialController.php");
	include(dirController."ItemEvaluacionController.php");
	//include(dirController."CategoriaController.php");

	$control = new DetalleEvaluacionParcialController();
	$items 	 = new ItemEvaluacionController();
	$categ   = new CategoriaController();

	if(!isset($_POST["evaluacion"])) {
		http_response_code(501);
	}else{
		$numero = filter_input(INPUT_POST, "evaluacion");
		$obj = $control->listarPorNumero($numero);
		if($obj == null) {
			http_response_code(500);
		}else{
			echo '{ "items" : [';
			for($i=0; $i<count($obj); $i++) {
				//echo '"'.$i.'" : [';
				//insercion de valores internos
					echo '{';
						echo '"evaluacion" : '.$obj[$i]->getnumero_evaluacion().',';
						$temp = $items->listarPorCodigo($obj[$i]->getcodigo_item())[0];
						$temp2= $categ->listarPorCodigo($temp->getcodigo_categoria());
						echo '"codigo_categoria" : '.$temp->getcodigo_categoria().',';
						echo '"nombre_categoria" : "'.$temp2->getnombre_categoria().'",';
						echo '"peso_categoria" : '.$temp2->getpeso_categoria().',';
						echo '"codigo_item" : '.$obj[$i]->getcodigo_item().',';
						echo '"nombre_item" : "'.$temp->getnombre_item().'",';
						echo '"nota" : '.$obj[$i]->getnota().',';
						echo '"valor0" : '.$temp->getValor0().',';
						echo '"valor05" : '.$temp->getValor05().',';
						echo '"valor1" : '.$temp->getValor1().',';
						echo '"mostrar" : '.$temp->getMostrar().',';
						echo '"obligatorio" : '.$temp->getObligatorio().'';

					echo '}';
				//echo ']';
				if( $i<count($obj)-1) {
					echo ',';
				}
			}
			echo "] }";
			http_response_code(200);
		}
	}

?>