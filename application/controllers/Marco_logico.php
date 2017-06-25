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

		$this->load->Model(array(
			"Modelo_proyecto",
			"Modelo_efecto",
			"Modelo_producto",
			"Modelo_resultado",
			"Modelo_resultado_clave",
			"Modelo_indicador_impacto",
			"Modelo_meta_impacto",
			"Modelo_indicador_efecto",
			"Modelo_meta_efecto",
			"Modelo_indicador_producto",
			"Modelo_meta_producto",
			"Modelo_rol_proyecto",
			"Modelo_actividad",
			"Modelo_meta_actividad",
			"Modelo_avance",
			"Modelo_aporte",
			"Modelo_financiador",
			"Modelo_tipo_financiador"
		));
		$this->load->database("default");
	}

	public function index() {
		$this->editar_marco_logico();
	}

	public function ver_marco_logico($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado" || $rol == "dirección") {
			if ($id_proyecto) {
				$this->cargar_vista_ver_marco_logico($id_proyecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_ver_marco_logico($id_proyecto) {
		$titulo = "Marco lógico";

		$id_usuario = $this->session->userdata("id");

		if ($this->session->userdata("rol") == "dirección") {
			$id_usuario = FALSE;
		}

		$proyecto = $this->Modelo_proyecto->select_marco_logico_proyecto($id_proyecto, $id_usuario);

		if ($proyecto) {
			$id_ejecutor = $this->Modelo_tipo_financiador->select_id_ejecutor();
			$id_financiador = $this->Modelo_tipo_financiador->select_id_financiador();
			$id_otro = $this->Modelo_tipo_financiador->select_id_otro();

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["id_ejecutor"] = $id_ejecutor;
			$datos["id_financiador"] = $id_financiador;
			$datos["id_otro"] = $id_otro;

			$this->load->view("marco_logico/marco_logico", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	public function editar_marco_logico($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto) {
				$this->cargar_vista_editar_marco_logico($id_proyecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_editar_marco_logico($id_proyecto) {
		$titulo = "Marco lógico";

		$id_usuario = $this->session->userdata("id");
		$proyecto = $this->Modelo_proyecto->select_marco_logico_proyecto($id_proyecto, $id_usuario);

		if ($proyecto && !$proyecto->finalizado) {
			$id_ejecutor = $this->Modelo_tipo_financiador->select_id_ejecutor();
			$id_financiador = $this->Modelo_tipo_financiador->select_id_financiador();
			$id_otro = $this->Modelo_tipo_financiador->select_id_otro();

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["id_ejecutor"] = $id_ejecutor;
			$datos["id_financiador"] = $id_financiador;
			$datos["id_otro"] = $id_otro;

			$this->load->view("marco_logico/marco_logico", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

}
