<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."CategoriaController.php");

	sleep(1);
	$c 	= new CategoriaController();
	if(empty(filter_input(INPUT_POST, ("id")))) {
		http_response_code(500);
	}else{
		$id = filter_input(INPUT_POST, ("id"));
		$id = preg_replace('/^[a-zA-Z\s]*$/', '', $id);
		if($id == '') {
			http_response_code(401);
		}else{
			$evaluadores = $c->listarPorArea($id);
			if($evaluadores == null) {
				http_response_code(301);
			}else{	
				echo "[";
				for($i=0; $i<count($evaluadores); $i++){
					$temp = $evaluadores[$i];
					echo $temp->serializar();
					if($i<count($evaluadores)-1) {echo ",";}
				}
				echo "]";
				http_response_code(200);
				//var_dump($evaluadores);
			}
		}
	}

?>