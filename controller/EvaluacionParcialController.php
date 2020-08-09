<?php
	//Controlador OK: 09.04.2020
	include(dirModel."EvaluacionParcial.php");
	class EvaluacionParcialController {

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
				$consulta = 'SELECT * FROM evaluacion_parcial ORDER BY numero_evaluacion DESC';
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
							$array[$i] = new EvaluacionParcial($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - Listar: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorNumero($numero) {
			try {
				$consulta = "SELECT * FROM evaluacion_parcial WHERE numero_evaluacion = '".$numero."'";
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
							$array[$i] = new EvaluacionParcial($registro);
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

		public function listarPorPeriodo($periodo) {
			try {
				$consulta = "SELECT * FROM evaluacion_parcial WHERE periodo = '".$periodo."' ORDER BY numero_evaluacion DESC";
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
							$array[$i] = new EvaluacionParcial($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - listarPorPeriodo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorPeriodoArea($periodo, $area) {
			try {
				$consulta = "SELECT * FROM evaluacion_parcial WHERE periodo = '".$periodo."' and codigo_area = '".$area."' ORDER BY rut_ejecutivo DESC, numero_evaluacion DESC, periodo DESC";
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
							$array[$i] = new EvaluacionParcial($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - listarPorPeriodoArea: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorEjecutivo($ejecutivo, $periodo) {
			try {
				$consulta = "SELECT * FROM evaluacion_parcial WHERE rut_ejecutivo = '".$ejecutivo."' AND periodo = '".$periodo."' ORDER BY rut_ejecutivo DESC, numero_evaluacion DESC, periodo DESC";
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
							$array[$i] = new EvaluacionParcial($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - listarPorEjecutivo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorEjecutivoPeriodo($ejecutivo, $periodo) {
			try {
				$consulta = "SELECT * FROM evaluacion_parcial WHERE rut_ejecutivo = '".$ejecutivo."' AND periodo = '".$periodo."' ORDER BY rut_ejecutivo DESC, numero_evaluacion DESC, periodo DESC";
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
							$array[$i] = new EvaluacionParcial($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - listarPorEjecutivoPeriodo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorEvaluadorPeriodo($evaluador, $periodo) {
			try {
				$consulta = "SELECT * FROM evaluacion_parcial WHERE rut_evaluador = '".$ejecutivo."' AND periodo = '".$periodo."' ORDER BY rut_ejecutivo DESC, numero_evaluacion DESC, periodo DESC";
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
							$array[$i] = new EvaluacionParcial($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - listarPorEvaluadorPeriodo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function listarPorEvaluadorPeriodoArea($evaluador, $periodo, $area) {
			try {
				$consulta = "SELECT * FROM evaluacion_parcial WHERE rut_evaluador = '".$ejecutivo."' AND periodo = '".$periodo."' AND codigo_area = '".$area."' ORDER BY numero_evaluacion DESC";
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
							$array[$i] = new EvaluacionParcial($registro);
							$i++;
						}
						$this->databaseTransaction->cerrar();
						return $array;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - listarPorEvaluadorPeriodoArea: El objeto DatabaseTransaction se encuentra nulo"; }
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
					$consulta = "INSERT INTO evaluacion_parcial ";
					$consulta = $consulta."(fecha_evaluacion, periodo, rut_ejecutivo, rut_evaluador, nota_final, observacion, codigo_area) VALUES ";
					$consulta = $consulta."('".date('Y-m-d H:i:s')."', '".$obj->getperiodo()."', ".$obj->getrut_ejecutivo().", ".$obj->getrut_evaluador().", ".$obj->getnota_final().", '".$obj->getobservacion()."', ".$obj->getcodigo_area()." );";
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
						if(ambiente == 'DEV') { echo "EvaluacionParcialController - ingresar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - ingresar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function seteaNumeroOrden($param) {
			try {
				//objeto
				$obj = $param;
				if($obj != null) {
					//construyendo string
					$consulta = "CALL sp_setea_numero_orden_parcial(".$param->getnumero_evaluacion().");";
					//ejecutando la consulta
					if($this->databaseTransaction != null) {
						$resultado = $this->databaseTransaction->ejecutar($consulta);
						if($resultado == true) {
							$this->databaseTransaction->confirmar();
							$this->databaseTransaction->cerrar();
							return $this->ultimaEvaluacionGenerada($param->getperiodo(), $param->getrut_ejecutivo(), $param->getrut_evaluador(), $param->getcodigo_area());
						}else{
							$this->databaseTransaction->deshacer();
							$this->databaseTransaction->cerrar();
							return null;
						}
					}else{
						if(ambiente == 'DEV') { echo "seteaNumeroOrden - ingresar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "seteaNumeroOrden - ingresar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


		public function actualizaNumeroOrden($param) {
			try {
				//objeto
				$obj = $param;
				if($obj != null) {
					//construyendo string
					$consulta = "CALL sp_update_numero_orden_parcial('".$param->getperiodo()."', ".$param->getrut_ejecutivo().");";
					//ejecutando la consulta
					if($this->databaseTransaction != null) {
						$resultado = $this->databaseTransaction->ejecutar($consulta);
						if($resultado == true) {
							$this->databaseTransaction->confirmar();
							$this->databaseTransaction->cerrar();
							return $this->ultimaEvaluacionGenerada($param->getperiodo(), $param->getrut_ejecutivo(), $param->getrut_evaluador(), $param->getcodigo_area());
						}else{
							$this->databaseTransaction->deshacer();
							$this->databaseTransaction->cerrar();
							return null;
						}
					}else{
						if(ambiente == 'DEV') { echo "seteaNumeroOrden - ingresar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "seteaNumeroOrden - ingresar: El objeto Adjunto (Model) se encuentra nulo"; }
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
					$consulta = "UPDATE evaluacion_parcial ";
					$consulta = $consulta."SET observacion = '".$obj->getobservacion()."', nota_final = ".$obj->getnota_final().", estado = ".$obj->getEstado()." ";
					$consulta = $consulta."WHERE numero_evaluacion = ".$obj->getnumero_evaluacion().";";
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
						if(ambiente == 'DEV') { echo "EvaluacionParcialController - actualizar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - actualizar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function actualizarNota($param) {
			try {
				//objeto
				$obj = $param;
				if($obj != null) {
					//construyendo string
					$consulta = "UPDATE evaluacion_parcial ";
					$consulta = $consulta."SET nota_final = ".$obj->getnota_final()." ";
					$consulta = $consulta."WHERE numero_evaluacion = ".$obj->getnumero_evaluacion().";";
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
						if(ambiente == 'DEV') { echo "EvaluacionParcialController - actualizar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - actualizar: El objeto Adjunto (Model) se encuentra nulo"; }
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
					$consulta = "DELETE FROM evaluacion_parcial ";
					$consulta = $consulta."WHERE numero_evaluacion = ".$obj->getnumero_evaluacion().";";
					//ejecutando la consulta
					if($this->databaseTransaction != null) {
						$resultado = $this->databaseTransaction->ejecutar($consulta);
						if($resultado == true) {
							$this->databaseTransaction->confirmar();
							$this->databaseTransaction->cerrar();
							$this->actualizaNumeroOrden($obj);
							return 1;
						}else{
							$this->databaseTransaction->deshacer();
							$this->databaseTransaction->cerrar();
							return 0;
						}
					}else{
						if(ambiente == 'DEV') { echo "EvaluacionParcialController - eliminar: El objeto DatabaseTransaction se encuentra nulo"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - eliminar: El objeto Adjunto (Model) se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function ultimaEvaluacionGenerada($periodo, $ejecutivo, $evaluador, $area) {
			try {
				$consulta = "SELECT * FROM evaluacion_parcial WHERE periodo = '".$periodo."' AND rut_ejecutivo = ".$ejecutivo." AND rut_evaluador = ".$evaluador." AND codigo_area = ".$area." ORDER BY numero_evaluacion DESC LIMIT 1";
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
							$array[$i] = new EvaluacionParcial($registro);
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

		public function existeEvaluacion($numero_evaluacion) {
			try {
				$consulta = "SELECT count(*) total FROM evaluacion_parcial WHERE numero_evaluacion = ".$numero_evaluacion." ";
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
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - listarPorNumero: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function haCompletadoEvaluacionesPorPeriodo($ejecutivo, $periodo) {
			try {
				$consulta = "SELECT COALESCE(CASE WHEN count(a.numero_evaluacion) < c.cantidad_finales THEN FALSE WHEN count(a.numero_evaluacion) >= c.cantidad_finales THEN TRUE END, FALSE) as valor FROM evaluacion_parcial a INNER JOIN area b ON a.codigo_area = b.codigo_area INNER JOIN evaluaciones_area c ON b.codigo_area = c.codigo_area AND a.periodo = c.periodo WHERE a.rut_ejecutivo = ".$ejecutivo." AND a.periodo = '".$periodo."'";
				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return false;
					}else{
						if($this->databaseTransaction->resultados()["valor"] == 0) {
							$this->databaseTransaction->cerrar();
							return false;
						}else{
							$this->databaseTransaction->cerrar();
							return true;
						}
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - haCompletadoEvaluacionesPorPeriodo: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}


		public function detalleTotalEvaluacionParcial($evaluacion) {
			try {			
				$consulta = "SELECT ";
				$consulta = $consulta."a.numero_evaluacion, ";
				$consulta = $consulta."CAST(avg(a.nota_final) as decimal(16,2)) as nota_parcial, ";
				$consulta = $consulta."d.nombre_categoria, ";
				$consulta = $consulta."CAST(avg(d.peso_categoria) as Integer) as peso_categoria, ";
				$consulta = $consulta."CAST(avg(CASE WHEN b.nota <> -1 THEN b.nota END) as decimal(16,2)) as nota_categoria, ";
				$consulta = $consulta."(SELECT z.nombre_audio FROM audio z WHERE z.numero_evaluacion = a.numero_evaluacion) as audio ";
				$consulta = $consulta."FROM ";
				$consulta = $consulta."evaluacion_parcial a ";
				$consulta = $consulta."INNER JOIN detalle_evaluacion_parcial b ON a.numero_evaluacion = b.numero_evaluacion ";
				$consulta = $consulta."INNER JOIN item_evaluacion c ON b.codigo_item = c.codigo_item ";
				$consulta = $consulta."INNER JOIN categoria d ON c.codigo_categoria = d.codigo_categoria ";
				$consulta = $consulta."WHERE ";
				$consulta = $consulta."a.numero_evaluacion = ".$evaluacion." ";
				$consulta = $consulta."GROUP BY ";
				$consulta = $consulta."a.numero_evaluacion, ";
				$consulta = $consulta."d.nombre_categoria, "; 
				$consulta = $consulta."audio ";

				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($consulta);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						$arreglo = null;
						$i = 0;
						while($registro = $this->databaseTransaction->resultados()) {
							$arreglo[$i] = $registro;
							$i++;
						}
						return $arreglo;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - detalleTotalEvaluacionParcial: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo "Error Crítico: ".$e->getMessage(); }
				return false;
			}
		}


		public function detallePorItemPDF($evaluacion) {
			try {			
				$string = "SELECT ";
				$string = $string."d.codigo_categoria, ";
				$string = $string."d.nombre_categoria, ";
				$string = $string."d.peso_categoria, ";
				$string = $string."(SELECT count(*) FROM item_evaluacion cc INNER JOIN categoria dd ON cc.codigo_categoria = dd.codigo_categoria WHERE dd.codigo_categoria = d.codigo_categoria) cantidad_items, ";
				$string = $string."c.codigo_item, ";
				$string = $string."c.nombre_item, ";
				$string = $string."b.nota ";
				$string = $string."FROM  ";
				$string = $string."evaluacion_parcial a  ";
				$string = $string."INNER JOIN detalle_evaluacion_parcial b ON a.numero_evaluacion = b.numero_evaluacion ";
				$string = $string."INNER JOIN item_evaluacion c on b.codigo_item = c.codigo_item ";
				$string = $string."INNER JOIN categoria d ON c.codigo_categoria = d.codigo_categoria ";
				$string = $string."WHERE  ";
				$string = $string."a.numero_evaluacion = ".$evaluacion." ";
				$string = $string."GROUP BY ";
				$string = $string."d.codigo_categoria, ";
				$string = $string."d.nombre_categoria, ";
				$string = $string."d.peso_categoria, ";
				$string = $string."c.codigo_item, ";
				$string = $string."c.nombre_item, ";
				$string = $string."b.nota ";

				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($string);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						$arreglo = null;
						$i = 0;
						while($registro = $this->databaseTransaction->resultados()) {
							$arreglo[$i] = $registro;
							$i++;
						}
						return $arreglo;
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - detalleTotalEvaluacionParcial: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo "Error Crítico: ".$e->getMessage(); }
				return false;
			}
		}


		public function bloquePorQuincenal($evaluacionParcial) {
			try {			
				$query = 'SELECT '; 
				$query = $query.'count(*) bloqueada ';
				$query = $query.'FROM '; 
				$query = $query.'evaluacion_parcial a ';
				$query = $query.'INNER JOIN detalle_evaluacion_quincenal b ON a.numero_evaluacion = b.numero_evaluacion ';
				$query = $query.'WHERE '; 
				$query = $query.'a.numero_evaluacion = '.$evaluacion.' ';

				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($query);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						$registro = $this->databaseTransaction->resultados();
						if($registro['bloqueada'] > 0) {
							return true;
						}else{
							return false;
						}
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - bloquePorQuincenal: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo "Error Crítico: ".$e->getMessage(); }
				return false;
			}
		}

		public function bloqueoPorFinal($evaluacionParcial) {
			try {			
				$query = 'SELECT '; 
				$query = $query.'count(*) bloqueada ';
				$query = $query.'FROM '; 
				$query = $query.'evaluacion_parcial a ';
				$query = $query.'INNER JOIN detalle_evaluacion_final b ON a.numero_evaluacion = b.numero_evaluacion ';
				$query = $query.'WHERE '; 
				$query = $query.'a.numero_evaluacion = '.$evaluacion.' ';

				//ejecutando la consulta
				if($this->databaseTransaction != null) {
					$resultado = $this->databaseTransaction->ejecutar($query);
					if($this->databaseTransaction->cantidadResultados() == 0) {
						$this->databaseTransaction->cerrar();
						return null;
					}else{
						$registro = $this->databaseTransaction->resultados();
						if($registro['bloqueada'] > 0) {
							$this->databaseTransaction->cerrar();
							return true;
						}else{
							$this->databaseTransaction->cerrar();
							return false;
						}
					}
				}else{
					if(ambiente == 'DEV') { echo "EvaluacionParcialController - bloqueoPorFinal: El objeto DatabaseTransaction se encuentra nulo"; }
					return false;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo "Error Crítico: ".$e->getMessage(); }
				return false;
			}
		}

	}
?>