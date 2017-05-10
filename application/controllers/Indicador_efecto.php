<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Indicador_efecto
 *
 * @author Jose
 */
require_once 'Coordinador.php';

class Indicador_efecto extends Coordinador {

	public function __construct() {
		parent::__construct();

		$this->load->library(array("item_validacion"));
	}

	public function registrar_indicador_efecto($id_proyecto = FALSE, $id_efecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_efecto) {
				if (isset($_POST["submit"])) {
					$this->registrar_indicador_efecto_bd($id_proyecto, $id_efecto);
				} else {
					$this->cargar_vista_registrar_indicador_efecto($id_proyecto, $id_efecto);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_indicador_efecto($id_proyecto, $id_efecto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$efecto = $this->get_efecto_de_proyecto($id_efecto, $id_proyecto);

		if ($proyecto && $efecto) {
			$titulo = "Registrar indicador de efecto";
			$indicadores_impacto = $this->Modelo_indicador_impacto->select_indicadores_impacto_de_proyecto($id_proyecto);

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["efecto"] = $efecto;
			$datos["indicadores_impacto"] = $indicadores_impacto;

			$this->load->view("indicador_efecto/formulario_indicador_efecto", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function registrar_indicador_efecto_bd($id_proyecto, $id_efecto) {
		$descripcion = $this->input->post("descripcion");
		$con_meta = $this->input->post("con-meta") == "on";
		$con_indicador_impacto = $this->input->post("con-indicador-impacto") == "on";

		$array_validacion = array("descripcion");

		if ($con_meta) {
			$cantidad = $this->input->post("cantidad");
			$unidad = $this->input->post("unidad");

			$array_validacion[] = "cantidad";
			$array_validacion[] = "unidad";
		}

		if ($con_indicador_impacto) {
			$id_indicador_impacto = $this->input->post("indicador-impacto");
			$porcentaje = $this->input->post("porcentaje");

			$array_validacion[] = "indicador-impacto";
			$array_validacion[] = "porcentaje";
		}

		if ($this->item_validacion->validar($array_validacion)) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			$efecto = $this->get_efecto_de_proyecto($id_efecto, $id_proyecto);

			if ($proyecto && $efecto) {
				if ($this->Modelo_indicador_efecto->insert_indicador_efecto($id_efecto, $descripcion, $con_meta, $cantidad, $unidad, $con_indicador_impacto, $id_indicador_impacto, $porcentaje)) {
					redirect(base_url("marco_logico/ver_marco_logico/" . $id_proyecto));
				} else {
					redirect(base_url("indicador_efecto/registrar_indicador_efecto/" . $id_proyecto . "/" . $id_efecto), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			unset($_POST["submit"]);

			$this->registrar_indicador_efecto($id_proyecto, $id_efecto);
		}
	}

	public function modificar_indicador_efecto($id_proyecto = FALSE, $id_indicador_efecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_indicador_efecto) {
				if (isset($_POST["submit"])) {
					$this->modificar_indicador_efecto_bd($id_proyecto, $id_indicador_efecto);
				} else {
					$this->cargar_vista_modificar_indicador_efecto($id_proyecto, $id_indicador_efecto);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_modificar_indicador_efecto($id_proyecto, $id_indicador_efecto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$indicador_efecto = $this->get_indicador_efecto_de_proyecto($id_indicador_efecto, $id_proyecto);

		if ($proyecto && $indicador_efecto) {
			$titulo = "Modificar indicador de efecto";
			$efecto = $this->get_efecto_de_proyecto($indicador_efecto->id_efecto, $id_proyecto);
			$indicadores_impacto = $this->Modelo_indicador_impacto->select_indicadores_impacto_de_proyecto($id_proyecto);

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["indicador_efecto"] = $indicador_efecto;
			$datos["efecto"] = $efecto;
			$datos["indicadores_impacto"] = $indicadores_impacto;

			$this->load->view("indicador_efecto/formulario_indicador_efecto", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function modificar_indicador_efecto_bd($id_proyecto, $id_indicador_efecto) {
		$descripcion = $this->input->post("descripcion");
		$con_meta = $this->input->post("con-meta") == "on";
		$con_indicador_impacto = $this->input->post("con-indicador-impacto") == "on";

		$array_validacion = array("descripcion");

		if ($con_meta) {
			$cantidad = $this->input->post("cantidad");
			$unidad = $this->input->post("unidad");

			$array_validacion[] = "cantidad";
			$array_validacion[] = "unidad";
		}

		if ($con_indicador_impacto) {
			$id_indicador_impacto = $this->input->post("indicador-impacto");
			$porcentaje = $this->input->post("porcentaje");

			$array_validacion[] = "indicador-impacto";
			$array_validacion[] = "porcentaje";
		}

		if ($this->item_validacion->validar($array_validacion)) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			$indicador_efecto = $this->get_indicador_efecto_de_proyecto($id_indicador_efecto, $id_proyecto);

			if ($proyecto && $indicador_efecto) {
				if ($this->Modelo_indicador_efecto->update_indicador_efecto($id_indicador_efecto, $descripcion, $con_meta, $cantidad, $unidad, $con_indicador_impacto, $id_indicador_impacto, $porcentaje)) {
					redirect(base_url("marco_logico/ver_marco_logico/" . $id_proyecto));
				} else {
					redirect(base_url("indicador_efecto/modificar_indicador_efecto/" . $id_proyecto . "/" . $id_indicador_efecto), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_indicador_efecto($id_proyecto, $id_indicador_efecto);
		}
	}

	public function eliminar_indicador_efecto($id_proyecto = FALSE, $id_indicador_efecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_indicador_efecto) {
				$this->eliminar_indicador_efecto_bd($id_proyecto, $id_indicador_efecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function eliminar_indicador_efecto_bd($id_proyecto, $id_indicador_efecto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$indicador_efecto = $this->get_indicador_efecto_de_proyecto($id_indicador_efecto, $id_proyecto);

		if ($proyecto && $indicador_efecto) {
			if ($this->Modelo_indicador_efecto->delete_indicador_efecto($id_indicador_efecto)) {
				redirect(base_url("marco_logico/ver_marco_logico/" . $id_proyecto));
			} else {
				redirect(base_url("marco_logico/ver_marco_logico/" . $id_proyecto), "refresh");
			}
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

}