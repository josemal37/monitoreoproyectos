<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_proyecto_usuario
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_proyecto_usuario extends MY_Model {

	const ID_USUARIO = "id_usuario";
	const ID_PROYECTO = "id_proyecto";
	const ID_ROL_PROYECTO = "id_rol_proyecto";
	const COLUMNAS_SELECT = "proyecto_usuario.id_usuario, proyecto_usuario.id_proyecto, proyecto_usuario.id_rol_proyecto";
	const NOMBRE_TABLA = "proyecto_usuario";

	public function __construct() {
		parent::__construct();
	}

	public function select_registro($id_usuario = FALSE, $id_proyecto = FALSE, $id_rol_proyecto = FALSE) {

		$registro = FALSE;

		if ($id_usuario && $id_proyecto) {
			$this->db->select(self::COLUMNAS_SELECT);

			$this->db->from(self::NOMBRE_TABLA);

			$this->db->where(self::ID_USUARIO, $id_usuario);
			$this->db->where(self::ID_PROYECTO, $id_proyecto);

			if ($id_rol_proyecto) {
				$this->db->where(self::ID_ROL_PROYECTO, $id_rol_proyecto);
			}

			$query = $this->db->get();

			$registro = $this->return_row($query);
		}

		return $registro;
	}

	public function insert_proyecto_usuario($id_usuario = FALSE, $id_proyecto = FALSE, $id_rol_proyecto = FALSE) {
		$insertado = FALSE;

		if ($id_usuario && $id_proyecto && $id_rol_proyecto) {
			$this->db->trans_start();

			$insertado = $this->insert_proyecto_usuario_st($id_usuario, $id_proyecto, $id_rol_proyecto);

			$this->db->trans_complete();
		}

		return $insertado;
	}

	private function insert_proyecto_usuario_st($id_usuario = FALSE, $id_proyecto = FALSE, $id_rol_proyecto = FALSE) {
		$insertado = FALSE;

		if ($id_usuario && $id_proyecto && $id_rol_proyecto) {
			$registro = $this->select_registro($id_usuario, $id_proyecto);

			if (!$registro) {

				$datos = array(
					self::ID_USUARIO => $id_usuario,
					self::ID_PROYECTO => $id_proyecto,
					self::ID_ROL_PROYECTO => $id_rol_proyecto
				);

				$this->db->set($datos);

				$insertado = $this->db->insert(self::NOMBRE_TABLA);
			}
		}

		return $insertado;
	}

	public function update_proyecto_usuario($id_usuario = FALSE, $id_proyecto = FALSE, $id_rol_proyecto = FALSE) {
		$actualizado = FALSE;

		if ($id_usuario && $id_proyecto && $id_rol_proyecto) {
			$this->db->trans_start();

			$this->delete_proyecto_usuario_st($id_usuario, $id_proyecto);
			$actualizado = $this->insert_proyecto_usuario_st($id_usuario, $id_proyecto, $id_rol_proyecto);

			$this->db->trans_complete();
		}

		return $actualizado;
	}

	private function delete_proyecto_usuario_st($id_usuario = FALSE, $id_proyecto = FALSE) {
		$eliminado = FALSE;

		if ($id_usuario && $id_proyecto) {
			$this->db->where(self::ID_USUARIO, $id_usuario);
			$this->db->where(self::ID_PROYECTO, $id_proyecto);

			$eliminado = $this->db->delete(self::NOMBRE_TABLA);
		}

		return $eliminado;
	}

}
