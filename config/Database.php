<?php
	class Database {
		//atributos de la clase
		private $conexion;

		//constructor de la clase de conexion
		function __construct() {
		 	try {
		 		$mysqli = @mysqli_connect(servidorMysql, usuarioMysql, passwordMysql, databaseMysql);
				if(!$mysqli) {
					if(ambiente == 'DEV') { echo '<strong>DATABASE@DATABASE.PHP:</strong> Falló la conexión contra la base de datos: <em><b>Mysql dijo</b>: '.mysqli_connect_error()."</em> <br />"; }
					return false;
				}else{
					$this->conexion = $mysqli;
					return true;
				}
			}catch(Exception $e) {
				if(ambiente == 'DEV') { echo $e->getMessage(); }
				return false;
			}
		}

		public function getConexion() {
			return $this->conexion;
		}

	}
?>