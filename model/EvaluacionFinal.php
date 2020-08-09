<?php
	class EvaluacionFinal {
		//columnas de la tabla
		private $numero_final; 
		private $fecha_creacion;
		private $periodo;
		private $ejecutivo_rut_ejecutivo; 
		private $evaluador_rut_evaluador; 
		private $ejecutivo_codigo_area; 
		private $observaciones;
		private $nota_final;
		private $estado;

		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($arreglo) {
			$this->numero_final				= $arreglo['numero_final'];
			$this->fecha_creacion			= $arreglo['fecha_creacion'];
			$this->periodo					= $arreglo['periodo'];
			$this->ejecutivo_rut_ejecutivo	= $arreglo['rut_ejecutivo'];
			$this->evaluador_rut_evaluador	= $arreglo['rut_evaluador'];
			$this->ejecutivo_codigo_area	= $arreglo['codigo_area'];
			$this->observaciones			= $arreglo['observaciones'];
			$this->nota_final 				= $arreglo['nota_final'];
			$this->estado	 				= $arreglo['estado'];
		}


		//accesadores
		public function getnumero_final() {
			try {
				return $this->numero_final;
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
		
		public function getevaluador_rut_evaluador() {
			try {
				return $this->evaluador_rut_evaluador;
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
		
		public function getejecutivo_rut_ejecutivo() {
			try {
				return $this->ejecutivo_rut_ejecutivo;
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
		
		public function getobservaciones() {
			try {
				return $this->observaciones;
			}catch(Exception $e) {
				return null;
			}
		}

		public function setobservaciones($observaciones) {
			try {
				$this->observaciones = $observaciones;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}


		public function getnotafinal() {
			try {
				return $this->nota_final;
			}catch(Exception $e) {
				return null;
			}
		}

		public function setnotafinal($nota_final) {
			try {
				$this->nota_final = $nota_final;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function getestado() {
			try {
				return $this->estado;
			}catch(Exception $e) {
				return null;
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