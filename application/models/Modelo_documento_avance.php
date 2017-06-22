<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_documento_avance
 *
 * @author Jose
 */
class Modelo_documento_avance extends MY_Model {

	const ID = "id";
	const ID_AVANCE = "id_avance";
	const NOMBRE = "nombre";
	const DOCUMENTO = "documento";
	const COLUMNAS_SELECT = "documento_avance.id, documento_avance.id_avance, documento_avance.nombre, documento_avance.documento";
	const NOMBRE_TABLA = "documento_avance";

	public function __construct() {
		parent::__construct();
	}

	public function select_documentos_avance_de_avance($id_avance = FALSE) {
		$documentos = FALSE;

		if ($id_avance) {
			$this->db->select(self::COLUMNAS_SELECT);

			$this->db->from(self::NOMBRE_TABLA);

			$this->db->where(self::ID_AVANCE, $id_avance);

			$query = $this->db->get();

			$documentos = $this->return_result($query);
		}

		return $documentos;
	}

	public function insert_avance_st($id_avance = FALSE, $nombre = "", $documento = "") {
		$insertado = FALSE;

		if ($id_avance && $nombre != "" && $documento != "") {
			$datos = array(
				self::ID_AVANCE => $id_avance,
				self::NOMBRE => $nombre,
				self::DOCUMENTO => $documento
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);
		}

		return $insertado;
	}

	public function insert_avances_st($id_avance = FALSE, $archivos = FALSE) {
		$insertado = FALSE;

		if ($id_avance && $archivos && is_array($archivos)) {
			$datos = array();

			foreach ($archivos as $archivo) {
				$fila = array(
					self::ID_AVANCE => $id_avance,
					self::NOMBRE => $archivo["client_name"],
					self::DOCUMENTO => $archivo["path"]
				);
				$datos[] = $fila;
			}

			$insertado = $this->db->insert_batch(self::NOMBRE_TABLA, $datos);
		}

		return $insertado;
	}

	public function insert_documentos($id_avance = FALSE, $archivos = FALSE) {
		$insertado = FALSE;

		if ($id_avance && $archivos) {
			$this->db->trans_start();

			$insertado = $this->insert_avances_st($id_avance, $archivos);

			$this->db->trans_complete();
		}
		return $insertado;
	}

}
