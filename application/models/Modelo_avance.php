<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_avance
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_avance extends MY_Model {

	const ID = "id";
	const ID_ACTIVIDAD = "id_actividad";
	const CANTIDAD = "cantidad";
	const DESCRIPCION = "descripcion";
	const FECHA = "fecha";
	const COLUMNAS_SELECT = "avance.id, avance.id_actividad, avance.cantidad, avance.descripcion, avance.fecha";
	const NOMBRE_TABLA = "avance";

	public function __construct() {
		parent::__construct();
	}

	public function select_avances_de_actividad($id_actividad = FALSE) {
		$avances = FALSE;

		if ($id_actividad) {
			$this->db->select(self::COLUMNAS_SELECT);

			$this->db->from(self::NOMBRE_TABLA);

			$this->db->where(self::ID_ACTIVIDAD, $id_actividad);

			$query = $this->db->get();

			$avances = $this->return_result($query);

			if ($avances) {
				foreach ($avances as $avance) {
					$avance->documentos = $this->Modelo_documento_avance->select_documentos_avance_de_avance($avance->id);
				}
			}
		}

		return $avances;
	}

	public function insert_avance($id_actividad = FALSE, $cantidad = FALSE, $descripcion = "", $fecha = "", $con_archivos = FALSE, $archivos = FALSE) {
		$insertado = FALSE;

		if ($id_actividad && $cantidad && $descripcion != "") {
			$this->db->trans_start();

			$datos = array(
				self::ID_ACTIVIDAD => $id_actividad,
				self::CANTIDAD => $cantidad,
				self::DESCRIPCION => $descripcion,
				self::FECHA => $fecha
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			if ($insertado && $con_archivos) {
				$id_avance = $this->db->insert_id();

				$this->Modelo_documento_avance->insert_avances_st($id_avance, $archivos);
			}

			$this->db->trans_complete();
		}

		return $insertado;
	}

}
