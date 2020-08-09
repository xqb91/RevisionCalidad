<?php
	//Controlador OK: 09.04.2020
	include(dirModel."EvaluacionQuincenal.php");
	class EvaluacionQuincenalController {

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
				$consulta = 'SELECT * FROM evaluacion_quincenal';
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
							$array[$i] = new EvaluacionQuincenal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorNumero($numero) {
			try {
				$consulta = "SELECT * FROM evaluacion_quincenal WHERE numero_quincenal = '".$numero."'";
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
							$array[$i] = new EvaluacionQuincenal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - listarPorNumero: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorEjecutivo($ejecutivo, $periodo) {
			try {
				$consulta = "SELECT * FROM evaluacion_quincenal WHERE rut_ejecutivo = '".$ejecutivo."' AND periodo='".$periodo."' ";
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
							$array[$i] = new EvaluacionQuincenal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - listarPorEjecutivo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorEjecutivoPeriodo($ejecutivo, $periodo) {
			try {
				$consulta = "SELECT * FROM evaluacion_quincenal WHERE rut_ejecutivo = '".$ejecutivo."' and periodo = '".$periodo."'";
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
							$array[$i] = new EvaluacionQuincenal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - listarPorEjecutivoPeriodo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorEjecutivoPeriodoFecha($ejecutivo, $periodo, $fecha) {
			try {
				$consulta = "SELECT * FROM evaluacion_quincenal WHERE rut_ejecutivo = '".$ejecutivo."' and periodo = '".$periodo."' and fecha_creacion = '".$fecha."'";
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
							$array[$i] = new EvaluacionQuincenal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - listarPorEjecutivoPeriodoFecha: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorEvaluador($evaluador) {
			try {
				$consulta = "SELECT * FROM evaluacion_quincenal WHERE rut_evaluador = '".$evaluador."'";
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
							$array[$i] = new EvaluacionQuincenal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - listarPorEvaluador: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorEvaluadorPeriodo($evaluador, $periodo) {
			try {
				$consulta = "SELECT * FROM evaluacion_quincenal WHERE rut_evaluador = '".$evaluador."' and periodo = '".$periodo."'";
				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						return null;
					}else{
						$array = null;
						$i 	   = 0;
						while($registro = $this->databaseTransaction->resultados()) {
							$array[$i] = new EvaluacionQuincenal($registro);
							$i++;
						}
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - listarPorEvaluadorPeriodo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorEvaluadorPeriodoFecha($evaluador, $periodo, $fecha) {
			try {
				$consulta = "SELECT * FROM evaluacion_quincenal WHERE rut_evaluador = '".$evaluador."' and periodo = '".$periodo."' and fecha_creacion = '".$fecha."'";
				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						return null;
					}else{
						$array = null;
						$i 	   = 0;
						while($registro = $this->databaseTransaction->resultados()) {
							$array[$i] = new EvaluacionQuincenal($registro);
							$i++;
						}
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - listarPorEvaluadorPeriodoFecha: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorArea($area) {
			try {
				$consulta = "SELECT * FROM evaluacion_quincenal WHERE ejecutivo_codigo_area = '".$area."'";
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
							$array[$i] = new EvaluacionQuincenal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - listarPorArea: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorAreaPeriodo($area, $periodo) {
			try {
				$consulta = "SELECT * FROM evaluacion_quincenal WHERE ejecutivo_codigo_area = '".$area."' and periodo = '".$periodo."'";
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
							$array[$i] = new EvaluacionQuincenal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - listarPorAreaPeriodo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorAreaPeriodoFecha($area, $periodo, $fecha) {
			try {
				$consulta = "SELECT * FROM evaluacion_quincenal WHERE ejecutivo_codigo_area = '".$area."' and periodo = '".$periodo."' and fecha_creacion = '".$fecha."'";
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
							$array[$i] = new EvaluacionQuincenal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - listarPorAreaPeriodoFecha: El objeto DatabaseTransaction se encuentra nulo"; }
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
					$consulta = "INSERT INTO evaluacion_quincenal ";
					$consulta = $consulta."(rut_ejecutivo, fecha_creacion, rut_evaluador, periodo, codigo_area, nota_quincenal) VALUES ";
					$consulta = $consulta."(".$obj->getrut_ejecutivo().", '".date('Y-m-d H:i:s')."',  ".$obj->getrut_evaluador().", '".$obj->getperiodo()."', ".$obj->getejecutivo_codigo_area().", ".$obj->getnota_quincenal()." );";
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
						if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - ingresar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - ingresar: El objeto Adjunto (Model) se encuentra nulo"; }
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
					$consulta = "UPDATE evaluacion_quincenal SET "; 
					$consulta = $consulta."fecha_creacion='".$obj->getfecha_creacion()."', ";
					$consulta = $consulta."rut_evaluador=".$obj->getrut_evaluador().", ";
					$consulta = $consulta."nota_quincenal=".$obj->getnota_quincenal().", ";
					$consulta = $consulta."estado=".$obj->getestado()." "; 
					$consulta = $consulta."WHERE ";
					$consulta = $consulta."numero_quincenal=".$obj->getnumero_quincenal();

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
						if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - actualizar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - actualizar: El objeto Adjunto (Model) se encuentra nulo"; }
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
					$consulta = "DELETE FROM evaluacion_quincenal ";
					$consulta = $consulta."WHERE numero_quincenal = ".$obj->getnumero_quincenal().";";
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
						if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - eliminar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - eliminar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


		public function actualizaPorDesbloqueo($ejecutivo, $periodo) {
			try {
				$consulta = "CALL sp_update_eva_quincenal(".$ejecutivo.", '".$periodo."')";
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
						if(ambiente == 'DEV') { echo "EvaluacionQuincenalController - eliminar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function ultimaEvaluacionGenerada($periodo, $ejecutivo, $evaluador, $area) {
			try {
				$consulta = "SELECT * FROM evaluacion_quincenal WHERE periodo = '".$periodo."' AND rut_ejecutivo = ".$ejecutivo." AND rut_evaluador = ".$evaluador." AND codigo_area = ".$area." ORDER BY numero_quincenal DESC LIMIT 1";
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
							$array[$i] = new EvaluacionQuincenal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - listarPorNumero: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


		public function resumenEvaluacionQuincenalPDF($evaluacion) {
			try {
				$consulta = "SELECT  ";
				$consulta = $consulta."a.numero_quincenal, ";
				$consulta = $consulta."c.numero_evaluacion, ";
				$consulta = $consulta."f.codigo_categoria, ";
				$consulta = $consulta."f.nombre_categoria, ";
				$consulta = $consulta."f.peso_categoria, ";
				$consulta = $consulta."cast(avg(CASE WHEN d.nota <> -1 THEN d.nota END) as double(12,2)) as promedio ";
				$consulta = $consulta."FROM ";
				$consulta = $consulta."evaluacion_quincenal a  ";
				$consulta = $consulta."INNER JOIN detalle_evaluacion_quincenal b ON a.numero_quincenal = b.numero_quincenal ";
				$consulta = $consulta."INNER JOIN evaluacion_parcial c ON b.numero_evaluacion = c.numero_evaluacion ";
				$consulta = $consulta."INNER JOIN detalle_evaluacion_parcial d ON c.numero_evaluacion = d.numero_evaluacion  ";
				$consulta = $consulta."INNER JOIN item_evaluacion e ON d.codigo_item = e.codigo_item ";
				$consulta = $consulta."INNER JOIN categoria f ON e.codigo_categoria = f.codigo_categoria ";
				$consulta = $consulta."WHERE  ";
				$consulta = $consulta."a.numero_quincenal = ".$evaluacion." ";
				$consulta = $consulta."GROUP BY  ";
				$consulta = $consulta."a.numero_quincenal, ";
				$consulta = $consulta."c.numero_evaluacion, ";
				$consulta = $consulta."f.codigo_categoria, ";
				$consulta = $consulta."f.nombre_categoria, ";
				$consulta = $consulta."f.peso_categoria ";
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
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - listarPorNumero: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


	}
?>