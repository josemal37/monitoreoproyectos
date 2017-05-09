<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_meta_efecto
 *
 * @author Jose
 */
class Modelo_meta_efecto extends MY_Model {

	const ID = "id";
	const ID_INDICADOR_EFECTO = "id_indicador_efecto";
	const CANTIDAD = "cantidad";
	const UNIDAD = "unidad";
	const COLUMNAS_SELECT = "meta_indicador_efecto.id, meta_indicador_efecto.id_indicador_efecto, meta_indicador_efecto.cantidad, meta_indicador_efecto.unidad";
	const COLUMNAS_SELECT_OTRA_TABLA = "meta_indicador_efecto.cantidad, meta_indicador_efecto.unidad";
	const NOMBRE_TABLA = "meta_indicador_efecto";

	public function __construct() {
		parent::__construct();
	}

	public function insert_meta_efecto_st($id_indicador_efecto = FALSE, $cantidad = FALSE, $unidad = "") {
		$insertado = FALSE;

		if ($id_indicador_efecto && $cantidad && $unidad) {
			$datos = array(
				self::ID_INDICADOR_EFECTO => $id_indicador_efecto,
				self::CANTIDAD => $cantidad,
				self::UNIDAD => $unidad
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);
		}

		return $insertado;
	}

	public function delete_meta_de_indicador_efecto_st($id_indicador_efecto = FALSE) {
		$eliminado = FALSE;

		if ($id_indicador_efecto) {
			$this->db->where(self::ID_INDICADOR_EFECTO, $id_indicador_efecto);

			$eliminado = $this->db->delete(self::NOMBRE_TABLA);
		}

		return $eliminado;
	}

}
