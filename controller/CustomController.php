<?php
	//Controlador OK: 09.04.2020
	session_start();
	include(dirModel."Area.php");
	class CustomController {

		private $databaseTransaction;

		//constructor del controlador de Area
		public function __construct() {
			$this->databaseTransaction = new DatabaseTransaction();
		}

		//devuelve el objeto inicializado por el controlador de DatabaseTransaction (Conexion contra la base de datos)
		public function getDatabaseTransaction() {
			return $this->databaseTransaction;
		}

		//Devuelve verrdadero o falso dependiendo si pudo sobreescribir el objeto de DatabaseTransaction
		public function setDatabaseTransaction($databaseTransaction) {
			try {
				$this->databaseTransaction = $databaseTransaction;
				return true;
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		//funcion retorna un arreglo de todos los registros que encuentre en la tabla
		public function ejecutivosEvaluadosPorEvaluadorEn($rut_evaluador, $area, $periodo) {
			try {
					$consulta = "SELECT "; 
					$consulta = $consulta."distinct xx.rut_ejecutivo, ";
					$consulta = $consulta."b.nombre_ejecutivo ";
					$consulta = $consulta."FROM ( ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."a.rut_ejecutivo ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_parcial a  ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."a.codigo_area = ".$area." ";
					if($rut_evaluador != '*') {
						$consulta = $consulta."AND a.rut_evaluador = ".$rut_evaluador." ";
					}
					$consulta = $consulta."AND a.periodo = '".$periodo."' ";
					$consulta = $consulta."UNION ALL ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."a.rut_ejecutivo ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_quincenal a  ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."a.codigo_area = ".$area." ";
					if($rut_evaluador != '*') {
						$consulta = $consulta."AND a.rut_evaluador = ".$rut_evaluador." ";
					}
					$consulta = $consulta."AND a.periodo = '".$periodo."' ";
					$consulta = $consulta."UNION ALL ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."distinct a.rut_ejecutivo ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_final a  ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."a.codigo_area = ".$area." ";
					if($rut_evaluador != '*') {
						$consulta = $consulta."AND a.rut_evaluador = ".$rut_evaluador." ";
					}
					$consulta = $consulta."AND a.periodo = '".$periodo."' ";
					$consulta = $consulta.")xx ";
					$consulta = $consulta."INNER JOIN ejecutivo b ON xx.rut_ejecutivo = b.rut_ejecutivo ";

				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						$array = null;
						$i 	   = 0;
						while($registro = $this->databaseTransaction->resultados()) {
							$array[$i] = $registro;
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "Controller Area - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function ejecutivosPorArea($area, $periodo) {
			try {
					$consulta = "SELECT "; 
					$consulta = $consulta."distinct xx.rut_ejecutivo, ";
					$consulta = $consulta."b.nombre_ejecutivo ";
					$consulta = $consulta."FROM ( ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."a.rut_ejecutivo ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_parcial a  ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."a.codigo_area = ".$area." ";
					$consulta = $consulta."AND a.periodo = '".$periodo."' ";
					$consulta = $consulta."UNION ALL ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."a.rut_ejecutivo ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_quincenal a  ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."a.codigo_area = ".$area." ";
					$consulta = $consulta."AND a.periodo = '".$periodo."' ";
					$consulta = $consulta."UNION ALL ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."distinct a.rut_ejecutivo ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_final a  ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."a.codigo_area = ".$area." ";
					$consulta = $consulta."AND a.periodo = '".$periodo."' ";
					$consulta = $consulta.")xx ";
					$consulta = $consulta."INNER JOIN ejecutivo b ON xx.rut_ejecutivo = b.rut_ejecutivo ORDER BY nombre_ejecutivo ASC";

				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						$array = null;
						$i 	   = 0;
						while($registro = $this->databaseTransaction->resultados()) {
							$array[$i] = $registro;
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "Controller Area - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function filtrarEvaluaciones($periodo, $codigo_area, $rut_evaluador, $rut_ejecutivo, $estado) {
			try {
				$consulta = "SELECT  ";
				$consulta = $consulta."*  ";
				$consulta = $consulta."FROM (  ";
				// -------------------- BLOQUE EVALUACION PARCIAL --------------------------------
					$consulta = $consulta."SELECT   ";
					$consulta = $consulta."1 as tipo,  ";
					$consulta = $consulta."a.numero_evaluacion as evaluacion,  ";
					$consulta = $consulta."a.fecha_evaluacion as fecha_creacion,  ";
					$consulta = $consulta."a.periodo,  ";
					$consulta = $consulta."a.rut_ejecutivo,  ";
					$consulta = $consulta."b.nombre_ejecutivo,  ";
					$consulta = $consulta."a.rut_evaluador,  ";
					$consulta = $consulta."c.nombre_evaluador,  ";
					$consulta = $consulta."a.nota_final as nota,  ";
					$consulta = $consulta."a.observacion as observacion,  ";
					$consulta = $consulta."a.codigo_area,  ";
					$consulta = $consulta."a.orden,  ";
					$consulta = $consulta."a.estado  ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_parcial a ";
					$consulta = $consulta."INNER JOIN ejecutivo b ON a.rut_ejecutivo = b.rut_ejecutivo ";
					$consulta = $consulta."INNER JOIN evaluador c ON a.rut_evaluador = c.rut_evaluador ";
					$consulta = $consulta."WHERE   ";
					$consulta = $consulta."a.periodo = '".$periodo."'  ";
					$consulta = $consulta."AND a.codigo_area = ".$codigo_area."  ";
					if($rut_evaluador != '*') {
						$consulta = $consulta."AND a.rut_evaluador = ".$rut_evaluador."  ";
					}
					if($rut_ejecutivo != '*') { 
						$consulta = $consulta."AND a.rut_ejecutivo = ".$rut_ejecutivo."  ";
					}
					if($estado != '*') {
						$consulta = $consulta."AND a.estado = ".$estado."  ";
					}
				// ---------------------- BLOQUE EVALUACION QUINCENAL -------------------------------
					$consulta = $consulta."UNION ALL  ";
					$consulta = $consulta."SELECT   ";
					$consulta = $consulta."2 as tipo,  ";
					$consulta = $consulta."a.numero_quincenal as evaluacion,  ";
					$consulta = $consulta."a.fecha_creacion,  ";
					$consulta = $consulta."a.periodo,  ";
					$consulta = $consulta."a.rut_ejecutivo,  ";
					$consulta = $consulta."b.nombre_ejecutivo,  ";
					$consulta = $consulta."a.rut_evaluador,  ";
					$consulta = $consulta."c.nombre_evaluador, ";
					$consulta = $consulta."a.nota_quincenal as nota,  ";
					$consulta = $consulta."'Evaluacion Automática' as observacion,  ";
					$consulta = $consulta."a.codigo_area,  ";
					$consulta = $consulta."-1 orden,  ";
					$consulta = $consulta."a.estado  ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_quincenal a ";
					$consulta = $consulta."INNER JOIN ejecutivo b ON a.rut_ejecutivo = b.rut_ejecutivo ";
					$consulta = $consulta."INNER JOIN evaluador c ON a.rut_evaluador = c.rut_evaluador ";
					$consulta = $consulta."WHERE   ";
					$consulta = $consulta."a.periodo = '".$periodo."'  ";
					$consulta = $consulta."AND a.codigo_area = ".$codigo_area."  ";
					if($rut_evaluador != '*') {
						$consulta = $consulta."AND a.rut_evaluador = ".$rut_evaluador."  ";
					}
					if($rut_ejecutivo != '*') { 
						$consulta = $consulta."AND a.rut_ejecutivo = ".$rut_ejecutivo."  ";
					}
					if($estado != '*') {
						$consulta = $consulta."AND a.estado = ".$estado."  ";
					}
					$consulta = $consulta."UNION ALL  ";
				// ------------------------ BLOQUE EVALUACION FINAL ----------------------------------
					$consulta = $consulta."SELECT   ";
					$consulta = $consulta."3 as tipo,  ";
					$consulta = $consulta."a.numero_final as evaluacion,  ";
					$consulta = $consulta."a.fecha_creacion,  ";
					$consulta = $consulta."a.periodo,  ";
					$consulta = $consulta."a.rut_ejecutivo,  ";
					$consulta = $consulta."b.nombre_ejecutivo,  ";
					$consulta = $consulta."a.rut_evaluador,  ";
					$consulta = $consulta."a.rut_evaluador,  ";
					$consulta = $consulta."a.nota_final as nota,  ";
					$consulta = $consulta."a.observaciones as observacion,  ";
					$consulta = $consulta."a.codigo_area,  ";
					$consulta = $consulta."-1 orden,  ";
					$consulta = $consulta."a.estado  ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_final a ";
					$consulta = $consulta."INNER JOIN ejecutivo b ON a.rut_ejecutivo = b.rut_ejecutivo  ";
					$consulta = $consulta."INNER JOIN evaluador c ON a.rut_evaluador = c.rut_evaluador  ";
					$consulta = $consulta."WHERE   ";
					$consulta = $consulta."a.periodo = '".$periodo."'  ";
					$consulta = $consulta."AND a.codigo_area = ".$codigo_area."  ";
					if($rut_evaluador != '*') {
						$consulta = $consulta."AND a.rut_evaluador = ".$rut_evaluador."  ";
					}
					if($rut_ejecutivo != '*') { 
						$consulta = $consulta."AND a.rut_ejecutivo = ".$rut_ejecutivo."  ";
					}
					if($estado != '*') {
						$consulta = $consulta."AND a.estado = ".$estado."  ";
					}
				$consulta = $consulta.")xx  ";
				$consulta = $consulta."ORDER BY tipo DESC, orden DESC  ";
				//echo $consulta;
				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						$array = null;
						$i 	   = 0;
						while($registro = $this->databaseTransaction->resultados()) {
							$array[$i] = $registro;
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "Controller Area - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		//edit this 
		public function filtrarEvaluacionesSupervisor($periodo, $codigo_area, $rut_ejecutivo, $estado) {
			try {
				if($codigo_area == 1) {
					$consulta = "SELECT * FROM ( ";
					$consulta = $consulta."SELECT ";
					$consulta = $consulta."'quincenal' as entrega, ";
					$consulta = $consulta."2 as tipo, ";
					$consulta = $consulta."a.numero_quincenal as numero_evaluacion, ";
					$consulta = $consulta."a.periodo, ";
					$consulta = $consulta."a.codigo_area, ";
					$consulta = $consulta."a.fecha_creacion as fecha_evaluacion, ";
					$consulta = $consulta."a.rut_ejecutivo, ";
					$consulta = $consulta."x.nombre_ejecutivo, ";
					$consulta = $consulta."a.rut_evaluador, ";
					$consulta = $consulta."y.nombre_evaluador, ";
					$consulta = $consulta."cast(a.nota_quincenal as decimal(12,2)) as nota_final, ";
					$consulta = $consulta."-1 as orden, ";
					$consulta = $consulta."a.estado ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_quincenal a  ";
					$consulta = $consulta."INNER JOIN ejecutivo x ON a.rut_ejecutivo = x.rut_ejecutivo ";
					$consulta = $consulta."INNER JOIN evaluador y ON a.rut_evaluador = y.rut_evaluador ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."periodo = '".$periodo."' ";
					$consulta = $consulta."UNION ALL  ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."'quincenal' as entrega, ";
					$consulta = $consulta."1 as tipo, ";
					$consulta = $consulta."a.numero_evaluacion, ";
					$consulta = $consulta."a.periodo, ";
					$consulta = $consulta."a.codigo_area, ";
					$consulta = $consulta."a.fecha_evaluacion, ";
					$consulta = $consulta."a.rut_ejecutivo, ";
					$consulta = $consulta."x.nombre_ejecutivo, ";
					$consulta = $consulta."a.rut_evaluador, ";
					$consulta = $consulta."y.nombre_evaluador, ";
					$consulta = $consulta."a.nota_final, ";
					$consulta = $consulta."a.orden, ";
					$consulta = $consulta."a.estado ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_parcial a  ";
					$consulta = $consulta."INNER JOIN ejecutivo x ON a.rut_ejecutivo = x.rut_ejecutivo ";
					$consulta = $consulta."INNER JOIN evaluador y ON a.rut_evaluador = y.rut_evaluador ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."a.numero_evaluacion in (SELECT numero_evaluacion FROM detalle_evaluacion_quincenal b WHERE b.numero_quincenal in ( SELECT numero_quincenal FROM evaluacion_quincenal WHERE periodo = '".$periodo."')) ";
					$consulta = $consulta."UNION ALL  ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."'final' as entrega, ";
					$consulta = $consulta."3 as tipo, ";
					$consulta = $consulta."z.numero_final as numero_evaluacion, ";
					$consulta = $consulta."z.periodo, ";
					$consulta = $consulta."z.codigo_area, ";
					$consulta = $consulta."z.fecha_creacion as fecha_evaluacion, ";
					$consulta = $consulta."z.rut_ejecutivo, ";
					$consulta = $consulta."x.nombre_ejecutivo, ";
					$consulta = $consulta."z.rut_evaluador, ";
					$consulta = $consulta."y.nombre_evaluador, ";
					$consulta = $consulta."z.nota_final, ";
					$consulta = $consulta."-1 as orden, ";
					$consulta = $consulta."z.estado ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_final z ";
					$consulta = $consulta."INNER JOIN ejecutivo x ON z.rut_ejecutivo = x.rut_ejecutivo ";
					$consulta = $consulta."INNER JOIN evaluador y ON z.rut_evaluador = y.rut_evaluador ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."periodo = '".$periodo."' ";
					$consulta = $consulta."UNION ALL ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."'final' as entrega, ";
					$consulta = $consulta."1 as tipo, ";
					$consulta = $consulta."z.numero_evaluacion, ";
					$consulta = $consulta."z.periodo, ";
					$consulta = $consulta."z.codigo_area, ";
					$consulta = $consulta."z.fecha_evaluacion, ";
					$consulta = $consulta."z.rut_ejecutivo, ";
					$consulta = $consulta."x.nombre_ejecutivo, ";
					$consulta = $consulta."z.rut_evaluador, ";
					$consulta = $consulta."y.nombre_evaluador, ";
					$consulta = $consulta."z.nota_final, ";
					$consulta = $consulta."z.orden, ";
					$consulta = $consulta."z.estado ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_parcial z  ";
					$consulta = $consulta."INNER JOIN ejecutivo x ON z.rut_ejecutivo = x.rut_ejecutivo ";
					$consulta = $consulta."INNER JOIN evaluador y ON z.rut_evaluador = y.rut_evaluador ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."z.numero_evaluacion in (SELECT numero_evaluacion FROM detalle_evaluacion_final WHERE numero_final IN (SELECT numero_final FROM evaluacion_final WHERE periodo = '".$periodo."') AND numero_evaluacion NOT IN (SELECT numero_evaluacion FROM detalle_evaluacion_quincenal b WHERE b.numero_quincenal in ( SELECT numero_quincenal  ";
					$consulta = $consulta."FROM evaluacion_quincenal WHERE periodo = '".$periodo."')))   ";
					$consulta = $consulta."ORDER BY `tipo` ASC ";
					$consulta = $consulta.")xx  ";
					$consulta = $consulta."WHERE codigo_area = ".$codigo_area."  ";
					if($rut_ejecutivo != '*') {
						$consulta = $consulta."AND rut_ejecutivo = ".$rut_ejecutivo."  ";
					}
					if($estado != '*') {
						if($estado == 5) {
							$consulta = $consulta."AND estado in (1,4,5)  ";	
						}else{
							$consulta = $consulta."AND estado = ".$estado."  ";	
						}
					}
					$consulta = $consulta."ORDER BY nombre_ejecutivo ASC, orden ASC ";
				}else{
					$consulta = "SELECT * FROM ( ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."'quincenal' as entrega, ";
					$consulta = $consulta."2 as tipo, ";
					$consulta = $consulta."a.numero_quincenal as numero_evaluacion, ";
					$consulta = $consulta."a.periodo, ";
					$consulta = $consulta."a.codigo_area, ";
					$consulta = $consulta."a.fecha_creacion as fecha_evaluacion, ";
					$consulta = $consulta."a.rut_ejecutivo, ";
					$consulta = $consulta."x.nombre_ejecutivo, ";
					$consulta = $consulta."a.rut_evaluador, ";
					$consulta = $consulta."y.nombre_evaluador, ";
					$consulta = $consulta."cast(a.nota_quincenal as decimal(12, 2)) as nota_final, ";
					$consulta = $consulta."-1 as orden, ";
					$consulta = $consulta."a.estado  ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_quincenal a  ";
					$consulta = $consulta."INNER JOIN ejecutivo x ON a.rut_ejecutivo = x.rut_ejecutivo  ";
					$consulta = $consulta."INNER JOIN evaluador y ON a.rut_evaluador = y.rut_evaluador  ";
					$consulta = $consulta."WHERE ";
					$consulta = $consulta."periodo = '".$periodo."'  ";
					$consulta = $consulta."AND a.codigo_area = ".$codigo_area." ";
					if($rut_ejecutivo != '*') {
						$consulta = $consulta."AND a.rut_ejecutivo = ".$rut_ejecutivo." ";
					}
					$consulta = $consulta."UNION ALL  ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."'quincenal' as entrega, ";
					$consulta = $consulta."1 as tipo, ";
					$consulta = $consulta."a.numero_evaluacion, ";
					$consulta = $consulta."a.periodo, ";
					$consulta = $consulta."a.codigo_area, ";
					$consulta = $consulta."a.fecha_evaluacion, ";
					$consulta = $consulta."a.rut_ejecutivo, ";
					$consulta = $consulta."x.nombre_ejecutivo, ";
					$consulta = $consulta."a.rut_evaluador, ";
					$consulta = $consulta."y.nombre_evaluador, ";
					$consulta = $consulta."a.nota_final, ";
					$consulta = $consulta."a.orden, ";
					$consulta = $consulta."a.estado  ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_parcial a  ";
					$consulta = $consulta."INNER JOIN ejecutivo x ON a.rut_ejecutivo = x.rut_ejecutivo  ";
					$consulta = $consulta."INNER JOIN evaluador y ON a.rut_evaluador = y.rut_evaluador  ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."a.numero_evaluacion in (SELECT numero_evaluacion FROM detalle_evaluacion_quincenal b WHERE b.numero_quincenal in ( SELECT numero_quincenal FROM evaluacion_quincenal WHERE periodo = '".$periodo."'))  ";
					if($rut_ejecutivo != '*') {
						$consulta = $consulta."AND a.rut_ejecutivo = ".$rut_ejecutivo." ";
					}
					$consulta = $consulta."UNION ALL  ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."'final' as entrega, ";
					$consulta = $consulta."1 as tipo, ";
					$consulta = $consulta."z.numero_evaluacion, ";
					$consulta = $consulta."z.periodo, ";
					$consulta = $consulta."z.codigo_area, ";
					$consulta = $consulta."z.fecha_evaluacion, ";
					$consulta = $consulta."z.rut_ejecutivo, ";
					$consulta = $consulta."x.nombre_ejecutivo, ";
					$consulta = $consulta."z.rut_evaluador, ";
					$consulta = $consulta."y.nombre_evaluador, ";
					$consulta = $consulta."z.nota_final, ";
					$consulta = $consulta."z.orden, ";
					$consulta = $consulta."z.estado  ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_parcial z  ";
					$consulta = $consulta."INNER JOIN ejecutivo x ON z.rut_ejecutivo = x.rut_ejecutivo  ";
					$consulta = $consulta."INNER JOIN evaluador y ON z.rut_evaluador = y.rut_evaluador  ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."z.numero_evaluacion in (SELECT numero_evaluacion FROM detalle_evaluacion_final WHERE numero_final IN (SELECT numero_final FROM evaluacion_final WHERE periodo = '".$periodo."' AND codigo_area = ".$codigo_area." ) AND numero_evaluacion NOT IN (SELECT numero_evaluacion FROM detalle_evaluacion_quincenal b WHERE b.numero_quincenal in ( SELECT numero_quincenal FROM evaluacion_quincenal WHERE periodo = '".$periodo."' AND codigo_area = ".$codigo_area." )))  ";
					$consulta = $consulta."AND z.codigo_area = ".$codigo_area."  ";
					if($rut_ejecutivo != '*') {
						$consulta = $consulta."AND z.rut_ejecutivo = ".$rut_ejecutivo." ";
					}
					$consulta = $consulta."UNION ALL  ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."'final' as entrega, ";
					$consulta = $consulta."3 as tipo, ";
					$consulta = $consulta."z.numero_final as numero_evaluacion, ";
					$consulta = $consulta."z.periodo, ";
					$consulta = $consulta."z.codigo_area, ";
					$consulta = $consulta."z.fecha_creacion as fecha_evaluacion, ";
					$consulta = $consulta."z.rut_ejecutivo, ";
					$consulta = $consulta."x.nombre_ejecutivo, ";
					$consulta = $consulta."z.rut_evaluador, ";
					$consulta = $consulta."y.nombre_evaluador, ";
					$consulta = $consulta."z.nota_final, ";
					$consulta = $consulta."-1 as orden, ";
					$consulta = $consulta."z.estado  ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_final z  ";
					$consulta = $consulta."INNER JOIN ejecutivo x ON z.rut_ejecutivo = x.rut_ejecutivo  ";
					$consulta = $consulta."INNER JOIN evaluador y ON z.rut_evaluador = y.rut_evaluador  ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."periodo = '".$periodo."'  ";
					$consulta = $consulta."AND z.codigo_area = ".$codigo_area." ";
					if($rut_ejecutivo != '*') {
						$consulta = $consulta."AND z.rut_ejecutivo = ".$rut_ejecutivo." ";
					}
					$consulta = $consulta."UNION ALL ";
					$consulta = $consulta."SELECT  ";
					$consulta = $consulta."'--' as entrega, ";
					$consulta = $consulta."1 as tipo, ";
					$consulta = $consulta."a.numero_evaluacion, ";
					$consulta = $consulta."a.periodo, ";
					$consulta = $consulta."a.codigo_area, ";
					$consulta = $consulta."a.fecha_evaluacion, ";
					$consulta = $consulta."a.rut_ejecutivo, ";
					$consulta = $consulta."x.nombre_ejecutivo, ";
					$consulta = $consulta."a.rut_evaluador, ";
					$consulta = $consulta."y.nombre_evaluador, ";
					$consulta = $consulta."a.nota_final, ";
					$consulta = $consulta."a.orden, ";
					$consulta = $consulta."a.estado  ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_parcial a  ";
					$consulta = $consulta."INNER JOIN ejecutivo x ON a.rut_ejecutivo = x.rut_ejecutivo  ";
					$consulta = $consulta."INNER JOIN evaluador y ON a.rut_evaluador = y.rut_evaluador  ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."a.periodo = '".$periodo."' ";
					$consulta = $consulta."AND a.codigo_area = ".$codigo_area." ";
					if($rut_ejecutivo != '*') {
						$consulta = $consulta."AND a.rut_ejecutivo = ".$rut_ejecutivo." ";
					}
					$consulta = $consulta."AND a.numero_evaluacion not in (SELECT b.numero_evaluacion FROM evaluacion_quincenal a INNER JOIN detalle_evaluacion_quincenal b ON a.numero_quincenal = b.numero_quincenal WHERE periodo = '".$periodo."' AND codigo_area = ".$codigo_area.") ";
					$consulta = $consulta."AND a.numero_evaluacion not in (SELECT b.numero_evaluacion FROM evaluacion_final a INNER JOIN detalle_evaluacion_final b ON a.numero_final = b.numero_final WHERE periodo = '".$periodo."' AND codigo_area = ".$codigo_area.") ";
					$consulta = $consulta.")xx WHERE codigo_area = ".$codigo_area."  ";
					if($estado != '*') {
						if($estado == 5) {
							$consulta = $consulta."AND estado in (1,4,5)  ";	
						}else{
							$consulta = $consulta."AND estado = ".$estado."  ";	
						}
					}
					$consulta = $consulta."ORDER BY  ";
					$consulta = $consulta."nombre_ejecutivo ASC, ";
					$consulta = $consulta."orden ASC ";
				}
				//ejecutando la consulta
				//echo $consulta;
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						$array = null;
						$i 	   = 0;
						while($registro = $this->databaseTransaction->resultados()) {
							$array[$i] = $registro;
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "Controller Area - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		
		}


		public function historialEvaluacion($numero_evaluacion, $tipo) {
			if($numero_evaluacion == '') {
				return null;
			}else{
				if($tipo == '') {
					return null;
				}else{
					switch ($tipo) {
						case 1:
							try {
								$consulta = 'SELECT  ';
								$consulta = $consulta.'1 as tipo_evaluacion, ';
								$consulta = $consulta.'a.numero_evaluacion as evaluacion, ';
								$consulta = $consulta.'DATE_FORMAT(a.fecha_evaluacion, "%d-%m-%y") as fecha, ';
								$consulta = $consulta.'c.nombre as status, ';
								$consulta = $consulta.'b.nombre_evaluador as nombre_autorizador, ';
								$consulta = $consulta."'SYSTEM: Versión Inicial de la Evaluación' as detalle ";
								$consulta = $consulta.'FROM  ';
								$consulta = $consulta.'evaluacion_parcial a ';
								$consulta = $consulta.'INNER JOIN evaluador b ON a.rut_evaluador = b.rut_evaluador ';
								$consulta = $consulta.'INNER JOIN rev_evaluacion_tipo_estado c ON c.id = 1 ';
								$consulta = $consulta.'WHERE  ';
								$consulta = $consulta.'numero_evaluacion = '.$numero_evaluacion.' ';
								$consulta = $consulta.'UNION ALL ';
								$consulta = $consulta.'(SELECT  ';
								$consulta = $consulta.'1 as tipo_evaluacion, ';
								$consulta = $consulta.'a.numero_evaluacion, ';
								$consulta = $consulta.'DATE_FORMAT(a.fecha, "%d-%m-%y") as fecha, ';
								$consulta = $consulta.'c.nombre as status, ';
								$consulta = $consulta.'CASE ';
								$consulta = $consulta.'WHEN a.estado <> 9 THEN  ';
								$consulta = $consulta.'(SELECT nombre_evaluador FROM evaluador WHERE a.usuario = rut_evaluador) ';
								$consulta = $consulta.'ELSE ';
								$consulta = $consulta.'(SELECT nombre_ejecutivo FROM ejecutivo WHERE a.usuario = rut_ejecutivo) ';
								$consulta = $consulta.'END as nombre_autorizador, ';
								$consulta = $consulta.'a.observacion ';
								$consulta = $consulta.'FROM  ';
								$consulta = $consulta.'rev_evaluacion_status a  ';
								$consulta = $consulta.'INNER JOIN rev_evaluacion_tipo_estado c ON a.estado = c.id ';
								$consulta = $consulta.'WHERE  ';
								$consulta = $consulta.'numero_evaluacion = '.$numero_evaluacion.' ';
								$consulta = $consulta.'AND tipo = 1 ';
								$consulta = $consulta.'ORDER BY a.id ASC) ';
								//ejecutando la consulta
								if($this->databaseTransaction != null) {
									$resultado = $this->databaseTransaction->ejecutar($consulta);
									if($this->databaseTransaction->cantidadResultados() == 0) {
										$this->databaseTransaction->cerrar();
										return null;
									}else{
										$array = null;
										$i 	   = 0;
										while($registro = $this->databaseTransaction->resultados()) {
											$array[$i] = $registro;
											$i++;
										}
										$this->databaseTransaction->cerrar();
										return $array;
									}
								}else{
									if(ambiente == 'DEV') { echo "Controller Area - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
									return false;
								}
							}catch(Exception $e) {
								if(ambiente == 'DEV') { echo $e->getMessage(); }
								return false;
							}
						break;
						
						case 2:
							try {
								$consulta = 'SELECT ';
								$consulta = $consulta.'2 as tipo_evaluacion, ';
								$consulta = $consulta.'a.numero_quincenal as evaluacion, ';
								$consulta = $consulta.'DATE_FORMAT(a.fecha_creacion, "%d-%m-%y") as fecha, ';
								$consulta = $consulta.'c.nombre as status, ';
								$consulta = $consulta.'b.nombre_evaluador as nombre_autorizador, ';
								$consulta = $consulta."'SYSTEM: Versión Inicial de la Evaluación Quincenal' as detalle ";
								$consulta = $consulta.'FROM  ';
								$consulta = $consulta.'evaluacion_quincenal a ';
								$consulta = $consulta.'INNER JOIN evaluador b ON a.rut_evaluador = b.rut_evaluador ';
								$consulta = $consulta.'INNER JOIN rev_evaluacion_tipo_estado c ON c.id = 1 ';
								$consulta = $consulta.'WHERE  ';
								$consulta = $consulta.'numero_quincenal = '.$numero_evaluacion.' ';
								$consulta = $consulta.'UNION ALL ';
								$consulta = $consulta.'(SELECT  ';
								$consulta = $consulta.'2 as tipo_evaluacion, ';
								$consulta = $consulta.'a.numero_evaluacion, ';
								$consulta = $consulta.'DATE_FORMAT(a.fecha, "%d-%m-%y") as fecha, ';
								$consulta = $consulta.'c.nombre as status, ';
								$consulta = $consulta.'CASE ';
								$consulta = $consulta.'WHEN a.estado <> 9 THEN  ';
								$consulta = $consulta.'(SELECT nombre_evaluador FROM evaluador WHERE a.usuario = rut_evaluador) ';
								$consulta = $consulta.'ELSE ';
								$consulta = $consulta.'(SELECT nombre_ejecutivo FROM ejecutivo WHERE a.usuario = rut_ejecutivo) ';
								$consulta = $consulta.'END as nombre_autorizador, ';
								$consulta = $consulta.'a.observacion ';
								$consulta = $consulta.'FROM  ';
								$consulta = $consulta.'rev_evaluacion_status a  ';
								$consulta = $consulta.'INNER JOIN rev_evaluacion_tipo_estado c ON a.estado = c.id ';
								$consulta = $consulta.'WHERE  ';
								$consulta = $consulta.'numero_evaluacion = '.$numero_evaluacion.' ';
								$consulta = $consulta.'AND tipo = 2 ';
								$consulta = $consulta.'ORDER BY a.id ASC) ';
								//ejecutando la consulta
								if($this->databaseTransaction != null) {
									$resultado = $this->databaseTransaction->ejecutar($consulta);
									if($this->databaseTransaction->cantidadResultados() == 0) {
										$this->databaseTransaction->cerrar();
										return null;
									}else{
										$array = null;
										$i 	   = 0;
										while($registro = $this->databaseTransaction->resultados()) {
											$array[$i] = $registro;
											$i++;
										}
										$this->databaseTransaction->cerrar();
										return $array;
									}
								}else{
									if(ambiente == 'DEV') { echo "Controller Area - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
									return false;
								}
							}catch(Exception $e) {
								if(ambiente == 'DEV') { echo $e->getMessage(); }
								return false;
							}
						break;

						case 3:
							try {
								$consulta = 'SELECT  ';
								$consulta = $consulta.'3 as tipo_evaluacion,  ';
								$consulta = $consulta.'a.numero_final as evaluacion,  ';
								$consulta = $consulta.'DATE_FORMAT(a.fecha_creacion, "%d-%m-%y") as fecha,  ';
								$consulta = $consulta.'c.nombre as status,  ';
								$consulta = $consulta.'b.nombre_evaluador as nombre_autorizador,  ';
								$consulta = $consulta."'SYSTEM: Versión Inicial de la Evaluación Final' as detalle  ";
								$consulta = $consulta.'FROM   ';
								$consulta = $consulta.'evaluacion_final a  ';
								$consulta = $consulta.'INNER JOIN evaluador b ON a.rut_evaluador = b.rut_evaluador  ';
								$consulta = $consulta.'INNER JOIN rev_evaluacion_tipo_estado c ON c.id = 1  ';
								$consulta = $consulta.'WHERE   ';
								$consulta = $consulta.'numero_final = '.$numero_evaluacion.'  ';
								$consulta = $consulta.'UNION ALL  ';
								$consulta = $consulta.'(SELECT   ';
								$consulta = $consulta.'3 as tipo_evaluacion,  ';
								$consulta = $consulta.'a.numero_evaluacion,  ';
								$consulta = $consulta.'DATE_FORMAT(a.fecha, "%d-%m-%y") as fecha,  ';
								$consulta = $consulta.'c.nombre as status,  ';
								$consulta = $consulta.'CASE  ';
								$consulta = $consulta.'WHEN a.estado <> 9 THEN   ';
								$consulta = $consulta.'(SELECT nombre_evaluador FROM evaluador WHERE a.usuario = rut_evaluador)  ';
								$consulta = $consulta.'ELSE  ';
								$consulta = $consulta.'(SELECT nombre_ejecutivo FROM ejecutivo WHERE a.usuario = rut_ejecutivo)  ';
								$consulta = $consulta.'END as nombre_autorizador,  ';
								$consulta = $consulta.'a.observacion  ';
								$consulta = $consulta.'FROM   ';
								$consulta = $consulta.'rev_evaluacion_status a   ';
								$consulta = $consulta.'INNER JOIN rev_evaluacion_tipo_estado c ON a.estado = c.id  ';
								$consulta = $consulta.'WHERE   ';
								$consulta = $consulta.'numero_evaluacion = '.$numero_evaluacion.'  ';
								$consulta = $consulta.'AND tipo = 3  ';
								$consulta = $consulta.'ORDER BY a.id ASC)  ';
								//ejecutando la consulta
								if($this->databaseTransaction != null) {
									$resultado = $this->databaseTransaction->ejecutar($consulta);
									if($this->databaseTransaction->cantidadResultados() == 0) {
										$this->databaseTransaction->cerrar();
										return null;
									}else{
										$array = null;
										$i 	   = 0;
										while($registro = $this->databaseTransaction->resultados()) {
											$array[$i] = $registro;
											$i++;
										}
										$this->databaseTransaction->cerrar();
										return $array;
									}
								}else{
									if(ambiente == 'DEV') { echo "Controller Area - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
									return false;
								}
							}catch(Exception $e) {
								if(ambiente == 'DEV') { echo $e->getMessage(); }
								return false;
							}
						break;

						default:
							return null;
						break;
					}
				}
			}
		}

		public function evaluacionesApeladas() {
			try {
				$consulta = "SELECT 1 as tipo, a.numero_evaluacion as evaluacion, date_format(a.fecha_evaluacion, '%d-%m-%y') as fecha, a.periodo, a.rut_ejecutivo, b.nombre_ejecutivo ";
				$consulta = $consulta."FROM "; 
				$consulta = $consulta."evaluacion_parcial a  ";
				$consulta = $consulta."INNER JOIN ejecutivo b ON a.rut_ejecutivo = b.rut_ejecutivo ";
				$consulta = $consulta."WHERE a.estado = 6 ";
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta."SELECT 2 as tipo, a.numero_quincenal as evaluacion, date_format(a.fecha_creacion, '%d-%m-%y') as fecha, a.periodo, a.rut_ejecutivo, b.nombre_ejecutivo ";
				$consulta = $consulta."FROM  ";
				$consulta = $consulta."evaluacion_quincenal a  ";
				$consulta = $consulta."INNER JOIN ejecutivo b ON a.rut_ejecutivo = b.rut_ejecutivo ";
				$consulta = $consulta."WHERE a.estado = 6 ";
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta."SELECT 3 as tipo, a.numero_final as evaluacion, date_format(a.fecha_creacion, '%d-%m-%y') as fecha, a.periodo, a.rut_ejecutivo, b.nombre_ejecutivo ";
				$consulta = $consulta."FROM  ";
				$consulta = $consulta."evaluacion_final a  ";
				$consulta = $consulta."INNER JOIN ejecutivo b ON a.rut_ejecutivo = b.rut_ejecutivo ";
				$consulta = $consulta."WHERE a.estado = 6 ";
				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						$array = null;
						$i 	   = 0;
						while($registro = $this->databaseTransaction->resultados()) {
							$array[$i] = $registro;
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "Controller Area - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function evaluacionesNotificadasSupervisor($param) {
			try {
				$consulta = "SELECT 1 as tipo, a.numero_evaluacion as evaluacion, date_format(a.fecha_evaluacion, '%d-%m-%y') as fecha, a.periodo, a.rut_ejecutivo, b.nombre_ejecutivo ";
				$consulta = $consulta."FROM "; 
				$consulta = $consulta."evaluacion_parcial a  ";
				$consulta = $consulta."INNER JOIN ejecutivo b ON a.rut_ejecutivo = b.rut_ejecutivo ";
				$consulta = $consulta."WHERE a.estado = 8 ";
				if($param != 0) {
					$consulta = $consulta."AND a.codigo_area = ".$param." ";
				}
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta."SELECT 2 as tipo, a.numero_quincenal as evaluacion, date_format(a.fecha_creacion, '%d-%m-%y') as fecha, a.periodo, a.rut_ejecutivo, b.nombre_ejecutivo ";
				$consulta = $consulta."FROM  ";
				$consulta = $consulta."evaluacion_quincenal a  ";
				$consulta = $consulta."INNER JOIN ejecutivo b ON a.rut_ejecutivo = b.rut_ejecutivo ";
				$consulta = $consulta."WHERE a.estado = 8 ";
				if($param != 0) {
					$consulta = $consulta."AND a.codigo_area = ".$param." ";
				}
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta."SELECT 3 as tipo, a.numero_final as evaluacion, date_format(a.fecha_creacion, '%d-%m-%y') as fecha, a.periodo, a.rut_ejecutivo, b.nombre_ejecutivo ";
				$consulta = $consulta."FROM  ";
				$consulta = $consulta."evaluacion_final a  ";
				$consulta = $consulta."INNER JOIN ejecutivo b ON a.rut_ejecutivo = b.rut_ejecutivo ";
				$consulta = $consulta."WHERE a.estado = 8 ";
				if($param != 0) {
					$consulta = $consulta."AND a.codigo_area = ".$param." ";
				}
				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						$array = null;
						$i 	   = 0;
						while($registro = $this->databaseTransaction->resultados()) {
							$array[$i] = $registro;
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "Controller Area - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function estadisticas($periodo, $area) {
			try {
				$consulta = "SELECT  ";
				$consulta = $consulta."item,  ";
				$consulta = $consulta."SUM(cantidad) total  ";
				$consulta = $consulta."FROM (  ";
				$consulta = $consulta."SELECT 'En Proceso' as item, count(*) cantidad FROM evaluacion_parcial WHERE estado = 1 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL   ";
				$consulta = $consulta."SELECT 'En Proceso' as item, count(*) cantidad FROM evaluacion_quincenal WHERE estado = 1 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."SELECT 'En Proceso' as item, count(*) cantidad FROM evaluacion_final WHERE estado = 1 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."  ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."  ";
				$consulta = $consulta."SELECT 'En Revisión' as item, count(*) cantidad FROM evaluacion_parcial WHERE estado = 2 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL   ";
				$consulta = $consulta."SELECT 'En Revisión' as item, count(*) cantidad FROM evaluacion_quincenal WHERE estado = 2 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."SELECT 'En Revisión' as item, count(*) cantidad FROM evaluacion_final WHERE estado = 2 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."  ";
				$consulta = $consulta."UNION ALL   ";
				$consulta = $consulta."  ";
				$consulta = $consulta."SELECT 'Corregida' as item, count(*) cantidad FROM evaluacion_parcial WHERE estado = 4 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL   ";
				$consulta = $consulta."SELECT 'Corregida' as item, count(*) cantidad FROM evaluacion_quincenal WHERE estado = 4 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."SELECT 'Corregida' as item, count(*) cantidad FROM evaluacion_final WHERE estado = 4 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."  ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."  ";
				$consulta = $consulta."SELECT 'Apelada' as item, count(*) cantidad FROM evaluacion_parcial WHERE estado = 6 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL   ";
				$consulta = $consulta."SELECT 'Apelada' as item, count(*) cantidad FROM evaluacion_quincenal WHERE estado = 6 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."SELECT 'Apelada' as item, count(*) cantidad FROM evaluacion_final WHERE estado = 6 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."  ";
				$consulta = $consulta."UNION ALL   ";
				$consulta = $consulta."  ";
				$consulta = $consulta."SELECT 'Apelación Aprobada' as item, count(*) cantidad FROM evaluacion_parcial WHERE estado = 7 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL   ";
				$consulta = $consulta."SELECT 'Apelación Aprobada' as item, count(*) cantidad FROM evaluacion_quincenal WHERE estado = 7 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."SELECT 'Apelación Aprobada' as item, count(*) cantidad FROM evaluacion_final WHERE estado = 7 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."  ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."  ";
				$consulta = $consulta."SELECT 'Apelación Rechazada' as item, count(*) cantidad FROM evaluacion_parcial WHERE estado = 8 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL   ";
				$consulta = $consulta."SELECT 'Apelación Rechazada' as item, count(*) cantidad FROM evaluacion_quincenal WHERE estado = 8 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."SELECT 'Apelación Rechazada' as item, count(*) cantidad FROM evaluacion_final WHERE estado = 8 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."  ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."  ";
				$consulta = $consulta."SELECT 'Cerradas' as item, count(*) cantidad FROM evaluacion_parcial WHERE estado = 9 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL   ";
				$consulta = $consulta."SELECT 'Cerradas' as item, count(*) cantidad FROM evaluacion_quincenal WHERE estado = 9 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."SELECT 'Cerradas' as item, count(*) cantidad FROM evaluacion_final WHERE estado = 9 and periodo = '".$periodo."' and codigo_area = ".$area."  ";
				$consulta = $consulta.")xx  ";
				$consulta = $consulta."GROUP BY   ";
				$consulta = $consulta."item  ";
				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						$array = null;
						$i 	   = 0;
						while($registro = $this->databaseTransaction->resultados()) {
							$array[$i] = $registro;
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "Controller Area - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


		public function estadisticasSupervisor($periodo, $area) {
			try {
				$consulta = "SELECT ";
				$consulta = $consulta."'ejecutivos' as item, count(DISTINCT rut_ejecutivo) as cantidad ";
				$consulta = $consulta."FROM ( ";
				$consulta = $consulta."SELECT rut_ejecutivo FROM evaluacion_parcial WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado not in (9) GROUP BY rut_ejecutivo ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."SELECT rut_ejecutivo FROM evaluacion_quincenal WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado not in (9) GROUP BY rut_ejecutivo ";
				$consulta = $consulta."UNION ALL  ";
				$consulta = $consulta."SELECT rut_ejecutivo FROM evaluacion_final WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado not in (9) GROUP BY rut_ejecutivo ";
				$consulta = $consulta.")xx ";
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta."  ";
				$consulta = $consulta."SELECT  ";
				$consulta = $consulta."'disponibles' as identificador, count(numero) ";
				$consulta = $consulta."FROM ( ";
				$consulta = $consulta."SELECT numero_evaluacion as numero FROM evaluacion_parcial WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado in (1,4,5)  ";
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta."SELECT numero_quincenal as numero FROM evaluacion_quincenal WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado in (1,4,5) ";
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta."SELECT numero_final as numero FROM evaluacion_final WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado in (1,4,5) ";
				$consulta = $consulta.")xx ";
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta." ";
				$consulta = $consulta."SELECT  ";
				$consulta = $consulta."'aceptadas' as identificador, count(numero) ";
				$consulta = $consulta."FROM ( ";
				$consulta = $consulta."SELECT numero_evaluacion as numero FROM evaluacion_parcial WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado in (7)  ";
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta."SELECT numero_quincenal as numero FROM evaluacion_quincenal WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado in (7) ";
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta."SELECT numero_final as numero FROM evaluacion_final WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado in (7) ";
				$consulta = $consulta.")xx ";
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta." ";
				$consulta = $consulta."SELECT  ";
				$consulta = $consulta."'terminadas' as identificador, count(numero) ";
				$consulta = $consulta."FROM ( ";
				$consulta = $consulta."SELECT numero_evaluacion as numero FROM evaluacion_parcial WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado in (8)  ";
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta."SELECT numero_quincenal as numero FROM evaluacion_quincenal WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado in (8) ";
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta."SELECT numero_final as numero FROM evaluacion_final WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado in (8) ";
				$consulta = $consulta.")xx ";
				$consulta = $consulta."UNION ALL ";
				$consulta = $consulta." ";
				$consulta = $consulta."SELECT 'cerradas' as identificador, COALESCE(CAST(((sum(cerradas)/sum(total))*100) as decimal(12,2)), 0) porcentaje FROM ( SELECT count(*) cerradas, 0 as total FROM evaluacion_parcial WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado in (9) UNION ALL SELECT 0 cerradas, count(*) as total FROM evaluacion_parcial WHERE codigo_area = ".$area." AND periodo = '".$periodo."' UNION ALL SELECT count(*) as cerradas, 0 as total FROM evaluacion_quincenal WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado in (9) UNION ALL SELECT 0 as cerradas, count(*) as total FROM evaluacion_quincenal WHERE codigo_area = ".$area." AND periodo = '".$periodo."' UNION ALL SELECT count(*) as cerradas, 0 as total FROM evaluacion_final WHERE codigo_area = ".$area." AND periodo = '".$periodo."' AND estado in (9) UNION ALL SELECT 0 as cerradas, count(*) as total FROM evaluacion_final WHERE codigo_area = ".$area." AND periodo = '".$periodo."' )xx ";
				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						$array = null;
						$i 	   = 0;
						while($registro = $this->databaseTransaction->resultados()) {
							$array[$i] = $registro;
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "Controller Area - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

	}
?>