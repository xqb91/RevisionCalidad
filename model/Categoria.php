  <?php
	class Categoria  {

	    private $codigo_categoria; 
	    private $codigo_area;
	    private $nombre_categoria; 
	    private $peso_categoria; 
	    private $orden;

		public function __construct($arreglo) {
			$this->codigo_categoria = $arreglo['codigo_categoria'];
			$this->codigo_area		= $arreglo['codigo_area'];
			$this->nombre_categoria	= $arreglo['nombre_categoria'];
			$this->peso_categoria	= $arreglo['peso_categoria'];
			$this->orden			= $arreglo['orden'];
		}

		public function getcodigo_categoria() {
			try {
				return $this->codigo_categoria;
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

		public function getnombre_categoria() {
			try {
				return $this->nombre_categoria;
			}catch(Exception $e) {
				return null;
			}
		}
		public function getpeso_categoria() {
			try {
				return $this->peso_categoria;
			}catch(Exception $e) {
				return null;
			}
		}
		public function getorden() {
			try {
				return $this->orden;
			}catch(Exception $e) {
				return null;
			}
		}	
	
		//mutadores
		public function setcodigo_categoria($codigo_categoria) {
			try {
				$this->codigo_categoria = $codigo_categoria;
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

		public function setnombre_categoria($nombre_categoria) {
			try {
				$this->nombre_categoria = $nombre_categoria;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setpeso_categoria($peso_categoria) {
			try {
				$this->peso_categoria = $peso_categoria;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setorden($orden) {
			try {
				$this->orden = $orden;
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