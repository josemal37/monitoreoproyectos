<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_indicador_efecto
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_indicador_efecto extends MY_Model {

	const ID = "id";
	const ID_EFECTO = "id_efecto";
	const DESCRIPCION = "descripcion";
	const COLUMNAS_SELECT = "indicador_efecto.id, indicador_efecto.id_efecto, indicador_efecto.descripcion";
	const COLUMNAS_SELECT_OTRA_TABLA = "indicador_efecto.id as id_indicador_efecto, indicador_efecto.descripcion as descripcion_indicador_efecto";
	const NOMBRE_TABLA = "indicador_efecto";
	//Tabla indicador efecto impacto
	const ID_INDICADOR_EFECTO = "id_indicador_efecto";
	const ID_INDICADOR_IMPACTO = "id_indicador_impacto";
	const PORCENTAJE = "porcentaje";
	const COLUMNAS_SELECT_ASOC_IMPACTO = "indicador_efecto_impacto.porcentaje";
	const NOMBRE_TABLA_ASOC_IMPACTO = "indicador_efecto_impacto";
	//Tabla avance indicador efecto
	const COLUMNAS_SELECT_AVANCE_INDICADOR_EFECTO = "avance_indicador_efecto.avance_acumulado";
	const NOMBRE_TABLA_AVANCE_INDICADOR_EFECTO = "avance_indicador_efecto";
	//tabla porcentaje acumulado indicador impacto
	const COLUMNAS_SELECT_PORCENTAJE_ACUMULADO_INDICADOR_EFECTO = "porcentaje_acumulado_indicador_efecto.porcentaje_acumulado";
	const NOMBRE_TABLA_PORCENTAJE_ACUMULADO_INDICADOR_EFECTO = "porcentaje_acumulado_indicador_efecto";

	public function __construct() {
		parent::__construct();
	}

	public function select_indicadores_efecto_de_efecto($id_efecto = FALSE) {
		$indicadores = FALSE;

		if ($id_efecto) {
			$this->set_select_indicador_efecto();
			$this->set_select_meta_efecto();
			$this->set_select_indicador_impacto_asociado();
			$this->set_select_avance_acumulado();
			$this->set_select_porcentaje_acumulado();

			$this->db->where(self::ID_EFECTO, $id_efecto);

			$query = $this->db->get();

			$indicadores = $this->return_result($query);
		}

		return $indicadores;
	}

	public function select_indicador_efecto_de_proyecto($id_indicador_efecto = FALSE, $id_proyecto = FALSE) {
		$indicador = FALSE;

		if ($id_indicador_efecto && $id_proyecto) {
			$this->set_select_indicador_efecto();
			$this->set_select_meta_efecto();
			$this->set_select_indicador_impacto_asociado();
			$this->set_select_porcentaje_acumulado();

			$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id_indicador_efecto);

			$this->set_select_resultado_asociado();

			$this->db->where(Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID_PROYECTO, $id_proyecto);

			$query = $this->db->get();

			$indicador = $this->return_row($query);
		}

		return $indicador;
	}

	private function set_select_indicador_efecto() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
	}

	private function set_select_meta_efecto() {
		$this->db->select(Modelo_meta_efecto::COLUMNAS_SELECT_OTRA_TABLA);
		$this->db->join(Modelo_meta_efecto::NOMBRE_TABLA, Modelo_meta_efecto::NOMBRE_TABLA . "." . Modelo_meta_efecto::ID_INDICADOR_EFECTO . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
	}

	private function set_select_indicador_impacto_asociado() {
		$this->db->select(self::COLUMNAS_SELECT_ASOC_IMPACTO);
		$this->db->join(self::NOMBRE_TABLA_ASOC_IMPACTO, self::NOMBRE_TABLA_ASOC_IMPACTO . "." . self::ID_INDICADOR_EFECTO . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
		$this->db->select(Modelo_indicador_impacto::COLUMNAS_SELECT_OTRA_TABLA);
		$this->db->join(Modelo_indicador_impacto::NOMBRE_TABLA, Modelo_indicador_impacto::NOMBRE_TABLA . "." . Modelo_indicador_impacto::ID . " = " . self::NOMBRE_TABLA_ASOC_IMPACTO . "." . self::ID_INDICADOR_IMPACTO, "left");
	}

	private function set_select_efecto_asociado() {
		$this->db->select(Modelo_efecto::COLUMNAS_SELECT_PARA_PROYECTO);
		$this->db->join(Modelo_efecto::NOMBRE_TABLA, Modelo_efecto::NOMBRE_TABLA . "." . Modelo_efecto::ID . " = " . self::NOMBRE_TABLA . "." . self::ID_EFECTO);
	}

	private function set_select_resultado_asociado() {
		$this->set_select_efecto_asociado();
		$this->db->select(Modelo_resultado::COLUMNAS_SELECT_OTRA_TABLA);
		$this->db->join(Modelo_resultado::NOMBRE_TABLA, Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID . " = " . Modelo_efecto::NOMBRE_TABLA . "." . Modelo_efecto::ID_RESULTADO);
	}

	private function set_select_avance_acumulado() {
		$this->db->select(self::COLUMNAS_SELECT_AVANCE_INDICADOR_EFECTO);
		$this->db->join(self::NOMBRE_TABLA_AVANCE_INDICADOR_EFECTO, self::NOMBRE_TABLA_AVANCE_INDICADOR_EFECTO . "." . self::ID_INDICADOR_EFECTO . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
	}

	private function set_select_porcentaje_acumulado() {
		$this->db->select(self::COLUMNAS_SELECT_PORCENTAJE_ACUMULADO_INDICADOR_EFECTO);
		$this->db->join(self::NOMBRE_TABLA_PORCENTAJE_ACUMULADO_INDICADOR_EFECTO, self::NOMBRE_TABLA_PORCENTAJE_ACUMULADO_INDICADOR_EFECTO . "." . self::ID_INDICADOR_EFECTO . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
	}

	public function insert_indicador_efecto($id_efecto = FALSE, $descripcion = "", $con_meta = FALSE, $cantidad = FALSE, $unidad = "", $con_indicador_impacto = FALSE, $id_indicador_impacto = FALSE, $porcentaje = FALSE) {
		$insertado = FALSE;

		if ($id_efecto && $descripcion != "") {
			$this->db->trans_start();

			$datos = array(
				self::ID_EFECTO => $id_efecto,
				self::DESCRIPCION => $descripcion
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			$id_indicador_efecto = $this->db->insert_id();

			if ($con_meta) {
				$this->Modelo_meta_efecto->insert_meta_efecto_st($id_indicador_efecto, $cantidad, $unidad);
			}

			if ($con_indicador_impacto) {
				$this->asociar_indicador_efecto_con_impacto($id_indicador_efecto, $id_indicador_impacto, $porcentaje);
			}

			$this->db->trans_complete();
		}

		return $insertado;
	}

	public function update_indicador_efecto($id_indicador_efecto = FALSE, $descripcion = "", $con_meta = FALSE, $cantidad = FALSE, $unidad = "", $con_indicador_impacto = FALSE, $id_indicador_impacto = FALSE, $porcentaje = FALSE) {
		$actualizado = FALSE;

		if ($id_indicador_efecto && $descripcion != "") {
			$this->db->trans_start();

			$datos = array(
				self::DESCRIPCION => $descripcion
			);

			$this->db->set($datos);

			$this->db->where(self::ID, $id_indicador_efecto);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->Modelo_meta_efecto->delete_meta_de_indicador_efecto_st($id_indicador_efecto);

			if ($con_meta) {
				$this->Modelo_meta_efecto->insert_meta_efecto_st($id_indicador_efecto, $cantidad, $unidad);
			}

			$this->desasociar_indicador_efecto_con_impacto($id_indicador_efecto, $id_indicador_impacto);

			if ($con_indicador_impacto) {
				$this->asociar_indicador_efecto_con_impacto($id_indicador_efecto, $id_indicador_impacto, $porcentaje);
			}

			$this->db->trans_complete();
		}

		return $actualizado;
	}

	private function asociar_indicador_efecto_con_impacto($id_indicador_efecto = FALSE, $id_indicador_impacto = FALSE, $porcentaje = FALSE) {
		$asociado = FALSE;

		if ($id_indicador_efecto && $id_indicador_impacto && $porcentaje) {
			$datos = array(
				self::ID_INDICADOR_EFECTO => $id_indicador_efecto,
				self::ID_INDICADOR_IMPACTO => $id_indicador_impacto,
				self::PORCENTAJE => $porcentaje
			);

			$this->db->set($datos);

			$asociado = $this->db->insert(self::NOMBRE_TABLA_ASOC_IMPACTO);
		}

		return $asociado;
	}

	private function desasociar_indicador_efecto_con_impacto($id_indicador_efecto = FALSE) {
		$desasociado = FALSE;

		if ($id_indicador_efecto) {
			$this->db->where(self::ID_INDICADOR_EFECTO, $id_indicador_efecto);

			$desasociado = $this->db->delete(self::NOMBRE_TABLA_ASOC_IMPACTO);
		}

		return $desasociado;
	}

	public function delete_indicador_efecto($id = FALSE) {
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
