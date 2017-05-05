<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Efecto
 *
 * @author Jose
 */
require_once 'Coordinador.php';

class Efecto extends Coordinador {

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_proyecto", "Modelo_resultado", "Modelo_efecto", "Modelo_rol_proyecto"));

		$this->load->library(array("Item_validacion"));

		$this->load->database("default");
	}

	public function registrar_efecto($id_proyecto = FALSE, $id_resultado = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_resultado) {
				if (isset($_POST["submit"])) {
					$this->registrar_efecto_bd($id_proyecto, $id_resultado);
				} else {
					$this->cargar_vista_registrar_efecto($id_proyecto, $id_resultado);
				}
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_efecto($id_proyecto, $id_resultado) {
		$titulo = "Registrar efecto";
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$resultado = $this->get_resultado_de_proyecto($id_resultado, $id_proyecto);

		if ($proyecto && $resultado) {
			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["resultado"] = $resultado;

			$this->load->view("efecto/formulario_efecto", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function registrar_efecto_bd($id_proyecto, $id_resultado) {
		$descripcion = $this->input->post("descripcion");

		if ($this->item_validacion->validar(array("descripcion"))) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			$resultado = $this->get_resultado_de_proyecto($id_resultado, $id_proyecto);

			if ($proyecto && $resultado) {
				if ($this->Modelo_efecto->insert_efecto($id_resultado, $descripcion)) {
					redirect(base_url("marco_logico/ver_marco_logico/" . $id_proyecto));
				} else {
					redirect(base_url("efecto/registrar_efecto/" . $id_proyecto . "/" . $id_resultado), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_efecto($id_proyecto, $id_resultado);
		}
	}

}
