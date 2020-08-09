<?php
	class LogDesbloqueo {
		private $id;
		private $fecha;
		private $evaluador;
		private $ejecutivo;
		private $periodo;

		public function __construct($arreglo) {
			$this->id			= $arreglo['id'];
			$this->fecha		= $arreglo['fecha'];
			$this->evaluador	= $arreglo['evaluador'];
			$this->ejecutivo	= $arreglo['ejecutivo'];
			$this->periodo		= $arreglo['periodo'];
		}


		public function getid() {
			return $this->id;
		}

		public function getfecha() {
			return $this->fecha;
		}

		public function getevaluador() {
			return $this->evaluador;
		}

		public function getejecutivo() {
			return $this->ejecutivo;
		}

		public function getperiodo() {
			return $this->periodo;
		}


		public function setid ($id) {
			try{
				$this->id = $id;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setfecha ($fecha) {
			try{
				$this->fecha = $fecha;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setevaluador ($evaluador) {
			try{
				$this->evaluador = $evaluador;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setejecutivo ($ejecutivo) {
			try{
				$this->ejecutivo = $ejecutivo;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}

		public function setperiodo  ($periodo) {
			try{
				$this->periodo = $periodo;
				return true;
			}catch(Exception $e) {
				return false;
			}
		}



	}
?>