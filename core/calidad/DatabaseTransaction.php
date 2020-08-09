<?php
	class DatabaseTransaction {
		private $consulta;
		private $conexion;
		private $resultado;

		public function __construct() {
		}


		public function getConsulta() {
			return $this->consulta;
		}

		public function setConsulta($consulta) {
			try {
				$this->consulta = $consulta;
				return true;
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo '<strong>DATABASE@DATABASETRANSACTION.PHP:</strong> Ha ocurrido un error al recibir la cadena de consulta: '.$e->getMessage()." <br />"; }
				return false;
			}
		}

		public function getResultado() {
			try {
				return $this->resultado;
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo '<strong>DATABASE@DATABASETRANSACTION.PHP:</strong> Ha ocurrido un error al recibir la cadena de consulta: '.$e->getMessage()." <br />"; }
				return null;
			}
		}


		public function conectar($fuente = "") {
			$this->conexion = new Database();
		}

		public function iniciarTransaccion() {
			if($this->conexion->getConexion()) {
				return $this->conexion->getConexion()->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
			}else{
				if(ambiente == 'DEV') { echo "<strong>DATABASE@DATABASETRANSACTION.PHP:</strong> Imposible ejecutar acciones contra la base de datos! La base de datos no responde o rechazó la conexión. <br />"; }
				return false;
			}
		}

		public function confirmar() {
			if($this->conexion->getConexion()) {
				return $this->conexion->getConexion()->commit();
			}else{
				if(ambiente == 'DEV') { echo "<strong>DATABASE@DATABASETRANSACTION.PHP:</strong> No se pueden confirmar los cambios porque falló la conexión contra la base de datos. <br />"; }
				return false;
			}
		}

		public function deshacer() {
			if($this->conexion->getConexion()) {
				return $this->conexion->getConexion()->rollback();
			}else{
				if(ambiente == 'DEV') { echo "<strong>DATABASE@DATABASETRANSACTION.PHP:</strong> No se pueden deshacer los cambios porque falló la conexión contra la base de datos. <br />"; }
				return false;
			}
		}

		public function cerrar() {
			if($this->conexion->getConexion()) {
				return $this->conexion->getConexion()->close();
			}else{
				if(ambiente == 'DEV') { echo "<strong>DATABASE@DATABASETRANSACTION.PHP:</strong> No se puede cerrar la conexión contra la base de datos porque falló la conexión contra la base de datos. <br />"; }
				return false;
			}
		}

		public function ejecutar($consulta, $fuente = "") {
			try {
				if($this->setConsulta($consulta)) {
					$this->conectar();
					if($this->conexion->getConexion()) {
						if($this->conexion) {
							$this->resultado = $this->conexion->getConexion()->query($consulta);
							$this->confirmar();
							return true;
						}else{
							$this->deshacer();
							return false;
						}
					}else{
						if(ambiente == 'DEV') { echo "<strong>DATABASE@DATABASETRANSACTION.PHP:</strong> Imposible ejecutar acciones contra la base de datos! La base de datos no responde o rechazó la conexión. <br />"; }
						return false;
					}
				}else{
					if(ambiente == 'DEV') { echo "<strong>DATABASE@DATABASETRANSACTION.PHP:</strong> Falló el seteo de la cadena de la consulta. <br />"; }
					return false;
				}
			}catch(Exception $e) {
				$this->deshacer();
				if(ambiente == 'DEV') { echo "<strong>DATABASE@DATABASETRANSACTION.PHP:</strong> No se pudoo ejecutar la consulta: ".$e->getMessage()." <br />"; }
				return false;
			}
		}

		public function cantidadResultados() {
			try {
				if($this->conexion->getConexion()) {
					if($this->getResultado() != null) {
						return $this->getResultado()->num_rows;
					}else{
						return 0;
					}
				}else{
					if(ambiente == 'DEV') { echo "<strong>DATABASE@DATABASETRANSACTION.PHP:</strong> La base de datos rechazó la conexión o la conexión se perdió contra el servidor y no se completó el conteo de registros. <br />"; }
					return null;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo "<strong>DATABASE@DATABASETRANSACTION.PHP:</strong> Fallo el conteo de registros afectados: ".$e->getMessage().". <br />"; }
				return null;
			}
		}

		public function resultados() {
			try {
				if($this->conexion->getConexion()) {
					if($this->getResultado() != null) {
						return $this->getResultado()->fetch_array(MYSQLI_ASSOC);
					}else{
						return null;
					}
				}else{
					if(ambiente == 'DEV') { echo "<strong>DATABASE@DATABASETRANSACTION.PHP:</strong> La base de datos rechazó la conexión o la conexión se perdió contra el servidor y es imposible retornar resultados. <br />"; }
					return null;
				}
			}catch(Exception $e) {
				return null;
			}
		}

	}
?>