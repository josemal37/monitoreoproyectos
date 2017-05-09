<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_resultado
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_resultado extends MY_Model {

	const ID = "id";
	const ID_PROYECTO = "id_proyecto";
	const NOMBRE = "nombre";
	const COLUMNAS_SELECT = "resultado.id, resultado.id_proyecto, resultado.nombre";
	const COLUMNAS_SELECT_PARA_PROYECTO = "resultado.id as id_resultado, resultado.nombre as nombre_resultado";
	const COLUMNAS_SELECT_OTRA_TABLA = "resultado.nombre as nombre_resultado, resultado.id_proyecto";
	const NOMBRE_TABLA = "resultado";

	public function __construct() {
		parent::__construct();
	}

	public function select_resultado_de_proyecto($id_resultado = FALSE, $id_proyecto = FALSE) {
		$resultado = FALSE;

		if ($id_resultado && $id_proyecto) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);

			$this->db->where(self::ID, $id_resultado);

			$this->db->where(self::ID_PROYECTO, $id_proyecto);

			$query = $this->db->get();

			$resultado = $this->return_row($query);
		}

		return $resultado;
	}

	public function insert_resultado($id_proyecto = FALSE, $nombre = "") {
		$insertado = FALSE;

		if ($id_proyecto && $nombre != "") {
			$this->db->trans_start();

			$datos = array(
				self::ID_PROYECTO => $id_proyecto,
				self::NOMBRE => $nombre
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $insertado;
	}

	public function update_resultado($id = FALSE, $nombre = "") {
		$actualizado = FALSE;

		if ($id && $nombre != "") {
			$this->db->trans_start();

			$datos = array(
				self::NOMBRE => $nombre
			);

			$this->db->set($datos);

			$this->db->where(self::ID, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $actualizado;
	}

	public function delete_resultado($id = FALSE) {
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
