<?php
	class EvaluacionesArea {
		//columnas de la tabla
	    private $id ;
	    private $codigo_area ;
	    private $periodo;
	    private $cantidad_quincenales; 
	    private $cantidad_finales;

		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($arreglo) {
			$this->id					= $arreglo['id'];
			$this->codigo_area			= $arreglo['codigo_area'];
			$this->periodo		 		= $arreglo['periodo'];
			$this->cantidad_quincenales	= $arreglo['cantidad_quincenales'];
			$this->cantidad_finales   	= $arreglo['cantidad_finales'];
		}

		//accesadores
		public function getid() {
			try {
				return $this->id;
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
		public function getperiodo() {
			try {
				return $this->periodo;
			}catch(Exception $e) {
				return null;
			}
		}		
		public function getcantidad_quincenales() {
			try {
				return $this->cantidad_quincenales;
			}catch(Exception $e) {
				return null;
			}
		}
		public function getcantidad_finales() {
			try {
				return $this->cantidad_finales;
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

		public function setcodigo_area($codigo_area) {
			try {
				$this->codigo_area = $codigo_area;
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

		public function setcantidad_quincenales($cantidad_quincenales) {
			try {
				$this->cantidad_quincenales = $cantidad_quincenales;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setcantidad_finales($cantidad_finales) {
			try {
				$this->cantidad_finales = $cantidad_finales;
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