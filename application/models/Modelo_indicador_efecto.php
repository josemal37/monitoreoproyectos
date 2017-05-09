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
	const NOMBRE_TABLA = "indicador_efecto";
	//Tabla indicador efecto impacto
	const ID_INDICADOR_EFECTO = "id_indicador_efecto";
	const ID_INDICADOR_IMPACTO = "id_indicador_impacto";
	const PORCENTAJE = "porcentaje";
	const COLUMNAS_SELECT_ASOC_IMPACTO = "indicador_efecto_impacto.porcentaje";
	const NOMBRE_TABLA_ASOC_IMPACTO = "indicador_efecto_impacto";

	public function __construct() {
		parent::__construct();
	}

	public function select_indicadores_efecto_de_efecto($id_efecto = FALSE) {
		$indicadores = FALSE;

		if ($id_efecto) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::ID_EFECTO, $id_efecto);

			$this->db->select(Modelo_meta_efecto::COLUMNAS_SELECT_OTRA_TABLA);
			$this->db->join(Modelo_meta_efecto::NOMBRE_TABLA, Modelo_meta_efecto::NOMBRE_TABLA . "." . Modelo_meta_efecto::ID_INDICADOR_EFECTO . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");

			$this->db->select(self::COLUMNAS_SELECT_ASOC_IMPACTO);
			$this->db->join(self::NOMBRE_TABLA_ASOC_IMPACTO, self::NOMBRE_TABLA_ASOC_IMPACTO . "." . self::ID_INDICADOR_EFECTO . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
			$this->db->select(Modelo_indicador_impacto::COLUMNAS_SELECT_OTRA_TABLA);
			$this->db->join(Modelo_indicador_impacto::NOMBRE_TABLA, Modelo_indicador_impacto::NOMBRE_TABLA . "." . Modelo_indicador_impacto::ID . " = " . self::NOMBRE_TABLA_ASOC_IMPACTO . "." . self::ID_INDICADOR_IMPACTO, "left");
			
			$query = $this->db->get();

			$indicadores = $this->return_result($query);
		}

		return $indicadores;
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
				$this->Modelo_meta_efecto->insert_meta_efecto_sin_transaccion($id_indicador_efecto, $cantidad, $unidad);
			}

			if ($con_indicador_impacto) {
				$this->asociar_indicador_efecto_con_impacto($id_indicador_efecto, $id_indicador_impacto, $porcentaje);
			}

			$this->db->trans_complete();
		}

		return $insertado;
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

}
