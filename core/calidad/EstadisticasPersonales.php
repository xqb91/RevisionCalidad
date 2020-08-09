<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirController."EvaluadorController.php");
	session_start();

	$usuario = $_SESSION['loginUser'];
	$resultado = (new EvaluadorController())->estadisticas($usuario->getrut_evaluador());

	echo '[';
	for($i=0; $i<count($resultado); $i++) {
		echo '{';
		echo '"area" : "'.$resultado[$i]['nombre_area'].'", ';
		echo '"parciales" : "'.$resultado[$i]['parciales'].'", ';
		echo '"quincenales" : "'.$resultado[$i]['quincenales'].'", ';
		echo '"finales" : "'.$resultado[$i]['finales'].'", ';
		echo '"total" : "'.($resultado[$i]['parciales']+$resultado[$i]['quincenales']+$resultado[$i]['finales']).'"';
		echo '}';
		if($i<(count($resultado)-1)) {
			echo ',';
		}
	}
	echo ']';

?>