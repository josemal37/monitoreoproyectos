<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_efecto
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_efecto extends MY_Model {

	const ID = "id";
	const ID_RESULTADO = "id_resultado";
	const DESCRIPCION = "descripcion";
	const COLUMNAS_SELECT = "efecto.id, efecto.id_resultado, efecto.descripcion";
	const COLUMNAS_SELECT_PARA_PROYECTO = "efecto.id as id_efecto, efecto.descripcion as descripcion_efecto";
	const NOMBRE_TABLA = "efecto";

	public function __construct() {
		parent::__construct();
	}

	public function select_efecto_de_proyecto($id = FALSE, $id_proyecto = FALSE) {
		$efecto = FALSE;

		if ($id && $id_proyecto) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id);

			$this->db->join(Modelo_resultado::NOMBRE_TABLA, Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID . " = " . self::NOMBRE_TABLA . "." . self::ID_RESULTADO);
			$this->db->where(Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID_PROYECTO, $id_proyecto);

			$query = $this->db->get();

			$efecto = $this->return_row($query);
		}

		return $efecto;
	}

	public function insert_efecto($id_resultado = FALSE, $descripcion = "") {
		$insertado = FALSE;

		if ($id_resultado && $descripcion != "") {
			$this->db->trans_start();

			$datos = array(
				self::ID_RESULTADO => $id_resultado,
				self::DESCRIPCION => $descripcion
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $insertado;
	}

	public function update_efecto($id = FALSE, $descripcion = "") {
		$actualizado = FALSE;

		if ($id && $descripcion != "") {
			$this->db->trans_start();

			$datos = array(
				self::DESCRIPCION => $descripcion
			);

			$this->db->set($datos);

			$this->db->where(self::ID, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $actualizado;
	}

	public function delete_efecto($id = FALSE) {
		$eliminado = FALSE;

		if ($id) {
			$this->db->trans_start();

			$this->db->where(self::ID, $id);

			$eliminado = $this->db->delete(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $eliminado;
	}

}
