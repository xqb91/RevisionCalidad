<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EjecutivoController.php");
	include(dirController."CicloController.php");
	include(dirController."JornadaController.php");
	include(dirController."AreaController.php");

	$ec = new EjecutivoController();
	$cc = new CicloController();
	$jc = new JornadaController();
	$ca = new AreaController();

	if(isset($_POST["ejecutivo"])) {
		$rut = filter_input(INPUT_POST, ("ejecutivo"));

		$ejecutivo = $ec->listarPorRut($rut);
		if($ejecutivo == null) {
			http_response_code(500);
		}else{
			$ejecutivo = $ejecutivo[0];
			$ciclo 	   = $cc->listarPorCodigo($ejecutivo->getcodigo_ciclo());
			$jornada   = $jc->listarPorCodigo($ejecutivo->getcodigo_jornada());
			$area  	   = $ca->listarPorCodigo($ejecutivo->getcodigo_area());

			//JSON FORMAT DATA
			echo '[{';
				echo ' "ejecutivo" : { "rut_ejecutivo" : '.$ejecutivo->getrut_ejecutivo().', "nombre_ejecutivo" : "'.$ejecutivo->getnombre_ejecutivo().'", "correo" : "'.$ejecutivo->getcorreo().'" }, ';
				if($ciclo == null) {
					echo ' "ciclo" : null, ';
				}else{
					echo ' "ciclo" : { "codigo_ciclo" : '.$ciclo[0]->getcodigo_ciclo().', "nombre_ciclo" : "'.$ciclo[0]->getnombre_ciclo().'", "sigla" : "'.$ciclo[0]->getsigla_ciclo().'" }, ';				
				}
				if($jornada == null) {
					echo ' "jornada" : null, ';
				}else{
					echo ' "jornada" : { "codigo_jornada" : '.$jornada[0]->getcodigo_jornada().', "nombre_ciclo" : "'.$jornada[0]->getnombre_jornada().'" }, ';
				}
				if($area == null) {
					echo ' "area" : null ';
				}else{
					echo ' "area" : { "codigo_area" : '.$area[0]->getcodigo_area().', "nombre_area" : "'.$area[0]->getnombre_area().'" } ';
				}
				
			echo '}]';
		}
	}else{
		http_response_code(301);
	}
?>