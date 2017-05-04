<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Coordinador
 *
 * @author Jose
 */
abstract class Coordinador extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->model(array("Modelo_proyecto", "Modelo_resultado", "Modelo_resultado_clave","Modelo_rol_proyecto"));

		$this->load->database("default");
	}

	protected function get_proyecto_de_coordinador($id_proyecto) {
		$id_usuario = $this->session->userdata("id");
		$id_rol_coordinador = $this->Modelo_rol_proyecto->select_id_rol_coordinador();
		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario, $id_rol_coordinador);

		return $proyecto;
	}

	protected function get_resultado_de_coordinador($id_resultado, $id_proyecto) {
		$resultado = $this->Modelo_resultado->select_resultado_por_id($id_resultado, $id_proyecto);

		return $resultado;
	}

}
