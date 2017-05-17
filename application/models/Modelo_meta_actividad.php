<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_meta_actividad
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_meta_actividad extends MY_Model {

	const ID = "id";
	const ID_ACTIVIDAD = "id_actividad";
	const CANTIDAD = "cantidad";
	const UNIDAD = "unidad";
	const COLUMNAS_SELECT = "meta_actividad.id, meta_actividad.id_actividad, meta_actividad.cantidad, meta_actividad.unidad";
	const COLUMNAS_SELECT_OTRA_TABLA = "meta_actividad.id as id_meta_actividad, meta_actividad.cantidad, meta_actividad.unidad";
	const NOMBRE_TABLA = "meta_actividad";

	public function __construct() {
		parent::__construct();
	}

	public function insert_meta_actividad_st($id_actividad = FALSE, $cantidad = FALSE, $unidad = "") {
		$insertado = FALSE;

		if ($id_actividad && $cantidad && $unidad != "") {
			$datos = array(
				self::ID_ACTIVIDAD => $id_actividad,
				self::CANTIDAD => $cantidad,
				self::UNIDAD => $unidad
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);
		}

		return $insertado;
	}

}
