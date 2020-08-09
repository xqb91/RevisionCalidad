<?php
	class RevEvaluacionStatus {

		private $id;
		private $tipo;
		private $numero_evaluacion;
		private $fecha;
		private $estado;
		private $usuario;
		private $observacion;


		public function __construct($array) {
			$this->id					= $array['id'];
			$this->tipo					= $array['tipo'];
			$this->numero_evaluacion	= $array['numero_evaluacion'];
			$this->fecha				= $array['fecha'];
			$this->estado				= $array['estado'];
			$this->usuario				= $array['usuario'];
			$this->observacion			= $array['observacion'];
		}

		public function getid() {
			try {
				return $this->id;
			}catch(Exception $e) {
				return null;
			}
		}

		public function gettipo() {
			try {
				return $this->tipo;
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

		public function getfecha() {
			try {
				return $this->fecha;
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

		public function getusuario() {
			try {
				return $this->usuario;
			}catch(Exception $e) {
				return null;
			}
		}

		public function getobservacion() {
			try {
				return $this->observacion;
			}catch(Exception $e) {
				return null;
			}
		}



		public function setid($id) {
			try {
				$this->id = $id;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function settipo($tipo) {
			try {
				$this->tipo = $tipo;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setnumero_evaluacion($numero_evaluacion) {
			try {
				$this->numero_evaluacion = $numero_evaluacion;
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

		public function setestado($estado) {
			try {
				$this->estado = $estado;
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

		public function setobservacion($observacion) {
			try {
				$this->observacion = $observacion;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}



	}
?>