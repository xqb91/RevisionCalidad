<?php
	class Evaluador {
		//columnas de la tabla
		private $rut_evaluador;
		private $nombre_evaluador;
		private $usuario ;
		private $contrasena;
		private $fecha_creacion;
		private $estado; 
		private $admin;
		private $supervisor;
		private $cobranza;
		private $area;


		//Constructor
		//Obtiene un arreglo que es generado de forma automática por MySQL
		//mediante un mysql_result, debe entregarse un arreglo de tipo asociativo
		public function __construct($arreglo) {
			$this->rut_evaluador	= $arreglo['rut_evaluador'];
			$this->nombre_evaluador	= $arreglo['nombre_evaluador'];
			$this->usuario			= $arreglo['usuario'];
			$this->contrasena		= $arreglo['contrasena'];
			$this->fecha_creacion	= $arreglo['fecha_creacion'];
			$this->estado			= $arreglo['estado'];
			$this->admin 			= $arreglo['admin'];
			$this->supervisor		= $arreglo['supervisor'];
			$this->cobranza			= $arreglo['cobranza'];
			$this->area 			= $arreglo['area'];
		}

		//accesadores
		public function getrut_evaluador() {
			try {
				return $this->rut_evaluador;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getnombre_evaluador() {
			try {
				return $this->nombre_evaluador;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getusuario() {
			try {
				return $this->usuario;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getcontrasena() {
			try {
				return $this->contrasena;
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

		public function getestado() {
			try {
				return $this->estado;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getAdmin() {
			try {
				if($this->admin == 1) {
					return true;
				}else{
					return false;
				}
			}catch(Exception $e) {
				return false;
			}
		}

		public function getSupervisor() {
			try {
				if($this->supervisor == 1) {
					return true;
				}else{
					return false;
				}
			}catch(Exception $e) {
				return false;
			}
		}

		public function getCobranza() {
			try {
				if($this->cobranza == 1) {
					return true;
				}else{
					return false;
				}
			}catch(Exception $e) {
				return false;
			}
		}

		public function getArea() {
			try {
				return $this->area;
			}catch(Exception $e) {
				return null;
			}
		}

		//mutadores
		public function setrut_evaluador($rut_evaluador) {
			try {
				$this->rut_evaluador = $rut_evaluador;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setnombre_evaluador($nombre_evaluador) {
			try {
				$this->nombre_evaluador = $nombre_evaluador;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}
														
		public function setusuario($usuario) {
			try {
				$this->usuario = $usuario;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}
			
		public function setcontrasena($contrasena) {
			try {
				$this->contrasena = $contrasena;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setfecha_creacion($fecha_creacion) {
			try {
				$this->fecha_creacion = $fecha_creacion;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setestado($estado) {
			try {
				$this->estado = $estado;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setAdmin($admin) {
			try 
			{
				$this->admin = $admin;
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
