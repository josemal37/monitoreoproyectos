<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Marco_logico
 *
 * @author Jose
 */
class Marco_logico extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->Model(array("Modelo_proyecto", "Modelo_efecto", "Modelo_producto", "Modelo_resultado", "Modelo_resultado_clave", "Modelo_indicador_impacto", "Modelo_meta_impacto", "Modelo_rol_proyecto"));
		$this->load->database("default");
	}

	public function index() {
		$this->ver_marco_logico();
	}

	public function ver_marco_logico($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto) {
				$this->cargar_vista_marco_logico($id_proyecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_marco_logico($id_proyecto) {
		$titulo = "Marco lógico";

		$id_usuario = $this->session->userdata("id");
		$proyecto = $this->Modelo_proyecto->select_marco_logico_proyecto($id_proyecto, $id_usuario);

		if ($proyecto) {

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;

			$this->load->view("marco_logico/marco_logico", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

}
