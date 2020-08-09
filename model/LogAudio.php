<?php
	class LogAudio  {
		//columnas de la tabla
		private $id;
		private $fecha;
		private $usuario;
		private $numero_evaluacion;
		private $fecha_carga;
		private $nombre_audio;
		private $periodo;

		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($arreglo) {
			$this->id					= $arreglo['id'];
			$this->fecha				= $arreglo['fecha'];
			$this->usuario				= $arreglo['usuario'];
			$this->numero_evaluacion	= $arreglo['numero_evaluacion'];
			$this->fecha_carga			= $arreglo['fecha_carga'];
			$this->nombre_audio			= $arreglo['nombre_audio'];
			$this->periodo				= $arreglo['periodo'];
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

		public function getfecha_carga() {
			try {
				return $this->fecha_carga;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getnombre_audio() {
			try {
				return $this->nombre_audio;
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

		public function setfecha_carga($fecha_carga) {
			try {
				$this->fecha_carga = $fecha_carga;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setnombre_audio($nombre_audio) {
			try {
				$this->nombre_audio = $nombre_audio;
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

		//metodos de la clase
		//lista todos los valores de la clase
		public function serializar() {
	        return json_encode(get_object_vars($this), JSON_FORCE_OBJECT);
		}
	

	}
?>		