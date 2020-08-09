<?php
	include("../config/Globales.php");
	include("../config/basicos.php");

	if(!isset($_POST["url"])) {
		http_response_code(500);
	}else{
		$adjunto = filter_input(INPUT_POST, ("url"));
		$nombre = filter_input(INPUT_POST, ("original"));
		$file = dirbase.'/calidad/'.$adjunto; 
		if(file_exists($file)) {
			
			header("Content-Description: File Transfer"); 
			header("Content-Type: application/octet-stream"); 
			header("Content-Disposition: attachment; filename=\"". $nombre ."\""); 
			readfile ($file);
			exit(); 
		}else{
			http_response_code(404);
		}
	}
?>