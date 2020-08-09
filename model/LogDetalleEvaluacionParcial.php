<?php
	class LogDetalleEvaluacionParcial  {
		//columnas de la tabla
		private $id;
		private $fecha;
		private $usuario;
		private $numero_evaluacion;
		private $codigo_item;
		private $nota;

		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($arreglo) {
			$this->id					= $arreglo['id'];
			$this->fecha				= $arreglo['fecha'];
			$this->usuario				= $arreglo['usuario'];
			$this->numero_evaluacion	= $arreglo['numero_evaluacion'];
			$this->codigo_item			= $arreglo['codigo_item'];
			$this->nota					= $arreglo['nota'];
		}

		//accesadores
		public function getid() {
			try {
				return $this->id;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getfecha() {
			try {
				return $this->fecha;
			}catch(Exception $e) {
				return null;
			}
		}		

		public function getusuario() {
			try {
				return $this->usuario;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getnumero_evaluacion() {
			try {
				return $this->numero_evaluacion;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getcodigo_item() {
			try {
				return $this->codigo_item;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getnota() {
			try {
				return $this->nota;
			}catch(Exception $e) {
				return null;
			}
		}		
		
		
		//mutadores
		public function setid($id) {
			try {
				$this->id = $id;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setfecha($fecha) {
			try {
				$this->fecha = $fecha;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setusuario($usuario) {
			try {
				$this->usuario = $usuario;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}		

		public function setnumero_evaluacion($numero_evaluacion) {
			try {
				$this->numero_evaluacion = $numero_evaluacion;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}		

		public function setcodigo_item($codigo_item) {
			try {
				$this->codigo_item = $codigo_item;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setnota($nota) {
			try {
				$this->nota = $nota;
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