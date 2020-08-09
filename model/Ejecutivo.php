<?php
	class Ejecutivo  {
		//columnas de la tabla
		private $rut_ejecutivo; 
	    private $nombre_ejecutivo;
	    private $fecha_inicio; 
	    private $codigo_estado; 
	    private $correo; 
	    private $codigo_ciclo; 
	    private $codigo_area; 
	    private $codigo_jornada; 
		


		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($arreglo) {
			$this->rut_ejecutivo	= $arreglo['rut_ejecutivo']; 
		    $this->nombre_ejecutivo = $arreglo['nombre_ejecutivo'];
		    $this->fecha_inicio 	= $arreglo['fecha_inicio']; 
		    $this->codigo_estado	= $arreglo['codigo_estado']; 
		    $this->correo 			= $arreglo['correo']; 
		    $this->codigo_ciclo 	= $arreglo['codigo_ciclo']; 
		    $this->codigo_area 		= $arreglo['codigo_area']; 
		    $this->codigo_jornada 	= $arreglo['codigo_jornada']; 
		}

		//accesadores
		public function getrut_ejecutivo() {
			try {
				return $this->rut_ejecutivo;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getnombre_ejecutivo() {
			try {
				return $this->nombre_ejecutivo;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getfecha_inicio() {
			try {
				return $this->fecha_inicio;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getcodigo_estado() {
			try {
				return $this->codigo_estado;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getcorreo() {
			try {
				return $this->correo;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getcodigo_ciclo() {
			try {
				return $this->codigo_ciclo;
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

		public function getcodigo_jornada() {
			try {
				return $this->codigo_jornada;
			}catch(Exception $e) {
				return null;
			}
		}												

		//mutadores
		public function setrut_ejecutivo($rut_ejecutivo) {
			try {
				$this->rut_ejecutivo = $rut_ejecutivo;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setnombre_ejecutivo($nombre_ejecutivo) {
			try {
				$this->nombre_ejecutivo = $nombre_ejecutivo;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}	

		public function setfecha_inicio($fecha_inicio) {
			try {
				$this->fecha_inicio = $fecha_inicio;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}	

		public function setcodigo_estado($codigo_estado) {
			try {
				$this->codigo_estado = $codigo_estado;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}	
		
		public function setcorreo($correo) {
			try {
				$this->correo = $correo;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}				    

		public function setcodigo_ciclo($codigo_ciclo) {
			try {
				$this->codigo_ciclo = $codigo_ciclo;
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

		public function setcodigo_jornada($codigo_jornada) {
			try {
				$this->codigo_jornada = $codigo_jornada;
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