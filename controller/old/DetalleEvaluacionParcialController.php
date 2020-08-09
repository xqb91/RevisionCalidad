<?php
	//Controlador OK: 09.04.2020
	include(dirModel."DetalleEvaluacionParcial.php");
	class DetalleEvaluacionParcialController {

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
				$consulta = 'SELECT * FROM detalle_evaluacion_parcial ORDER BY numero_evaluacion DESC, id ASC';
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
							$array[$i] = new DetalleEvaluacionParcial($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "DetalleEvaluacionParcialController - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorNumeroItem($numero, $codigo_item) {
			try {
				$consulta = "SELECT * FROM detalle_evaluacion_parcial WHERE numero_Evaluacion = ".$numero." AND codigo_item = ".$codigo_item." ORDER BY numero_evaluacion DESC, id ASC";
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
							$array[$i] = new DetalleEvaluacionParcial($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "DetalleEvaluacionParcialController - listarPorNumeroItem: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorNumero($numero) {
			try {
				$consulta = "SELECT * FROM detalle_evaluacion_parcial WHERE numero_Evaluacion = ".$numero." ORDER BY numero_evaluacion DESC, codigo_item ASC";
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
							$array[$i] = new DetalleEvaluacionParcial($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "DetalleEvaluacionParcialController - listarPorNumeroItem: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function ingresar($param) {
			try {
				//objeto
				$obj = $param;
				if($obj != null) {
					//construyendo string
					$consulta = "INSERT INTO detalle_evaluacion_parcial ";
					$consulta = $consulta."(numero_evaluacion, codigo_item, nota) VALUES ";
					$consulta = $consulta."(".$obj->getnumero_evaluacion().", ".$obj->getcodigo_item().", ".$obj->getnota()." );";
					echo $consulta;
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
						if(ambiente == 'DEV') { echo "DetalleEvaluacionParcialController - ingresar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "DetalleEvaluacionParcialController - ingresar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function actualizar($param) {
			try {
				//objeto
				$obj = $param;
				if($obj != null) {
					//construyendo string
					$consulta = "UPDATE detalle_evaluacion_parcial ";
					$consulta = $consulta."SET nota = ".$obj->getnota()." ";
					$consulta = $consulta."WHERE numero_evaluacion = ".$obj->getnumero_evaluacion()." AND codigo_item = ".$obj->getcodigo_item().";";
					echo $consulta;
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
						if(ambiente == 'DEV') { echo "AudioController - actualizar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "AudioController - actualizar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


		public function eliminarPorItem($param) {
			try {
				//objeto
				$obj = $param;
				if($obj != null) {
					//construyendo string
					$consulta = "DELETE FROM detalle_evaluacion_parcial ";
					$consulta = $consulta."WHERE numero_evaluacion = ".$obj->getnumero_evaluacion()." AND codigo_item = ".$obj->getcodigo_item()."";
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
						if(ambiente == 'DEV') { echo "DetalleEvaluacionParcialController - eliminar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "DetalleEvaluacionParcialController - eliminar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function eliminarPorEvaluacion($param) {
			try {
				//objeto
				$obj = $param;
				if($obj != null) {
					//construyendo string
					$consulta = "DELETE FROM detalle_evaluacion_parcial ";
					$consulta = $consulta."WHERE numero_evaluacion = ".$obj->getnumero_evaluacion()." ";
					//ejecutando la consulta
					if($this->databaseTransaction != null) {
						$resultado = $this->databaseTransaction->ejecutar($consulta);
						if($resultado == true) {
							$this->databaseTransaction->confirmar();
							$this->databaseTransaction->cerrar();
							return true;
						}else{
							$this->databaseTransaction->deshacer();
							$this->databaseTransaction->cerrar();
							return false;
						}
					}else{
						if(ambiente == 'DEV') { echo "DetalleEvaluacionParcialController - eliminar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "DetalleEvaluacionParcialController - eliminar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


		public function existeDetalle($evaluacion, $item) {
			try {
				//objeto
				$obj = $evaluacion;
				if($obj != null) {
					//construyendo string
					$consulta = "SELECT count(*) as total FROM detalle_evaluacion_parcial WHERE numero_evaluacion = ".$evaluacion." AND codigo_item =  ".$item." ";
					//ejecutando la consulta
					if($this->databaseTransaction != null) {
						$resultado = $this->databaseTransaction->ejecutar($consulta);
						if($this->databaseTransaction->cantidadResultados() == 0) {
							$this->databaseTransaction->cerrar();
							return false;
						}else{
							if($this->databaseTransaction->resultados()["total"] == 0) {
								$this->databaseTransaction->cerrar();
								return false;
							}else{
								$this->databaseTransaction->cerrar();
								return true;
							}
						}
					}else{
						if(ambiente == 'DEV') { echo "DetalleEvaluacionParcialController - eliminar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "DetalleEvaluacionParcialController - eliminar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

	}
?>