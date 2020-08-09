  <?php
	class Audio {
		//columnas de la tabla  (
	    private $numero_evaluacion;
	    private $fecha;
	    private $nombre_audio;
	    private $periodo;


		public function __construct($arreglo) {
			$this->numero_evaluacion = $arreglo['numero_evaluacion'];
			$this->fecha			 = $arreglo['fecha'];
			$this->nombre_audio		 = $arreglo['nombre_audio'];
			$this->periodo			 = $arreglo['periodo'];
		}

		public function getnumero_evaluacion() {
			try {
				return $this->numero_evaluacion;
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
		public function setnumero_evaluacion($numero_evaluacion) {
			try {
				$this->numero_evaluacion = intval(preg_replace('/[^0-9]+/', '', $numero_evaluacion), 10);
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