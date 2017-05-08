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

				$insertado = $this->Modelo_meta_impacto->insert_meta_impacto_sin_transaccion($id_indicador_impacto, $cantidad, $unidad);
			}

			$this->db->trans_complete();
		}

		return $insertado;
	}

}
