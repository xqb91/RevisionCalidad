<?php
	//Controlador OK: 09.04.2020
	include(dirModel."EvaluacionFinal.php");
	class EvaluacionFinalController {

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
				$consulta = 'SELECT * FROM evaluacion_final ORDER BY numero_final DESC';
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
							$array[$i] = new EvaluacionFinal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionFinalController - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorNumero($codigo) {
			try {
				$consulta = "SELECT * FROM evaluacion_final WHERE numero_final = ".$codigo." ORDER BY numero_final DESC";
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
							$array[$i] = new EvaluacionFinal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionFinalController - listarPorCodigo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorEjecutivo($ejecutivo, $periodo) {
			try {
				$consulta = "SELECT * FROM evaluacion_final WHERE rut_ejecutivo = '".$ejecutivo."' AND periodo = '".$periodo."' ORDER BY numero_final DESC";
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
							$array[$i] = new EvaluacionFinal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionFinalController - listarPorCodigo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorPeriodo($periodo) {
			try {
				$consulta = "SELECT * FROM evaluacion_final WHERE periodo = '".$periodo."' ORDER BY numero_final DESC";
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
							$array[$i] = new EvaluacionFinal($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionFinalController - listarPorCodigo: El objeto DatabaseTransaction se encuentra nulo"; }
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
					$consulta = "INSERT INTO evaluacion_final ";
					$consulta = $consulta."(fecha_creacion, periodo, rut_ejecutivo, rut_evaluador, codigo_area, observaciones, nota_final) VALUES ";
					$consulta = $consulta."('".date('Y-m-d H:i:s')."', '".$obj->getperiodo()."', ".$obj->getejecutivo_rut_ejecutivo().", ".$obj->getevaluador_rut_evaluador().", ".$obj->getejecutivo_codigo_area().", '".$obj->getobservaciones()."', ".$obj->getnotafinal()." );";
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
						if(ambiente == 'DEV') { echo "EvaluacionFinalController - ingresar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionFinalController - ingresar: El objeto Adjunto (Model) se encuentra nulo"; }
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
					$consulta = "UPDATE evaluacion_final ";
					$consulta = $consulta."SET observaciones = '".$obj->getobservaciones()."' ";
					$consulta = $consulta."WHERE numero_final = ".$obj->getnumero_final().";";
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
						if(ambiente == 'DEV') { echo "EvaluacionFinalController - actualizar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionFinalController - actualizar: El objeto Adjunto (Model) se encuentra nulo"; }
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
					$consulta = "DELETE FROM evaluacion_final ";
					$consulta = $consulta."WHERE numero_final = ".$obj->getnumero_final().";";
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
						if(ambiente == 'DEV') { echo "EvaluacionFinalController - eliminar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionFinalController - eliminar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


		public function actualizaPorDesbloqueo($ejecutivo, $periodo) {
			try {
				//objeto
				$obj = $param;
				if($obj != null) {
					//construyendo string
					$consulta = "CALL sp_update_eva_final(".$ejecutivo.", '".$periodo."')";
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
						if(ambiente == 'DEV') { echo "EvaluacionFinalController - actualizaPorDesbloqueo: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionFinalController - actualizaPorDesbloqueo: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function calcularNotaFinal($ejecutivo = null, $periodo = null) {
			try {
				if($ejecutivo != null) {
					if($periodo != null) {
						//construyendo string
						$consulta = "SELECT ";
						$consulta = $consulta."nombre_categoria, ";
						$consulta = $consulta."CAST(AVG(promedio) as double(19,2)) as promedio, ";
						$consulta = $consulta."CAST(AVG(peso_categoria) as double(19,2)) as peso, ";
						$consulta = $consulta."CAST(AVG(nota_final) as double(19,2)) as final ";
						$consulta = $consulta."FROM ( ";
						$consulta = $consulta."SELECT ";
						$consulta = $consulta."a.numero_evaluacion, ";
						$consulta = $consulta."d.nombre_categoria, ";
						$consulta = $consulta."CAST(AVG(CASE WHEN b.nota <> -1 THEN b.nota END) as double(19,2)) as promedio, ";
						$consulta = $consulta."CAST(AVG(d.peso_categoria) as integer) as peso_categoria, ";
						$consulta = $consulta."CAST(AVG(a.nota_final) as double(19,2)) as nota_final ";
						$consulta = $consulta."FROM ";
						$consulta = $consulta."evaluacion_parcial a ";
						$consulta = $consulta."INNER JOIN detalle_evaluacion_parcial b ON a.numero_evaluacion = b.numero_evaluacion ";
						$consulta = $consulta."INNER JOIN item_evaluacion c ON b.codigo_item = c.codigo_item ";
						$consulta = $consulta."INNER JOIN categoria d ON c.codigo_categoria = d.codigo_categoria ";
						$consulta = $consulta."WHERE ";
						$consulta = $consulta."a.rut_ejecutivo = ".$ejecutivo." AND ";
						$consulta = $consulta."a.periodo = '".$periodo."' ";
						$consulta = $consulta."GROUP BY ";
						$consulta = $consulta."a.numero_evaluacion, ";
						$consulta = $consulta."d.nombre_categoria ";
						$consulta = $consulta.")xx ";
						$consulta = $consulta."GROUP BY ";
						$consulta = $consulta."nombre_categoria";
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
							if(ambiente == 'DEV') { echo "EvaluacionFinalController - calcularNotaFinal: El objeto DatabaseTransaction se encuentra nulo"; }
							return false;
						}

					}else{
						if(ambiente == 'DEV') { echo "EvaluacionFinalController - calcularNotaFinal: El parammetro periodo se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionFinalController - calcularNotaFinal: El parametro ejecutivo se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


		public function datosReportePDF($evaluacion = null) {
			try {
				if($evaluacion != null) {
					//construyendo string
					$consulta = "SELECT ";
					$consulta = $consulta."a.numero_final, ";
					$consulta = $consulta."c.numero_evaluacion as parcial, ";
					$consulta = $consulta."f.nombre_categoria, ";
					$consulta = $consulta."f.codigo_categoria, ";
					$consulta = $consulta."f.peso_categoria, ";
					$consulta = $consulta."CAST(AVG(CASE WHEN d.nota <> -1 THEN d.nota END) as double(12,2)) as promedio ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_final a ";
					$consulta = $consulta."INNER JOIN detalle_evaluacion_final b ON a.numero_final = b.numero_final ";
					$consulta = $consulta."INNER JOIN evaluacion_parcial c ON b.numero_evaluacion = c.numero_evaluacion ";
					$consulta = $consulta."INNER JOIN detalle_evaluacion_parcial d ON c.numero_evaluacion = d.numero_evaluacion ";
					$consulta = $consulta."INNER JOIN item_evaluacion e ON d.codigo_item = e.codigo_item ";
					$consulta = $consulta."INNER JOIN categoria f on e.codigo_categoria = f.codigo_categoria ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."a.numero_final = ".$evaluacion." ";
					$consulta = $consulta."GROUP BY  ";
					$consulta = $consulta."a.numero_final, ";
					$consulta = $consulta."c.numero_evaluacion, ";
					$consulta = $consulta."f.nombre_categoria, ";
					$consulta = $consulta."f.codigo_categoria, ";
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
						if(ambiente == 'DEV') { echo "EvaluacionFinalController - calcularNotaFinal: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionFinalController - calcularNotaFinal: El parametro ejecutivo se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function resumenReportePDF($evaluacion = null) {
			try {
				if($evaluacion != null) {
					//construyendo string
					$consulta = "SELECT ";
					$consulta = $consulta."a.numero_final, ";
					$consulta = $consulta."f.nombre_categoria, ";
					$consulta = $consulta."f.peso_categoria, ";
					$consulta = $consulta."CAST(AVG(CASE WHEN d.nota <> -1 THEN d.nota END) as double(12,2)) as promedio ";
					$consulta = $consulta."FROM  ";
					$consulta = $consulta."evaluacion_final a ";
					$consulta = $consulta."INNER JOIN detalle_evaluacion_final b ON a.numero_final = b.numero_final ";
					$consulta = $consulta."INNER JOIN evaluacion_parcial c ON b.numero_evaluacion = c.numero_evaluacion ";
					$consulta = $consulta."INNER JOIN detalle_evaluacion_parcial d ON c.numero_evaluacion = d.numero_evaluacion ";
					$consulta = $consulta."INNER JOIN item_evaluacion e ON d.codigo_item = e.codigo_item ";
					$consulta = $consulta."INNER JOIN categoria f on e.codigo_categoria = f.codigo_categoria ";
					$consulta = $consulta."WHERE  ";
					$consulta = $consulta."a.numero_final = ".$evaluacion." ";
					$consulta = $consulta."GROUP BY  ";
					$consulta = $consulta."a.numero_final, ";
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
						if(ambiente == 'DEV') { echo "EvaluacionFinalController - calcularNotaFinal: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionFinalController - calcularNotaFinal: El parametro ejecutivo se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


	}
?>