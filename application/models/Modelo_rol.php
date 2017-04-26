<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_rol
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_rol extends MY_Model {

	const ID = "id";
	const NOMBRE = "nombre";
	const COLUMNAS_SELECT = "rol_usuario.id, rol_usuario.nombre";
	const NOMBRE_TABLA = "rol_usuario";

	public function __construct() {
		parent::__construct();
	}
	
	public function select_rol($id = FALSE) {
		$rol = FALSE;
		
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::ID, $id);
			
			$query = $this->db->get();
			
			$rol = $this->return_row($query);
		}
		
		return $rol;
	}

}
