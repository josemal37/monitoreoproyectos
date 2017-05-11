<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_indicador_producto
 *
 * @author Jose
 */
class Modelo_indicador_producto extends MY_Model {

	const ID = "id";
	const ID_PRODUCTO = "id_producto";
	const DESCRIPCION = "descripcion";
	const COLUMNAS_SELECT = "indicador_producto.id, indicador_producto.id_producto, indicador_producto.descripcion";
	const NOMBRE_TABLA = "indicador_producto";
	//Tabla indicador producto efecto
	const ID_INDICADOR_PRODUCTO = "id_indicador_producto";
	const ID_INDICADOR_EFECTO = "id_indicador_efecto";
	const PORCENTAJE = "porcentaje";
	const COLUMNAS_SELECT_ASOC_EFECTO = "indicador_producto_efecto.porcentaje";
	const NOMBRE_TABLA_ASOC_EFECTO = "indicador_producto_efecto";

	public function __construct() {
		parent::__construct();
	}

	public function select_indicador_producto_de_proyecto($id_indicador_producto, $id_proyecto) {
		$indicador = FALSE;

		if ($id_indicador_producto && $id_proyecto) {
			$this->set_select_indicador_producto();
			$this->set_select_meta_indicador_producto();
			$this->set_select_indicador_efecto_asociado();
			$this->set_select_resultado_asociado();

			$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id_indicador_producto);

			$this->db->where(Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID_PROYECTO, $id_proyecto);

			$query = $this->db->get();

			$indicador = $this->return_row($query);
		}

