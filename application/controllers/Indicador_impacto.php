<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Indicador_impacto
 *
 * @author Jose
 */
require_once 'Coordinador.php';

class Indicador_impacto extends Coordinador {

	public function __construct() {
		parent::__construct();

		$this->load->library(array("Item_validacion"));
	}

	public function registrar_indicador_impacto($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto) {
				if (isset($_POST["submit"])) {
					$this->registrar_indicador_impacto_bd($id_proyecto);
				} else {
					$this->cargar_vista_registrar_indicador_impacto($id_proyecto);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_indicador_impacto($id_proyecto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);

		if ($proyecto) {
			$titulo = "Registrar indicador de impacto";

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;

			$this->load->view("indicador_impacto/formulario_indicador_impacto", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function registrar_indicador_impacto_bd($id_proyecto) {
		$descripcion = $this->input->post("descripcion");
		$con_meta = $this->input->post("con-meta") == "on";

		$array_validacion = array("descripcion");

		if ($con_meta) {
			$cantidad = $this->input->post("cantidad");
			$unidad = $this->input->post("unidad");

			$array_validacion[] = "cantidad";
			$array_validacion[] = "unidad";
		}

		if ($this->item_validacion->validar($array_validacion)) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			
			if ($proyecto) {
				if ($this->Modelo_indicador_impacto->insert_indicador_impacto($id_proyecto, $descripcion, $con_meta, $cantidad, $unidad)) {
					redirect(base_url("marco_logico/ver_marco_logico/" . $id_proyecto));
				} else {
					redirect(base_url("indicador_impacto/registrar_indicador_impacto/" . $id_proyecto), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_indicador_impacto($id_proyecto);
		}
	}

}
