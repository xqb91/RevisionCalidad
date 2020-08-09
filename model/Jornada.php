<?php
	class Jornada {
		//columnas de la tabla
		private $codigo_jornada;
		private $nombre_jornada;

		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($array) {
			$this->codigo_jornada = $array['codigo_jornada'];
			$this->nombre_jornada = $array['nombre_jornada'];
		}

		//accesadores
		public function getcodigo_jornada() {
			try {
				return $this->codigo_jornada;
			}catch(Exception $e) {
				return null;
			}
		}
		public function getnombre_jornada() {
			try {
				return $this->nombre_jornada;
			}catch(Exception $e) {
				return null;
			}
		}

		//mutadores
		public function setcodigo_jornada($codigo_jornada) {
			try {
				$this->codigo_jornada = $codigo_jornada;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}
		public function setnombre_jornada($nombre_jornada) {
			try {
				$this->nombre_jornada = $nombre_jornada;
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