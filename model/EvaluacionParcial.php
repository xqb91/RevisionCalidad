<?php
	error_reporting(0);
	class EvaluacionParcial {
		//columnas de la tabla
		private $numero_evaluacion; 
		private $fecha_evaluacion; 
		private $periodo ; 
		private $rut_ejecutivo; 
		private $rut_evaluador; 
		private $nota_final; 
		private $observacion; 
		private $codigo_area; 
		private $orden;
		private $estado;

		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($arreglo) {
			$this->numero_evaluacion	= $arreglo['numero_evaluacion'];
			$this->fecha_evaluacion		= $arreglo['fecha_evaluacion'];
			$this->periodo				= $arreglo['periodo'];
			$this->rut_ejecutivo		= $arreglo['rut_ejecutivo'];
			$this->rut_evaluador		= $arreglo['rut_evaluador'];
			$this->nota_final			= $arreglo['nota_final'];
			$this->observacion			= $arreglo['observacion'];
			$this->codigo_area			= $arreglo['codigo_area'];
			$this->orden  				= $arreglo['orden'];
			$this->estado 				= $arreglo['estado'];
		}

		//accesadores
		public function getnumero_evaluacion() {
			try {
				return $this->numero_evaluacion;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getfecha_evaluacion() {
			try {
				return $this->fecha_evaluacion;
			}catch(Exception $e) {
				return null;
			}
		}	

		public function getperiodo() {
			try {
				return $this->periodo;
			}catch(Exception $e) {
				return null;
			}
		}			

		public function getrut_ejecutivo() {
			try {
				return $this->rut_ejecutivo;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getrut_evaluador() {
			try {
				return $this->rut_evaluador;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getnota_final() {
			try {
				return $this->nota_final;
			}catch(Exception $e) {
				return null;
			}
		}		 
		 
		public function getobservacion() {
			try {
				return $this->observacion;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getcodigo_area() {
			try {
				return $this->codigo_area;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getOrden() {
			try {
				return $this->orden;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getEstado() {
			try {
				return $this->estado;
			}catch(Exception $e) {
				return null;
			}
		}

		//mutadores
		public function setnumero_evaluacion($numero_evaluacion) {
			try {
				$this->numero_evaluacion = $numero_evaluacion;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}		

		public function setfecha_evaluacion($fecha_evaluacion) {
			try {
				$this->fecha_evaluacion = $fecha_evaluacion;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setperiodo($periodo) {
			try {
				$this->periodo = $periodo;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}
 
		public function setrut_ejecutivo($rut_ejecutivo) {
			try {
				$this->rut_ejecutivo = $rut_ejecutivo;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setrut_evaluador($rut_evaluador) {
			try {
				$this->rut_evaluador = $rut_evaluador;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}		 

		public function setnota_final($nota_final) {
			try {
				$this->nota_final = $nota_final;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}	

		public function setobservacion($observacion) {
			try {
				$this->observacion = $observacion;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setcodigo_area($codigo_area) {
			try {
				$this->codigo_area = $codigo_area;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setEstado($estado) {
			try {
				$this->estado = $estado;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}
		 
		//metodos de la clase
		//lista todos los valores de la clase
		public function serializar() {
	        return json_encode(get_object_vars($this), JSON_FORCE_OBJECT);
		}	 

	}

?>
		