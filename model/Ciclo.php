<?php
	class Ciclo  {
		//columnas de la tabla
		private $codigo_ciclo;
		private $nombre_ciclo;
		private $sigla_ciclo;

		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($array) {
			$this->codigo_ciclo	= $array['codigo_ciclo'];
			$this->nombre_ciclo	= $array['nombre_ciclo'];
			$this->sigla_ciclo	= $array['sigla_ciclo'];
		}
		
		//accesadores
		public function getcodigo_ciclo() {
			try {
				return $this->codigo_ciclo;
			}catch(Exception $e) {
				return null;
			}
		}
		public function getnombre_ciclo() {
			try {
				return $this->nombre_ciclo;
			}catch(Exception $e) {
				return null;
			}
		}
		public function getsigla_ciclo() {
			try {
				return $this->sigla_ciclo;
			}catch(Exception $e) {
				return null;
			}
		}

		//mutadores
		public function setcodigo_ciclo($codigo_ciclo) {
			try {
				$this->codigo_ciclo = $codigo_ciclo;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}
		public function setnombre_ciclo($nombre_ciclo) {
			try {
				$this->nombre_ciclo = $nombre_ciclo;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}
		public function setsigla_ciclo($sigla_ciclo) {
			try {
				$this->sigla_ciclo = $sigla_ciclo;
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