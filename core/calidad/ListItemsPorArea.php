<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."ItemEvaluacionController.php");

	$c 	= new ItemEvaluacionController();
	if(empty(filter_input(INPUT_POST, ("id")))) {
		http_response_code(500);
	}else{
		$id = filter_input(INPUT_POST, ("id"));
		$id = preg_replace('/^[a-zA-Z\s]*$/', '', $id);
		if($id == '') {
			http_response_code(401);
		}else{
			$items = $c->listarPorArea($id);
			if($items == null) {
				http_response_code(301);
			}else{
				echo "[";
				for($i=0; $i<count($items); $i++){
					$temp = $items[$i];
					echo $temp->serializar();
					if($i<count($items)-1) {echo ",";}
				}
				echo "]";
				http_response_code(200);
				//var_dump($evaluadores);
			}
		}
	}

?>