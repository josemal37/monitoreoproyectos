<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_producto
 *
 * @author Jose
 */
class Modelo_producto extends MY_Model {

	const ID = "id";
	const ID_EFECTO = "id_efecto";
	const DESCRIPCION = "descripcion";
	const COLUMNAS_SELECT = "producto.id, producto.id_efecto, producto.descripcion";
	const COLUMNAS_SELECT_PARA_PROYECTO = "producto.id as id_producto, producto.descripcion as descripcion_producto";
	const NOMBRE_TABLA = "producto";

	public function __construct() {
		parent::__construct();
	}

	public function insert_producto($id_efecto = FALSE, $descripcion = "") {
		$insertado = FALSE;

		if ($id_efecto && $descripcion != "") {
			$this->db->trans_start();

			$datos = array(
				self::ID_EFECTO => $id_efecto,
				self::DESCRIPCION => $descripcion
			);
			
			$this->db->set($datos);
			
			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $insertado;
	}

}
