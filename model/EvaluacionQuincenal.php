<?php
	class EvaluacionQuincenal {
		//columnas de la tabla
    	private $numero_quincenal; 
	    private $rut_ejecutivo;
	    private $fecha_creacion;
	    private $rut_evaluador;
	    private $periodo; 
	    private $ejecutivo_codigo_area; 
	    private $nota_quincenal;
	    private $estado;


		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($arreglo) {
			$this->numero_quincenal			= $arreglo['numero_quincenal'];
			$this->rut_ejecutivo			= $arreglo['rut_ejecutivo'];
			$this->fecha_creacion			= $arreglo['fecha_creacion'];
			$this->rut_evaluador			= $arreglo['rut_evaluador'];
			$this->periodo					= $arreglo['periodo'];
			$this->ejecutivo_codigo_area	= $arreglo['codigo_area'];
			$this->nota_quincenal			= $arreglo['nota_quincenal'];
			$this->estado 					= $arreglo['estado'];
		}

		//accesadores
		public function getnumero_quincenal() {
			try {
				return $this->numero_quincenal;
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

		public function getfecha_creacion() {
			try {
				return $this->fecha_creacion;
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

		public function getperiodo() {
			try {
				return $this->periodo;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getejecutivo_codigo_area() {
			try {
				return $this->ejecutivo_codigo_area;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getnota_quincenal() {
			try {
				return $this->nota_quincenal;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getestado() {
			try {
				return $this->estado;
			}catch(Exception $e) {
				return null;
			}
		}

		//mutadores
		public function setnumero_quincenal($numero_quincenal) {
			try {
				$this->numero_quincenal = $numero_quincenal;
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

		public function setfecha_creacion($fecha_creacion) {
			try {
				$this->fecha_creacion = $fecha_creacion;
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

		public function setperiodo($periodo) {
			try {
				$this->periodo = $periodo;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setejecutivo_codigo_area($ejecutivo_codigo_area) {
			try {
				$this->ejecutivo_codigo_area = $ejecutivo_codigo_area;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}	

		public function setnota_quincenal($nota_quincenal) {
			try {
				$this->nota_quincenal = $nota_quincenal;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setestado($estado) {
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