		return $indicador;
	}

	public function select_indicadores_producto_de_producto($id_producto = FALSE) {
		$indicadores = FALSE;

		if ($id_producto) {
			$this->set_select_indicador_producto();
			$this->set_select_meta_indicador_producto();
			$this->set_select_indicador_efecto_asociado();

			$this->db->where(self::ID_PRODUCTO, $id_producto);

			$query = $this->db->get();

			$indicadores = $this->return_result($query);
		}

		return $indicadores;
	}

	private function set_select_indicador_producto() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
	}

	private function set_select_meta_indicador_producto() {
		$this->db->select(Modelo_meta_producto::COLUMNAS_SELECT_OTRA_TABLA);
		$this->db->join(Modelo_meta_producto::NOMBRE_TABLA, Modelo_meta_producto::NOMBRE_TABLA . "." . Modelo_meta_producto::ID_INDICADOR_PRODUCTO . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
	}

	private function set_select_indicador_efecto_asociado() {
		$this->db->select(self::COLUMNAS_SELECT_ASOC_EFECTO);
		$this->db->join(self::NOMBRE_TABLA_ASOC_EFECTO, self::NOMBRE_TABLA_ASOC_EFECTO . "." . self::ID_INDICADOR_PRODUCTO . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
		$this->db->select(Modelo_indicador_efecto::COLUMNAS_SELECT_OTRA_TABLA);
		$this->db->join(Modelo_indicador_efecto::NOMBRE_TABLA, Modelo_indicador_efecto::NOMBRE_TABLA . "." . Modelo_indicador_efecto::ID . " = " . self::NOMBRE_TABLA_ASOC_EFECTO . "." . self::ID_INDICADOR_EFECTO, "left");
	}

	private function set_select_producto_asociado() {
		$this->db->select(Modelo_producto::COLUMNAS_SELECT_PARA_PROYECTO);
		$this->db->join(Modelo_producto::NOMBRE_TABLA, Modelo_producto::NOMBRE_TABLA . "." . Modelo_producto::ID . " = " . self::NOMBRE_TABLA . "." . self::ID_PRODUCTO);
	}

	private function set_select_efecto_asociado() {
		$this->set_select_producto_asociado();
		$this->db->select(Modelo_efecto::COLUMNAS_SELECT_PARA_PROYECTO);
		$this->db->join(Modelo_efecto::NOMBRE_TABLA, Modelo_efecto::NOMBRE_TABLA . "." . Modelo_efecto::ID . " = " . Modelo_producto::NOMBRE_TABLA . "." . Modelo_producto::ID_EFECTO);
	}

	private function set_select_resultado_asociado() {
		$this->set_select_efecto_asociado();
		$this->db->select(Modelo_resultado::COLUMNAS_SELECT_OTRA_TABLA);
		$this->db->join(Modelo_resultado::NOMBRE_TABLA, Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID . " = " . Modelo_efecto::NOMBRE_TABLA . "." . Modelo_efecto::ID_RESULTADO);
	}

	public function insert_indicador_producto($id_producto = FALSE, $descripcion = "", $con_meta = FALSE, $cantidad = FALSE, $unidad = FALSE, $con_indicador_efecto = FALSE, $id_indicador_efecto = FALSE, $porcentaje = FALSE) {
		$insertado = FALSE;

		if ($id_producto && $descripcion != "") {
			$this->db->trans_start();

			$datos = array(
				self::ID_PRODUCTO => $id_producto,
				self::DESCRIPCION => $descripcion
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			$id_indicador_producto = $this->db->insert_id();

			if ($con_meta) {
				$this->Modelo_meta_producto->insert_meta_indicador_producto_st($id_indicador_producto, $cantidad, $unidad);
			}

			if ($con_indicador_efecto) {
				$this->asociar_indicador_producto_con_efecto($id_indicador_producto, $id_indicador_efecto, $porcentaje);
			}

			$this->db->trans_complete();
		}

		return $insertado;
	}

	public function update_indicador_producto($id_indicador_producto = FALSE, $descripcion = FALSE, $con_meta = FALSE, $cantidad = FALSE, $unidad = FALSE, $con_indicador_efecto = FALSE, $id_indicador_efecto = FALSE, $porcentaje = FALSE) {
		$actualizado = FALSE;

		if ($id_indicador_producto && $descripcion != "") {
			$this->db->trans_start();

			$datos = array(
				self::DESCRIPCION => $descripcion
			);

			$this->db->set($datos);

			$this->db->where(self::ID, $id_indicador_producto);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->Modelo_meta_producto->delete_meta_de_indicador_producto_st($id_indicador_producto);

			if ($con_meta) {
				$this->Modelo_meta_producto->insert_meta_indicador_producto_st($id_indicador_producto, $cantidad, $unidad);
			}

			$this->desasociar_indicador_producto_con_efecto($id_indicador_producto);

			if ($con_indicador_efecto) {
				$this->asociar_indicador_producto_con_efecto($id_indicador_producto, $id_indicador_efecto, $porcentaje);
			}

			$this->db->trans_complete();
		}

		return $actualizado;
	}

	private function asociar_indicador_producto_con_efecto($id_indicador_producto, $id_indicador_efecto, $porcentaje) {
		$asociado = FALSE;

		if ($id_indicador_producto && $id_indicador_efecto && $porcentaje) {
			$datos = array(
				self::ID_INDICADOR_PRODUCTO => $id_indicador_producto,
				self::ID_INDICADOR_EFECTO => $id_indicador_efecto,
				self::PORCENTAJE => $porcentaje
			);

			$this->db->set($datos);

			$asociado = $this->db->insert(self::NOMBRE_TABLA_ASOC_EFECTO);
		}

		return $asociado;
	}

	private function desasociar_indicador_producto_con_efecto($id_indicador_producto = FALSE) {
		$desasociado = FALSE;

		if ($id_indicador_producto) {
			$this->db->where(self::ID_INDICADOR_PRODUCTO, $id_indicador_producto);

			$desasociado = $this->db->delete(self::NOMBRE_TABLA_ASOC_EFECTO);
		}

		return $desasociado;
	}

	public function delete_indicador_producto($id = FALSE) {
		$eliminado = FALSE;

		if ($id) {
			$this->db->trans_start();

			$this->db->where(self::ID, $id);

			$this->db->delete(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $eliminado;
	}

}
