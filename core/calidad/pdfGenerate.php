<?php
	include("../config/Globales.php");
	include("../config/basicos.php");
	include(dirFramework."mpdf/vendor/autoload.php");
	include(dirController."EvaluadorController.php");
	session_start();
	if(isset($_SESSION['loginUser'])) {
		if(isset($_GET["evaluacion"])) {
			$evaluacion = filter_input(INPUT_GET, ("evaluacion"));
			if(isset($_GET["tipo"])) {
				$tipo = filter_input(INPUT_GET, ("tipo"));

				if(isset($_GET["accion"])) {
					$accion = filter_input(INPUT_GET, ("accion"));
				}else{
					$accion = "ver";
				}

				switch ($tipo) {
					case 'parcial':
						//determinando nombre del fichero randomico en base a rut del evaluador solicitante y fecha
						$usuario = $_SESSION['loginUser'];
						$usuario->getrut_evaluador();
						$nombre_fichero = "temp_".md5(date('YmdHisu').$usuario->getrut_evaluador()).".html";
						//realizando operaciones
							$templatedaata 	= file_get_contents(DomainNameURL."/templatepdf/parcial.php?evaluacion=".$evaluacion);
							file_put_contents(dirFileesTemporal.$nombre_fichero, $templatedaata);

						$array = ['','', 0, '', 15, 15, 16, 16, 9, 9, 'L'];
						$mpdf = new \Mpdf\Mpdf([
					    'mode' => 'utf-8',
					    'format' => 'A4-L',
					    'orientation' => 'L'
						]);

						// La variable $html es vuestro código que queréis pasar a PDF
						$html = file_get_contents(dirFileesTemporal.$nombre_fichero);
						if(file_exists(dirFileesTemporal.$nombre_fichero)) {
							if(unlink(dirFileesTemporal.$nombre_fichero)) {
								echo "Eliminado";
							}else{
								echo "No Eliminado";
							}
						}
						$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::DEFAULT_MODE);

						// Genera el fichero y fuerza la descarga
						$nombre_pdf = "parcial_".$evaluacion.".pdf";
						switch ($accion) {
							case 'ver':
								$mpdf->Output($nombre_pdf, 'I'); exit;
							break;
							
							case 'descargar':
								$mpdf->Output($nombre_pdf, 'D'); exit;
							break;

							default:
								$mpdf->Output($nombre_pdf, 'I'); exit;
							break;
						}
						
						if(file_exists(dirFileesTemporal.$nombre_fichero)) {
							sleep(2);
							if(unlink(dirFileesTemporal.$nombre_fichero)) {
								//echo "Eliminado";
							}else{
								//echo "No Eliminado";
							}
						}
					break;
					
					case 'quincenal':
						//determinando nombre del fichero randomico en base a rut del evaluador solicitante y fecha
						$usuario = $_SESSION['loginUser'];
						$usuario->getrut_evaluador();
						$nombre_fichero = "temp_".md5(date('YmdHisu').$usuario->getrut_evaluador()).".html";
						//echo $nombre_fichero; 
						//realizando operaciones
							$templatedaata 	= file_get_contents(DomainNameURL."/templatepdf/quincenal.php?evaluacion=".$evaluacion);
							file_put_contents(dirFileesTemporal.$nombre_fichero, $templatedaata);

						$array = ['','', 0, '', 15, 15, 16, 16, 9, 9, 'L'];
						$mpdf = new \Mpdf\Mpdf([
					    'mode' => 'utf-8',
					    'format' => 'A4-L',
					    'orientation' => 'L'
						]);

						// La variable $html es vuestro código que queréis pasar a PDF
						$html = file_get_contents(dirFileesTemporal.$nombre_fichero);
						if(file_exists(dirFileesTemporal.$nombre_fichero)) {
							if(unlink(dirFileesTemporal.$nombre_fichero)) {
								//echo "Eliminado";
							}else{
								//echo "No Eliminado";
							}
						}
						$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::DEFAULT_MODE);

						// Genera el fichero y fuerza la descarga
						$nombre_pdf = "quincenal_".$evaluacion.".pdf";
						switch ($accion) {
							case 'ver':
								$mpdf->Output($nombre_pdf, 'I'); exit;
							break;
							
							case 'descargar':
								$mpdf->Output($nombre_pdf, 'D'); exit;
							break;

							default:
								$mpdf->Output($nombre_pdf, 'I'); exit;
							break;
						}
												
						if(file_exists(dirFileesTemporal.$nombre_fichero)) {
							sleep(2);
							if(unlink(dirFileesTemporal.$nombre_fichero)) {
								echo "Eliminado";
							}else{
								echo "No Eliminado";
							}
						}
					break;

					case 'final':
//determinando nombre del fichero randomico en base a rut del evaluador solicitante y fecha
						$usuario = $_SESSION['loginUser'];
						$usuario->getrut_evaluador();
						$nombre_fichero = "temp_".md5(date('YmdHisu').$usuario->getrut_evaluador()).".html";
						//echo $nombre_fichero; 
						//realizando operaciones
							$templatedaata 	= file_get_contents(DomainNameURL."/templatepdf/final.php?evaluacion=".$evaluacion);
							file_put_contents(dirFileesTemporal.$nombre_fichero, $templatedaata);

						$array = ['','', 0, '', 15, 15, 16, 16, 9, 9, 'L'];
						$mpdf = new \Mpdf\Mpdf([
					    'mode' => 'utf-8',
					    'format' => 'A4-L',
					    'orientation' => 'L'
						]);

						// La variable $html es vuestro código que queréis pasar a PDF
						$html = file_get_contents(dirFileesTemporal.$nombre_fichero);
						if(file_exists(dirFileesTemporal.$nombre_fichero)) {
							if(unlink(dirFileesTemporal.$nombre_fichero)) {
								//echo "Eliminado";
							}else{
								//echo "No Eliminado";
							}
						}
						$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::DEFAULT_MODE);

						// Genera el fichero y fuerza la descarga
						$nombre_pdf = "final_".$evaluacion.".pdf";
						switch ($accion) {
							case 'ver':
								$mpdf->Output($nombre_pdf, 'I'); exit;
							break;
							
							case 'descargar':
								$mpdf->Output($nombre_pdf, 'D'); exit;
							break;

							default:
								$mpdf->Output($nombre_pdf, 'I'); exit;
							break;
						}
												
						if(file_exists(dirFileesTemporal.$nombre_fichero)) {
							sleep(2);
							if(unlink(dirFileesTemporal.$nombre_fichero)) {
								echo "Eliminado";
							}else{
								echo "No Eliminado";
							}
						}
					break;

					default:
						echo '<h1>Ha ocurrido un error</h1>';
						echo '<h3>El tipo de evaluación solicitado no ha sido recibido o no existe.</h3>';
						break;
				}
			}else{
				echo '<h1>Ha ocurrido un error</h1>';
				echo '<h3>El argumento tipo no ha sido recibido para procesar su solicitud.</h3>';
			}
		}else{
			echo '<h1>Ha ocurrido un error</h1>';
			echo '<h3>El argumento evaluación no ha sido recibido para procesar su solicitud.</h3>';
		}
	}else{
		echo '<h1>Ha ocurrido un error</h1>';
		echo '<h3>Usted no ha iniciado sesión. Imposible procesar su solicitud.</h3>';
	}

?>