<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Resultado_clave
 *
 * @author Jose
 */
require_once 'Coordinador.php';

class Resultado_clave extends Coordinador {

	public function __construct() {
		parent::__construct();

		$this->load->library(array("Item_validacion"));
	}

	public function registrar_resultado_clave($id_proyecto = FALSE, $id_resultado = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_resultado) {
				if (isset($_POST["submit"])) {
					$this->registrar_resultado_clave_bd($id_proyecto, $id_resultado);
				} else {
					$this->cargar_vista_registrar_resultado_clave($id_proyecto, $id_resultado);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_resultado_clave($id_proyecto, $id_resultado) {
		$titulo = "Registrar resultado clave";
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$resultado = $this->get_resultado_de_coordinador($id_resultado, $id_proyecto);

		if ($proyecto && $resultado) {
			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["resultado"] = $resultado;

			$this->load->view("resultado_clave/formulario_resultado_clave", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function registrar_resultado_clave_bd($id_proyecto, $id_resultado) {
		$descripcion = $this->input->post("descripcion");

		if ($this->item_validacion->validar(array("descripcion"))) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			$resultado = $this->get_resultado_de_coordinador($id_resultado, $id_proyecto);

			if ($proyecto && $resultado) {
				if ($this->Modelo_resultado_clave->insert_resultado_clave($id_resultado, $descripcion)) {
					redirect(base_url("marco_logico/ver_marco_logico/" . $id_proyecto));
				} else {
					redirect(base_url("resultado_clave/registrar_resultado_clave/" . $id_proyecto . "/" . $id_resultado), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"), "refresh");
			}
				
			} else {
				unset($_POST["submit"]);
				$this->registrar_resultado_clave($id_proyecto, $id_resultado);
			}
		}
	}
	