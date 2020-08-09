<?php
	//Controlador OK: 09.04.2020
	include(dirModel."Evaluador.php");
	class EvaluadorController {

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
				$consulta = 'SELECT * FROM evaluador WHERE estado = 1 AND supervisor not in (1) AND cobranza not in (1) ORDER BY nombre_evaluador ASC';
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
							$array[$i] = new Evaluador($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluadorController - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorRut($rut) {
			try {
				$consulta = "SELECT * FROM evaluador WHERE rut_Evaluador = '".$rut."'";
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
							$array[$i] = new Evaluador($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluadorController - listarPorRut: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorUsuario($usuario) {
			try {
				$consulta = "SELECT * FROM evaluador WHERE usuario = '".$usuario."' AND (admin = 1 OR supervisor = 1) AND estado = 1";
				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						switch ($this->databaseTransaction->cantidadResultados()) {
							case 1:
								return new Evaluador($this->databaseTransaction->resultados());
							break;
							
							default:
								$array = null;
								$i 	   = 0;
								while($registro = $this->databaseTransaction->resultados()) {
									$array[$i] = new Evaluador($registro);
									$i++;
								}
								$this->databaseTransaction->cerrar();
								return $array;
							break;
						}
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluadorController - listarPorUsuario: El objeto DatabaseTransaction se encuentra nulo"; }
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
					$consulta = "INSERT INTO evaluador ";
					$consulta = $consulta."(rut_evaluador, nombre_evaluador, usuario, contrasena, fecha_creacion, estado, admin) VALUES ";
					$consulta = $consulta."(".$obj->getrut_evaluador().", '".$obj->getnombre_evaluador()."', '".$obj->getusuario()."', '".$obj->getcontrasena()."', '".date('Y-m-d H:i:s')."', ".$obj->getestado().", ".$obj->getAdmin()." );";
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
						if(ambiente == 'DEV') { echo "EvaluadorController - ingresar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluadorController - ingresar: El objeto Adjunto (Model) se encuentra nulo"; }
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
					$consulta = "UPDATE evaluador ";
					$consulta = $consulta."SET nombre_evaluador= '".$obj->getnombre_evaluador()."', usuario = '".$obj->getusuario()."', contrasena = '".$obj->getcontrasena."', estado = ".$obj->getestado().", admin = ".$obj->getAdmin()."  ";
					$consulta = $consulta."WHERE rut_evaluador = ".$obj->getrut_evaluador().";";
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
						if(ambiente == 'DEV') { echo "EvaluadorController - actualizar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluadorController - actualizar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function eliminar($param) {
			try {
				//objeto
				$obj = $param;
				if($obj != null) {
					//construyendo string
					$consulta = "DELETE FROM evaluador ";
					$consulta = $consulta."WHERE rut_evaluador = ".$obj->getrut_evaluador().";";
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
						if(ambiente == 'DEV') { echo "EvaluadorController - eliminar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluadorController - eliminar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


		public function estadisticas($evaluador) {
			try {
				$consulta	= 'SELECT '; 
				$consulta	= $consulta.'a.nombre_area, ';
				$consulta 	= $consulta."(SELECT count(*) FROM evaluacion_parcial aa WHERE aa.codigo_area = a.codigo_area AND aa.rut_evaluador = ".$evaluador." AND aa.periodo = '".$_SESSION['current_periodo_work']."') as parciales, ";
				$consulta 	= $consulta."(SELECT count(*) FROM evaluacion_quincenal bb WHERE bb.codigo_area = a.codigo_area AND bb.rut_evaluador = ".$evaluador." AND bb.periodo = '".$_SESSION['current_periodo_work']."') as quincenales, ";
				$consulta 	= $consulta."(SELECT count(*) FROM evaluacion_final cc WHERE cc.codigo_area = a.codigo_area AND cc.rut_evaluador = ".$evaluador." AND cc.periodo = '".$_SESSION['current_periodo_work']."') as finales ";
				$consulta 	= $consulta."FROM area a";

				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						switch ($this->databaseTransaction->cantidadResultados()) {
							case 1:
								return $this->databaseTransaction->resultados();
							break;
							
							default:
								$array = null;
								$i 	   = 0;
								while($registro = $this->databaseTransaction->resultados()) {
									$array[$i] = $registro;
									$i++;
								}
								$this->databaseTransaction->cerrar();
								return $array;
							break;
						}
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluadorController - estadisticas: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}

		}

	}
?>