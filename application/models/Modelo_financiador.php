<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modelo_financiador
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_financiador extends MY_Model {

	const ID = "id";
	const NOMBRE = "nombre";
	const COLUMNAS_SELECT = "financiador.id, financiador.nombre";
	const COLUMNAS_SELECT_OTRA_TABLA = "financiador.nombre as nombre_financiador";
	const NOMBRE_TABLA = "financiador";

	public function __construct() {
		parent::__construct();
	}

	public function select_financiadores() {
		$financiadores = FALSE;

		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);

		$query = $this->db->get();

		$financiadores = $this->return_result($query);

		return $financiadores;
	}

	public function select_financiador_por_id($id = FALSE) {
		$financiador = FALSE;

		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::ID, $id);

			$query = $this->db->get();

			$financiador = $this->return_row($query);
		}

		return $financiador;
	}

	public function insert_financiador($nombre = "") {
		$insertado = FALSE;

		if ($nombre != "") {
			$this->db->trans_start();

			$datos = array(
				self::NOMBRE => $nombre
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $insertado;
	}

	public function update_financiador($id = FALSE, $nombre = "") {
		$actualizado = FALSE;

		if ($id && $nombre != "") {
			$this->db->trans_start();

			$datos = array(
				self::NOMBRE => $nombre
			);

			$this->db->set($datos);
			$this->db->where(self::ID, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $actualizado;
	}

	public function delete_financiador($id = FALSE) {
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
