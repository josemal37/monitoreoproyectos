<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_rol_proyecto
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_rol_proyecto extends MY_Model {

	const ID = "id";
	const NOMBRE = "nombre";
	const COLUMNAS_SELECT = "rol_proyecto.id, rol_proyecto.nombre";
	const NOMBRE_TABLA = "rol_proyecto";
	//roles
	const ROL_COORDINADOR = "coordinador";
	const ROL_TRABAJADOR = "trabajador";

	public function __construct() {
		parent::__construct();
	}

	public function select_roles() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		$query = $this->db->get();

		$roles = $this->return_result($query);

		return $roles;
	}

	public function select_id_rol_coordinador() {
		return $this->select_id_rol(self::ROL_COORDINADOR);
	}
	
	public function select_id_rol_trabajador() {
		return $this->select_id_rol(self::ROL_TRABAJADOR);
	}

	private function select_id_rol($nombre_rol) {
		$id = FALSE;

		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->where(self::NOMBRE, $nombre_rol);

		$query = $this->db->get();

		$rol = $this->return_row($query);

		if ($rol) {
			$id = $rol->id;
		}

		return $id;
	}

}
