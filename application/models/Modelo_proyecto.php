<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_proyecto
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_proyecto extends MY_Model {

	const ID = "id";
	const NOMBRE = "nombre";
	const OBJETIVO = "objetivo";
	const FECHA_INICIO = "fecha_inicio";
	const FECHA_FIN = "fecha_fin";
	const COLUMNAS_SELECT = "proyecto.id, proyecto.nombre, proyecto.objetivo, proyecto.fecha_inicio, proyecto.fecha_fin";
	const NOMBRE_TABLA = "proyecto";

	public function __construct() {
		parent::__construct();
	}
	
	public function select_proyectos_de_usuario($id = FALSE) {
		$proyectos = FALSE;
		
		if ($id) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);
			
			$query = $this->db->get();
			
			$proyectos = $this->return_result($query);
		}
		
		return $proyectos;
	}

	public function insert_proyecto($nombre = "", $objetivo = "", $fecha_inicio = "", $fecha_fin = "") {
		$insertado = FALSE;

		if ($nombre != "" && $fecha_inicio != "" && $fecha_fin != "") {
			$this->db->trans_start();

			$datos = array(
				self::NOMBRE => $nombre,
				self::OBJETIVO => $objetivo,
				self::FECHA_INICIO => $fecha_inicio,
				self::FECHA_FIN => $fecha_fin
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $insertado;
	}

}
