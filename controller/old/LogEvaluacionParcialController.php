<?php
	//include("../config/Globales.php");
	include(dirModel."LogEvaluacionParcial.php");
	class LogEvaluacionParcialController {

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
		public function listar() {
			try {
				$consulta = 'SELECT * FROM log_evaluacion_parcial ORDER BY fecha ASC';
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
							$array[$i] = new LogEvaluacionParcial($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "LogEvaluacionParcialController - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorCodigo($codigo) {
			try {
				$consulta = "SELECT * FROM log_evaluacion_parcial WHERE id = '".$codigo."'";
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
							$array[$i] = new LogEvaluacionParcial($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "LogEvaluacionParcialController - listarPorCodigo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}
		public function ingresar($LogEvaluacionParcial) {
			try {
				//objeto
				$obj = $LogEvaluacionParcial;
				if($obj != null) {
					//construyendo string
					$consulta = "INSERT INTO log_evaluacion_parcial ";
					$consulta = $consulta."(fecha, usuario, numero_evaluacion, fecha_evaluacion,rut_ejecutivo,rut_evaluador,nota_final,observacion,codigo_area) VALUES ";
					
					$consulta = $consulta."('".date('Y-m-d H:i:s')."','"
					        .$obj->getusuario()."', ".$obj->getnumero_evaluacion().",'".$obj->getfecha_evaluacion()."',".$obj->getrut_ejecutivo().", ".$obj->getrut_evaluador().", ".$obj->getnota_final().",'".$obj->getobservacion()."', ".$obj->getcodigo_area()." );";
					//ejecutando la consulta
					if($this->databaseTransaction != null) {
						$resultado = $this->databaseTransaction->ejecutar($consulta);
						if($resultado == true) {
							$this->databaseTransaction->confirmar();
							$this->databaseTransaction->cerrar();
							return 1;
						}else{
							$this->databaseTransaction->deshacer();
							$this->databaseTransaction->cerrar();
							return 0;
						}
					}else{
						if(ambiente == 'DEV') { echo "LogEvaluacionParcialController - ingresar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "LogEvaluacionParcialController - ingresar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}



	}
?>