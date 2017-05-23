<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_actividad_usuario
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_actividad_usuario extends MY_Model {

	const ID_ACTIVIDAD = "id_actividad";
	const ID_PROYECTO = "id_proyecto";
	const ID_USUARIO = "id_usuario";
	const COLUMNAS_SELECT = "actividad_usuario.id_actividad, actividad_usuario.id_proyecto, actividad_usuario.id_usuario";
	const NOMBRE_TABLA = "actividad_usuario";

	public function __construct() {
		parent::__construct();
	}

	public function select_actividad_usuario($id_actividad = FALSE, $id_proyecto = FALSE, $id_usuario = FALSE) {
		$actividad_usuario = FALSE;

		if ($id_actividad && $id_proyecto && $id_usuario) {
			$this->db->select(self::COLUMNAS_SELECT);

			$this->db->from(self::NOMBRE_TABLA);

			$this->db->where(self::ID_ACTIVIDAD, $id_actividad);
			$this->db->where(self::ID_PROYECTO, $id_proyecto);
			$this->db->where(self::ID_USUARIO, $id_usuario);

			$query = $this->db->get();

			$actividad_usuario = $this->return_row($query);
		}

		return $actividad_usuario;
	}

	public function select_actividades_usuario_de_actividad($id_actividad = FALSE) {
		$actividades_usuario = FALSE;

		if ($id_actividad) {
			$this->db->select(self::COLUMNAS_SELECT);

			$this->db->from(self::NOMBRE_TABLA);

			$this->db->where(self::ID_ACTIVIDAD, $id_actividad);

			$query = $this->db->get();

			$actividades_usuario = $this->return_result($query);
		}

		return $actividades_usuario;
	}

	public function insert_actividad_usuario($id_actividad = FALSE, $id_proyecto = FALSE, $id_usuario = FALSE) {
		$insertado = FALSE;

		if ($id_actividad && $id_proyecto && $id_usuario) {
			$this->db->trans_start();

			$actividad_usuario = $this->select_actividad_usuario($id_actividad, $id_proyecto, $id_usuario);

			if (!$actividad_usuario) {

				$datos = array(
					self::ID_ACTIVIDAD => $id_actividad,
					self::ID_PROYECTO => $id_proyecto,
					self::ID_USUARIO => $id_usuario
				);

				$this->db->set($datos);

				$insertado = $this->db->insert(self::NOMBRE_TABLA);
			}

			$this->db->trans_complete();
		}

		return $insertado;
	}

	public function delete_actividad_usuario($id_actividad = FALSE, $id_proyecto = FALSE, $id_usuario = FALSE) {
		$eliminado = FALSE;

		if ($id_actividad && $id_proyecto && $id_usuario) {
			$this->db->trans_start();

			$this->db->where(self::ID_ACTIVIDAD, $id_actividad);
			$this->db->where(self::ID_PROYECTO, $id_proyecto);
			$this->db->where(self::ID_USUARIO, $id_usuario);

			$eliminado = $this->db->delete(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $eliminado;
	}

}
