<?php
	include(dirController."CategoriaController.php");
	class ItemEvaluacion {
		//columnas de la tabla
	     private $codigo_item ; 
	     private $codigo_categoria;
	     private $nombre_item;
	     private $orden;
	     private $obligatorio;
	     private $valor0;
	     private $valor05;
	     private $valor1;
	     private $mostrar;

	     //foreign objects
	     private $codigo_area;
	     private $nombre_categoria;
	     private $peso_categoria;
	     private $orden_categoria;

		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($arreglo) {
			$this->codigo_item		= $arreglo['codigo_item'];
			$this->codigo_categoria	= $arreglo['codigo_categoria'];
			$this->nombre_item		= $arreglo['nombre_item'];
			$this->orden			= $arreglo['orden'];
			$this->setCategoria();
			$this->valor0 			= $arreglo['valor_0'];
			$this->valor05 			= $arreglo['valor_05'];
			$this->valor1 			= $arreglo['valor_1'];
			$this->mostrar 			= $arreglo['mostrar'];
			$this->obligatorio 		= $arreglo['obligatorio'];
		}

		//accesadores
		public function getcodigo_item() {
			try {
				return $this->codigo_item;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getcodigo_categoria() {
			try {
				return $this->codigo_categoria;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getnombre_item() {
			try {
				return $this->nombre_item;
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


		public function getcategoria() {
			try {
				return $this->categoria;
			}catch(Exception $e) {
				return null;
			}
		}


		public function getObligatorio() {
			try {
				return $this->obligatorio;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getValor0() {
			try {
				return $this->valor0;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getValor05() {
			try {
				return $this->valor05;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getValor1() {
			try {
				return $this->valor1;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getMostrar() {
			try {
				return $this->mostrar;
			}catch(Exception $e) {
				return null;
			}
		}

		//mutadores
		public function setcodigo_item($codigo_item) {
			try {
				$this->codigo_item = $codigo_item;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setcodigo_categoria($codigo_categoria) {
			try {
				$this->codigo_categoria = $codigo_categoria;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}		

		public function setnombre_item($nombre_item) {
			try {
				$this->nombre_item = $nombre_item;
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

		public function setCategoria() {
			try {
				$ct = new CategoriaController();
				$arreglo = $ct->listarPorCodigo($this->getcodigo_categoria());
				if($arreglo == null) {
					$this->codigo_categoria = null;
					$this->codigo_area = null;
					$this->nombre_categoria = null;
					$this->peso_categoria = null;
					$this->orden_categoria = null;
					return false;
				}else {
					$this->codigo_area 			= $arreglo->getcodigo_area();;
					$this->nombre_categoria 	= $arreglo->getnombre_categoria();
					$this->peso_categoria 		= $arreglo->getpeso_categoria();
					$this->orden_categoria 		= $arreglo->getorden();
					return true;
				}
			}catch(Exception $e) {
				return false;
			}
		}	


		public function setObligatorio($obligatorio) {
			try {
				$this->obligatorio = $obligatorio;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setValor0($valor) {
			try {
				$this->valor0 = $valor;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setValor05($valor) {
			try {
				$this->valor05 = $valor;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setValor1($valor) {
			try {
				$this->valor1 = $valor;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setMostrar($valor) {
			try {
				$this->mostrar = $valor;
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