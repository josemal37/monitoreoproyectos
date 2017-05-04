<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_resultado_clave
 *
 * @author Jose
 */
class Modelo_resultado_clave extends MY_Model {

	const ID = "id";
	const ID_RESULTADO = "id_resultado";
	const DESCRIPCION = "descripcion";
	const CONSEGUIDO = "conseguido";
	const COLUMNAS_SELECT = "resultado_clave.id, resultado_clave.id_resultado, resultado_clave.descripcion, resultado_clave.conseguido";
	const NOMBRE_TABLA = "resultado_clave";

	public function __construct() {
		parent::__construct();
	}

	public function select_resultado_clave_de_proyecto($id_resultado_clave = FALSE, $id_proyecto = FALSE) {
		$resultado_clave = FALSE;

		if ($id_resultado_clave && $id_proyecto) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id_resultado_clave);

			$this->db->join(Modelo_resultado::NOMBRE_TABLA, Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID . " = " . self::NOMBRE_TABLA . "." . self::ID_RESULTADO);
			$this->db->where(Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID_PROYECTO, $id_proyecto);

			$query = $this->db->get();

			$resultado_clave = $this->return_row($query);
		}

		return $resultado_clave;
	}

	public function select_resultados_clave_de_resultado($id_resultado = FALSE) {
		$resultados_clave = FALSE;

		if ($id_resultado) {
			$this->db->select(self::COLUMNAS_SELECT);

			$this->db->from(self::NOMBRE_TABLA);

			$this->db->where(self::ID_RESULTADO, $id_resultado);

			$query = $this->db->get();

			$resultados_clave = $this->return_result($query);
		}

		return $resultados_clave;
	}

	public function insert_resultado_clave($id_resultado = FALSE, $descripcion = "") {
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

	public function update_resultado_clave($id = FALSE, $descripcion = "") {
		$actualizado = FALSE;

		if ($id && $descripcion != "") {
			$this->db->trans_start();

			$datos = array(
				self::DESCRIPCION => $descripcion
			);

			$this->db->set($datos);

			$this->db->where(self::ID, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $actualizado;
	}

}
