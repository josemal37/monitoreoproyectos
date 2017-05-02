<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Proyecto
 *
 * @author Jose
 */
class Proyecto extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(array("Modelo_proyecto"));
		$this->load->library(array("Proyecto_validacion"));
		$this->load->database("default");
	}
	
	public function index() {
		$this->proyectos();
	}
	
	public function proyectos() {
		$rol = $this->session->userdata("rol");
		
		if ($rol == "empleado") {
			$this->cargar_vista_proyectos();
		} else {
			redirect(base_url());
		}
	}
	
	private function cargar_vista_proyectos() {
		$titulo = "Proyectos";
		$id_usuario = $this->session->userdata("id");
		$proyectos = $this->Modelo_proyecto->select_proyectos_de_usuario($id_usuario);
		
		$datos = array();
		$datos["titulo"] = $titulo;
		$datos["proyectos"] = $proyectos;
		
		$this->load->view("proyecto/proyectos", $datos);
	}

	public function registrar_proyecto() {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if (isset($_POST["submit"])) {
				$this->registrar_proyecto_bd();
			} else {
				$this->cargar_vista_registrar_proyecto();
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_proyecto() {
		$titulo = "Registrar proyecto";

		$datos = array();
		$datos["titulo"] = $titulo;

		$this->load->view("proyecto/formulario_proyecto", $datos);
	}

	private function registrar_proyecto_bd() {
		$nombre = $this->input->post("nombre");
		$objetivo = $this->input->post("objetivo");
		$fecha_inicio = $this->input->post("fecha_inicio");
		$fecha_fin = $this->input->post("fecha_fin");
		
		if ($this->proyecto_validacion->validar(array("nombre", "objetivo", "fecha_inicio", "fecha_fin"))) {
			if ($this->Modelo_proyecto->insert_proyecto($nombre, $objetivo, $fecha_inicio, $fecha_fin)) {
				redirect(base_url("proyecto/proyectos"));
			} else {
				redirect(base_url("proyecto/registrar_proyecto"), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_proyecto();
		}
	}

}
