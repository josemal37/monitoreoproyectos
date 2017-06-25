<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_aporte
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_aporte extends MY_Model {

	const ID = "id";
	const ID_FINANCIADOR = "id_financiador";
	const ID_TIPO_FINANCIADOR = "id_tipo_financiador";
	const ID_PROYECTO = "id_proyecto";
	const CANTIDAD = "cantidad";
	const CONCEPTO = "concepto";
	const COLUMNAS_SELECT = "aporte.id, aporte.id_financiador, aporte.id_tipo_financiador, aporte.id_proyecto, aporte.cantidad, aporte.concepto";
	const NOMBRE_TABLA = "aporte";

	public function __construct() {
		parent::__construct();
	}

	public function select_aportes_de_proyecto($id_proyecto = FALSE) {
		$aportes = FALSE;

		if ($id_proyecto) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->select(Modelo_financiador::COLUMNAS_SELECT_OTRA_TABLA);
			$this->db->select(Modelo_tipo_financiador::COLUMNAS_SELECT_OTRA_TABLA);

			$this->db->from(self::NOMBRE_TABLA);

			$this->db->join(Modelo_financiador::NOMBRE_TABLA, Modelo_financiador::NOMBRE_TABLA . "." . Modelo_financiador::ID . " = " . self::NOMBRE_TABLA . "." . self::ID_FINANCIADOR, "left");
			$this->db->join(Modelo_tipo_financiador::NOMBRE_TABLA, Modelo_tipo_financiador::NOMBRE_TABLA . "." . Modelo_tipo_financiador::ID . " = " . self::NOMBRE_TABLA . "." . self::ID_FINANCIADOR, "left");
			
			$this->db->where(self::ID_PROYECTO, $id_proyecto);
			
			$query = $this->db->get();
			
			$aportes = $this->return_result($query);
		}

		return $aportes;
	}

	public function insert_aportes_st($id_proyecto, $instituciones_ejecutores, $cantidades_ejecutores, $conceptos_ejecutores, $instituciones_financiadores, $cantidades_financiadores, $conceptos_financiadores, $instituciones_otros, $cantidades_otros, $conceptos_otros) {
		$insertado = FALSE;

		if ($id_proyecto) {
			$datos = $this->get_datos_aportes($id_proyecto, $instituciones_ejecutores, $cantidades_ejecutores, $conceptos_ejecutores, $instituciones_financiadores, $cantidades_financiadores, $conceptos_financiadores, $instituciones_otros, $cantidades_otros, $conceptos_otros);

			$insertado = $this->db->insert_batch(self::NOMBRE_TABLA, $datos);
		}

		return $insertado;
	}

	private function get_datos_aportes($id_proyecto, $instituciones_ejecutores, $cantidades_ejecutores, $conceptos_ejecutores, $instituciones_financiadores, $cantidades_financiadores, $conceptos_financiadores, $instituciones_otros, $cantidades_otros, $conceptos_otros) {
		$datos = array();

		if ($instituciones_ejecutores) {
			$id_ejecutor = $this->Modelo_tipo_financiador->select_id_ejecutor();
			$ejecutores = $this->get_array_aportes($id_proyecto, $id_ejecutor, $instituciones_ejecutores, $cantidades_ejecutores, $conceptos_ejecutores);
		} else {
			$ejecutores = array();
		}

		if ($instituciones_financiadores) {
			$id_financiador = $this->Modelo_tipo_financiador->select_id_financiador();
			$financiadores = $this->get_array_aportes($id_proyecto, $id_financiador, $instituciones_financiadores, $cantidades_financiadores, $conceptos_financiadores);
		} else {
			$financiadores = array();
		}

		if ($instituciones_otros) {
			$id_otro = $this->Modelo_tipo_financiador->select_id_otro();
			$otros = $this->get_array_aportes($id_proyecto, $id_otro, $instituciones_otros, $cantidades_otros, $conceptos_otros);
		} else {
			$otros = array();
		}

		$datos = array_merge($ejecutores, $financiadores);
		$datos = array_merge($datos, $otros);

		return $datos;
	}

	private function get_array_aportes($id_proyecto, $id_tipo_financiador, $financiadores, $cantidades, $conceptos) {
		$aportes = array();

		for ($i = 0; $i < sizeof($financiadores); $i += 1) {
			$aporte = array(
				self::ID_PROYECTO => $id_proyecto,
				self::ID_TIPO_FINANCIADOR => $id_tipo_financiador,
				self::ID_FINANCIADOR => $financiadores[$i],
				self::CANTIDAD => $cantidades[$i],
				self::CONCEPTO => $conceptos[$i]
			);

			$aportes[] = $aporte;
		}

		return $aportes;
	}

}
