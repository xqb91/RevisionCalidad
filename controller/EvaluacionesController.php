<?php
	class EvaluacionesController {

		private $databaseTransaction;

		//constructor del controlador de Area
		public function __construct() {
			$this->databaseTransaction = new DatabaseTransaction();
		}

		//devuelve el objeto inicializado por el controlador de DatabaseTransaction (Conexion contra la base de datos)
		public function getDatabaseTransaction() {
			return $this->databaseTransaction;
		}





		public function getEnProceso() {
			try {
				$consulta = "SELECT * FROM evaluacion_parcial WHERE estado in (1) and numero_evaluacion not in (SELECT a.numero_evaluacion FROM detalle_evaluacion_final a INNER JOIN evaluacion_final b ON a.numero_final = b.numero_final WHERE b.periodo = '2020-07' AND b.codigo_area = 1)";
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


		public function getEjecutivosDisponibles() {
			try {
				$consulta = "SELECT xx.rut_ejecutivo, b.nombre_ejecutivo, b.codigo_ciclo, c.nombre_ciclo,  b.codigo_jornada, d.nombre_jornada, b.codigo_area, e.nombre_area, max(indicador) as indicador, count(*) as cantidad FROM ";
				$consulta = $consulta." ( SELECT rut_ejecutivo, CASE WHEN estado = 1 THEN 0 WHEN estado = 4 THEN 0 WHEN estado = 2 THEN 2 ELSE 5 END as indicador FROM evaluacion_parcial WHERE numero_evaluacion IN  (SELECT ";
				$consulta = $consulta." b.numero_evaluacion FROM evaluacion_final a INNER JOIN detalle_evaluacion_final b ON a.numero_final = b.numero_final WHERE periodo = '2020-07' and codigo_area = 1)) xx ";
				$consulta = $consulta." INNER JOIN ejecutivo b ON xx.rut_ejecutivo = b.rut_ejecutivo ";
				$consulta = $consulta." INNER JOIN ciclo c ON b.codigo_ciclo = c.codigo_ciclo ";
				$consulta = $consulta." INNER JOIN jornada d ON b.codigo_jornada = d.codigo_jornada ";
				$consulta = $consulta." INNER JOIN area e ON b.codigo_area = e.codigo_area ";
				$consulta = $consulta." GROUP BY xx.rut_ejecutivo";
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