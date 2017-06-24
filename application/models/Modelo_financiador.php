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

}
