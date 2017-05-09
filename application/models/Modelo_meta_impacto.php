<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_meta_impacto
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_meta_impacto extends MY_Model {

	const ID = "id";
	const ID_INDICADOR_IMPACTO = "id_indicador_impacto";
	const CANTIDAD = "cantidad";
	const UNIDAD = "unidad";
	const COLUMNAS_SELECT = "meta_impacto.id, meta_impacto.id_indicador_impacto, meta_impacto.cantidad, meta_impacto.unidad";
	const COLUMNAS_SELECT_OTRA_TABLA = "meta_impacto.id as id_meta_impacto, meta_impacto.cantidad, meta_impacto.unidad";
	const NOMBRE_TABLA = "meta_impacto";

	public function __construct() {
		parent::__construct();
	}

	public function insert_meta_impacto($id_indicador_impacto = FALSE, $cantidad = FALSE, $unidad = "") {
		$insertado = FALSE;

		if ($id_indicador_impacto && $cantidad && $unidad != "") {
			$this->db->trans_start();

			$datos = array(
				self::ID_INDICADOR_IMPACTO => $id_indicador_impacto,
				self::CANTIDAD => $cantidad,
				self::UNIDAD => $unidad
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $insertado;
	}

	public function insert_meta_impacto_st($id_indicador_impacto = FALSE, $cantidad = FALSE, $unidad = "") {
		$insertado = FALSE;

		if ($id_indicador_impacto && $cantidad && $unidad != "") {
			$datos = array(
				self::ID_INDICADOR_IMPACTO => $id_indicador_impacto,
				self::CANTIDAD => $cantidad,
				self::UNIDAD => $unidad
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);
		}

		return $insertado;
	}

	public function update_meta_impacto_st($id = FALSE, $cantidad = FALSE, $unidad = "") {
		$actualizado = FALSE;

		if ($id && $cantidad && $unidad != "") {
			$datos = array(
				self::CANTIDAD => $cantidad,
				self::UNIDAD => $unidad
			);

			$this->db->set($datos);

			$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);
		}

		return $actualizado;
	}

	public function delete_meta_impacto_st($id = FALSE) {
		$eliminado = FALSE;

		if ($id) {
			$this->db->where(self::ID, $id);

			$eliminado = $this->db->delete(self::NOMBRE_TABLA);
		}

		return $eliminado;
	}
	
	public function delete_meta_impacto_de_indicador($id_indicador_impacto = FALSE) {
		$eliminado = FALSE;
		
		if ($id_indicador_impacto) {
			$this->db->where(self::ID_INDICADOR_IMPACTO, $id_indicador_impacto);
			
			$eliminado = $this->db->delete(self::NOMBRE_TABLA);
		}
		
		return $eliminado;
	}

}
