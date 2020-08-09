<?php
	//Controlador OK: 09.04.2020
	include(dirModel."Adjuntos.php");
	class AdjuntosController {

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
				$consulta = 'SELECT * FROM Adjuntos ORDER BY codigo_adjunto ASC';
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
							$array[$i] = new Adjuntos($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "AdjuntosController - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorNumeroEvaluacion($evaluacion) {
			try {
				$consulta = 'SELECT * FROM Adjuntos WHERE numero_evaluacion = '.$evaluacion.'  ORDER BY numero_evaluacion ASC';
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
							$array[$i] = new Adjuntos($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "AdjuntosController - listarPorNumeroEvaluacion: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPeriodo($periodo) {
			try {
				$consulta = "SELECT * FROM Adjuntos WHERE periodo = '".$periodo."'";
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
							$array[$i] = new Adjuntos($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "AdjuntosController - listarPeriodo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorArchivoServer($archivo) {
			try {
				$consulta = "SELECT * FROM Adjuntos WHERE archivo_server = '".$archivo."'";
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
							$array[$i] = new Adjuntos($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "AdjuntosController - listarPorArchivoServer: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function ingresar($Adjunto) {
			try {
				//objeto
				$obj = $Adjunto;
				if($obj != null) {
					//construyendo string
					$consulta = "INSERT INTO Adjuntos ";
					$consulta = $consulta."(numero_evaluacion, fecha_carga, periodo, nombre_original, archivo_server) VALUES ";
					$consulta = $consulta."(".$obj->getnumero_evaluacion().", '".$obj->getfecha_carga()."', '".$obj->getperiodo()."', '".$obj->getnombre_original()."', '".$obj->getarchivo_server()."');";
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
						if(ambiente == 'DEV') { echo "AdjuntosController - ingresar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "AdjuntosController - ingresar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


		public function actualizar($Adjunto) {
			try {
				//objeto
				$obj = $Adjunto;
				if($obj != null) {
					//construyendo string
					$consulta = "UPDATE adjuntos ";
					$consulta = $consulta."SET  numero_evaluacion = ".$obj->getnumero_evaluacion().", fecha_carga = '".$obj->getfecha_carga()."', periodo = '".$obj->getperiodo()."', ";
					$consulta = $consulta."nombre_original = '".$obj->getnombre_original()."', archivo_server = '".$obj->getarchivo_server()."' WHERE codigo_adjunto = ".$obj->getcodigo_adjunto()." ";
					//ejecutando la consulta
					if($this->databaseTransaction != null) {
						$resultado = $this->databaseTransaction->ejecutar($consulta);
						if($resultados == true) {
							$this->databaseTransaction->confirmar();
							$this->databaseTransaction->cerrar();
							return 1;
						}else{
							$this->databaseTransaction->deshacer();
							$this->databaseTransaction->cerrar();
							return 0;
						}
					}else{
						if(ambiente == 'DEV') { echo "AdjuntosController - actualizar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "AdjuntosController - actualizar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function eliminar($Adjunto) {
			try {
				//objeto
				$obj = $Adjunto;
				if($obj != null) {
					//construyendo string
					$consulta = "DELETE from adjuntos WHERE codigo_adjunto = ".$obj->getcodigo_adjunto()." ";
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
						if(ambiente == 'DEV') { echo "AdjuntosController - eliminar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "AdjuntosController - eliminar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

	}
?>