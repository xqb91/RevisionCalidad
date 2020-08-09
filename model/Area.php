<?php
	class Area {
		//columnas de la tabla
		private $codigo_area;
		private $nombre_area;
		private $estado;
		private $fecha_creacion;

		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($arreglo = null) {
			$this->codigo_area		= $arreglo['codigo_area'];
			$this->nombre_area		= $arreglo['nombre_area'];
			$this->estado			= $arreglo['estado'];
			$this->fecha_creacion	= $arreglo['fecha_creacion'];
		}

		public function nuevo($codigo_area, $nombre_area, $estado, $fecha_creacion) {
			$this->codigo_area		= $codigo_area;
			$this->nombre_area		= $nombre_area;
			$this->estado			= $estado;
			$this->fecha_creacion	= $fecha_creacion;
		}

		//accesadores
		public function getcodigo_area() {
			try {
				return $this->codigo_area;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getnombre_area() {
			try {
				return $this->nombre_area;
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

		public function getfecha_creacion() {
			try {
				return $this->fecha_creacion;
			}catch(Exception $e) {
				return null;
			}
		}

		//mutadores
		public function setcodigo_area($codigo_area) {
			try {
				$this->codigo_area = intval(preg_replace('/[^0-9]+/', '', $codigo_area), 10);
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setnombre_area($nombre_area) {
			try {
				if(strlen($nombre_area) == 0) {
	    			return false;
	    		}else{ 
					$this->nombre_area =preg_replace('([^A-Za-z0-9Á-Ú ])', '', trim($nombre_area));
					return true;
				}
			}catch(Exception $e) {
				return false;
			}
		}

		public function setestado($estado) {
			try {
				if(strlen($estado) == 0) {
	    			return false;
	    		}else{ 
					$this->estado = intval(preg_replace('/[^0-9]+/', '', $estado), 10);
					return true;
				}
			}catch(Exception $e) {
				return false;
			}
		}

		public function setfecha_creacion($fecha_creacion) {
			try {
				if(strlen($fecha_creacion) == 0) {
	    			return false;
	    		}else{ 
					$this->fecha_creacion = $fecha_creacion;
					return true;
				}
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