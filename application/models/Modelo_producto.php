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
	
	public function select_productos_de_proyecto($id_proyecto = FALSE) {
		$producto = FALSE;

		if ($id_proyecto) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);

			$this->db->join(Modelo_efecto::NOMBRE_TABLA, Modelo_efecto::NOMBRE_TABLA . "." . Modelo_efecto::ID . " = " . Modelo_producto::NOMBRE_TABLA . "." . Modelo_producto::ID_EFECTO);
			$this->db->join(Modelo_resultado::NOMBRE_TABLA, Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID . " = " . Modelo_efecto::NOMBRE_TABLA . "." . Modelo_efecto::ID_RESULTADO);
			$this->db->where(Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID_PROYECTO, $id_proyecto);

			$query = $this->db->get();

			$producto = $this->return_result($query);
		}

		return $producto;
	}

	public function select_producto_de_proyecto($id_producto = FALSE, $id_proyecto = FALSE) {
		$producto = FALSE;

		if ($id_producto && $id_proyecto) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id_producto);

			$this->db->join(Modelo_efecto::NOMBRE_TABLA, Modelo_efecto::NOMBRE_TABLA . "." . Modelo_efecto::ID . " = " . Modelo_producto::NOMBRE_TABLA . "." . Modelo_producto::ID_EFECTO);
			$this->db->join(Modelo_resultado::NOMBRE_TABLA, Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID . " = " . Modelo_efecto::NOMBRE_TABLA . "." . Modelo_efecto::ID_RESULTADO);
			$this->db->where(Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID_PROYECTO, $id_proyecto);

			$query = $this->db->get();

			$producto = $this->return_row($query);
		}

		return $producto;
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

	public function update_producto($id = FALSE, $descripcion = "") {
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

	public function delete_producto($id = FALSE) {
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
