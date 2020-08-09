<?php
	class ListPeriodo {
		private $periodos;
	
		public function __construct() {
			$array = null;
			for($i=0; $i<=3; $i++) {
				$date = new DateTime("-".$i." months");
				$array[$i] = $date->format("Y-m");
			}
			$this->periodos = $array;
		}

		public function serializar() {
	        return json_encode(get_object_vars($this), JSON_FORCE_OBJECT);
		}
	}

	$val = new ListPeriodo();
	echo $val->serializar();
?>