<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_tipo_financiador
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_tipo_financiador extends MY_Model {

	const ID = "id";
	const NOMBRE = "nombre";
	const COLUMNAS_SELECT = "tipo_financiador.id, tipo_financiador.nombre";
	const COLUMNAS_SELECT_OTRA_TABLA = "tipo_financiador.nombre as nombre_tipo_financiador";
	const NOMBRE_TABLA = "tipo_financiador";
	const FINANCIADOR = "financiador";
	const EJECUTOR = "ejecutor";
	const OTRO = "otro";

	public function select_id_ejecutor() {
		$id = FALSE;

		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->where(self::NOMBRE, self::EJECUTOR);

		$query = $this->db->get();

		$row = $this->return_row($query);

		if ($row) {
			$id = $row->id;
		}

		return $id;
	}

	public function select_id_financiador() {
		$id = FALSE;

		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->where(self::NOMBRE, self::FINANCIADOR);

		$query = $this->db->get();

		$row = $this->return_row($query);

		if ($row) {
			$id = $row->id;
		}

		return $id;
	}

	public function select_id_otro() {
		$id = FALSE;

		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->where(self::NOMBRE, self::OTRO);

		$query = $this->db->get();

		$row = $this->return_row($query);

		if ($row) {
			$id = $row->id;
		}

		return $id;
	}

}
