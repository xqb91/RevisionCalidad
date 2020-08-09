<?php
	class DetalleEvaluacionFinal {
		//columnas de la tabla
		private $numero_evaluacion;
     	private $numero_final; 


		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($arreglo) {
			$this->numero_evaluacion	= $arreglo['numero_evaluacion'];
			$this->numero_final			= $arreglo['numero_final'];
		}   

		//accesadores
		public function getnumero_evaluacion() {
			try {
				return $this->numero_evaluacion;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getnumero_final() {
			try {
				return $this->numero_final;
			}catch(Exception $e) {
				return null;
			}
		}
		//mutadores
		public function setnumero_evaluacion($numero_evaluacion) {
			try {
				$this->numero_evaluacion = $numero_evaluacion;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}								

		public function setnumero_final($numero_final) {
			try {
				$this->numero_final = $numero_final;
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