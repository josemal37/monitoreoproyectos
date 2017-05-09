<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_indicador_impacto
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_indicador_impacto extends MY_Model {

	const ID = "id";
	const ID_PROYECTO = "id_proyecto";
	const DESCRIPCION = "descripcion";
	const COLUMNAS_SELECT = "indicador_impacto.id, indicador_impacto.descripcion";
	const COLUMNAS_SELECT_OTRA_TABLA = "indicador_impacto.id as id_indicador_impacto, indicador_impacto.descripcion as descripcion_indicador_impacto";
	const NOMBRE_TABLA = "indicador_impacto";

	public function __construct() {
		parent::__construct();
	}

	public function select_indicadores_impacto_de_proyecto($id_proyecto = FALSE) {
		$indicadores = FALSE;

		if ($id_proyecto) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID_PROYECTO, $id_proyecto);

			$this->db->select(Modelo_meta_impacto::COLUMNAS_SELECT_OTRA_TABLA);
			$this->db->join(Modelo_meta_impacto::NOMBRE_TABLA, Modelo_meta_impacto::NOMBRE_TABLA . "." . Modelo_meta_impacto::ID_INDICADOR_IMPACTO . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");

			$query = $this->db->get();

			$indicadores = $this->return_result($query);
		}

		return $indicadores;
	}

	public function select_indicador_impacto_de_proyecto($id_indicador_impacto, $id_proyecto) {
		$indicador = FALSE;

		if ($id_indicador_impacto && $id_proyecto) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id_indicador_impacto);
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID_PROYECTO, $id_proyecto);

			$this->db->select(Modelo_meta_impacto::COLUMNAS_SELECT_OTRA_TABLA);
			$this->db->join(Modelo_meta_impacto::NOMBRE_TABLA, Modelo_meta_impacto::NOMBRE_TABLA . "." . Modelo_meta_impacto::ID_INDICADOR_IMPACTO . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");

			$query = $this->db->get();

			$indicador = $this->return_row($query);
		}

		return $indicador;
	}

	public function insert_indicador_impacto($id_proyecto = FALSE, $descripcion = "", $con_meta = FALSE, $cantidad = FALSE, $unidad = "") {
		$insertado = FALSE;

		if ($id_proyecto && $descripcion != "") {
			$this->db->trans_start();

			$datos = array(
				self::ID_PROYECTO => $id_proyecto,
				self::DESCRIPCION => $descripcion
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			if ($insertado && $con_meta) {
				$id_indicador_impacto = $this->db->insert_id();

				$this->Modelo_meta_impacto->insert_meta_impacto_sin_transaccion($id_indicador_impacto, $cantidad, $unidad);
			}

			$this->db->trans_complete();
		}

		return $insertado;
	}

	public function update_indicador_impacto($id = FALSE, $descripcion = "", $con_meta = FALSE, $cantidad = FALSE, $unidad = "") {
		$actualizado = FALSE;

		if ($id && $descripcion != "") {
			$this->db->trans_start();

			$datos = array(
				self::DESCRIPCION => $descripcion
			);

			$this->db->set($datos);

			$this->db->where(self::ID, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->update_meta_impacto($con_meta, $id, $cantidad, $unidad);

			$this->db->trans_complete();
		}

		return $actualizado;
	}

	private function update_meta_impacto($con_meta, $id, $cantidad, $unidad) {
		$this->Modelo_meta_impacto->delete_meta_impacto_de_indicador($id);

		if ($con_meta) {
			$this->Modelo_meta_impacto->insert_meta_impacto($id, $cantidad, $unidad);
		}
	}

	public function delete_indicador_impacto($id = FALSE) {
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
