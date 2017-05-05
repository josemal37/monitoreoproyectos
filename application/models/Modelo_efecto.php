<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_efecto
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_efecto extends MY_Model {

	const ID = "id";
	const ID_RESULTADO = "id_resultado";
	const DESCRIPCION = "descripcion";
	const COLUMNAS_SELECT = "efecto.id, efecto.id_resultado, efecto.descripcion";
	const COLUMNAS_SELECT_PARA_PROYECTO = "efecto.id as id_efecto, efecto.descripcion as descripcion_efecto";
	const NOMBRE_TABLA = "efecto";

	public function __construct() {
		parent::__construct();
	}

	public function insert_efecto($id_resultado = FALSE, $descripcion = "") {
		$insertado = FALSE;

		if ($id_resultado && $descripcion != "") {
			$this->db->trans_start();

			$datos = array(
				self::ID_RESULTADO => $id_resultado,
				self::DESCRIPCION => $descripcion
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $insertado;
	}

}
