<?php
	class Adjuntos {
		//columnas de la tabla
	    private $codigo_adjunto ; 
	    private $numero_evaluacion ; 
	    private $fecha_carga ;
	    private $periodo ;
	    private $nombre_original;
	    private $archivo_server ; 

		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($arreglo) {
			$this->codigo_adjunto	 = $arreglo['codigo_adjunto'];
			$this->numero_evaluacion = $arreglo['numero_evaluacion'];
			$this->fecha_carga		 = $arreglo['fecha_carga'];
			$this->periodo	 		 = $arreglo['periodo'];
			$this->nombre_original	 = $arreglo['nombre_original'];
			$this->archivo_server	 = $arreglo['archivo_server'];
		}	   

		public function nuevo($numero_evaluacion, $fecha_carga, $periodo, $nombre_original, $archivo_server ) {
			$this->numero_evaluacion = $numero_evaluacion;
			$this->fecha_carga		 = $fecha_carga;
			$this->periodo	 		 = $periodo;
			$this->nombre_original	 = $nombre_original;
			$this->archivo_server	 = $archivo_server;
		}


	    public function getcodigo_adjunto() {
	    	try {
	    		return $this->codigo_adjunto;
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
	    public function getperiodo() {
	    	try {
	    		return $this->periodo;
	    	}catch(Exception $e) {
	    		return null;
	    	}
	    } 
	    public function getnombre_original() {
	    	try {
	    		return $this->nombre_original;
	    	}catch(Exception $e) {
	    		return null;
	    	}
	    }
	    public function getarchivo_server() {
	    	try {
	    		return $this->archivo_server;
	    	}catch(Exception $e) {
	    		return null;
	    	}
	    }  

		//mutadores
	    public function setcodigo_adjunto($codigo_adjunto) {
	    	try {
	    		if(strlen($codigo_adjunto) == 0) {
	    			return false;
	    		}else{ 
	    			if(strlen($intval(preg_replace('/[^0-9]+/', '', $codigo_adjunto), 10)) == 0) {
	    				return false;
	    			}else{
			    		$this->codigo_adjunto = intval(preg_replace('/[^0-9]+/', '', $codigo_adjunto), 10);
						return true;
	    			}
	    		}
	    	}catch(Exception $e) {
	    		return false;
	    	}
	    }  
	    public function setnumero_evaluacion($numero_evaluacion) {
	    	try {
	    		if(strlen($numero_evaluacion) == 0) {
	    			return false;
	    		}else{
	    			$this->numero_evaluacion = intval(preg_replace('/[^0-9]+/', '', $numero_evaluacion), 10);
	    			return true;
	    		}
	    	}catch(Exception $e) {
	    		return false;
	    	}
	    }  
	    public function setfecha_carga($fecha_carga) {
	    	try {
	    		if(strlen($fecha_carga) == 0) {
	    			return false;
	    		}else{
	    			$this->fecha_carga = $fecha_carga;
	    			return true;
	    		}
	    	}catch(Exception $e) {
	    		return false;
	    	}
	    } 
	    public function setperiodo($periodo) {
	    	try {
	    		if(strlen($periodo) == 0) {
	    			return false;
	    		}else{
		    		$this->periodo = $periodo;
		    		return true;
		    	}
	    	}catch(Exception $e) {
	    		return false;
	    	}
	    } 
	    public function setnombre_original($nombre_original) {
	    	try {
	    		if(strlen($nombre_original) == 0) {
	    			return false;
	    		}else{
	    			$this->nombre_original = $nombre_original;
	    			return true;
	    		}
	    	}catch(Exception $e) {
	    		return false;
	    	}
	    }
	    public function setarchivo_server($nombre_original) {
	    	try {
	    		if(strlen($nombre_original) == 0) {
	    			return false;
	    		}else{
	    			$this->nombre_original = $nombre_original;
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