<?php
	//incluyendo librerias básica
	include("../config/Globales.php");
	include("../config/basicos.php");
	//incluyendo controladores para ejecutar las acciones
	include(dirController."EvaluacionFinalController.php");
	include(dirController."EvaluacionParcialController.php");
	include(dirController."EvaluacionQuincenalController.php");
	session_start();
	
	
?>