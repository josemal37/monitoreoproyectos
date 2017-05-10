<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_meta_producto
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_meta_producto extends MY_Model {

	const ID = "id";
	const ID_INDICADOR_PRODUCTO = "id_indicador_producto";
	const CANTIDAD = "cantidad";
	const UNIDAD = "unidad";
	const COLUMNAS_SELECT = "meta_indicador_producto.id, meta_indicador_producto.id_indicador_producto, meta_indicador_producto.cantidad, meta_indicador_producto.unidad";
	const COLUMNAS_SELECT_OTRA_TABLA = "meta_indicador_producto.id as id_meta_indicador_producto, meta_indicador_producto.cantidad, meta_indicador_producto.unidad";
	const NOMBRE_TABLA = "meta_indicador_producto";

	public function __construct() {
		parent::__construct();
	}

	public function insert_meta_indicador_producto_st($id_indicador_producto = FALSE, $cantidad = FALSE, $unidad = "") {
		$insertado = FALSE;

		if ($id_indicador_producto && $cantidad && $unidad) {
			$datos = array(
				self::ID_INDICADOR_PRODUCTO => $id_indicador_producto,
				self::CANTIDAD => $cantidad,
				self::UNIDAD => $unidad
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);
		}

		return $insertado;
	}
	
	public function delete_meta_de_indicador_producto_st($id_indicador_producto = FALSE) {
		$eliminado = FALSE;
		
		if ($id_indicador_producto) {
			$this->db->where(self::ID_INDICADOR_PRODUCTO, $id_indicador_producto);
			
			$eliminado = $this->db->delete(self::NOMBRE_TABLA);
		}
		
		return $eliminado;
	}

}
