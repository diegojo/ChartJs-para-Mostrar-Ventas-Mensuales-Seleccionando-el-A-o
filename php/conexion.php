<?php
	include_once('config.php');
	class Model{
		protected $db;
		public function __construct(){
			$this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if($this->db->connect_errno){
				exit();
			}
			$this->db->set_charset(DB_CHARSET);
		}
		public function obtenerAnios() {
			$sql = "SELECT DISTINCT DATE_FORMAT(fecha_reg, '%Y') as fecha_reg FROM productos ORDER BY fecha_reg DESC";
			$resultado = $this->db->query($sql);
	
			if ($resultado) {
				return $resultado;
			} else {
				return false;
			}
		}
		public function cerrarConexion() {
			$this->db->close();
		}
	}
	
?>