<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Avance
 *
 * @author Jose
 */
require_once 'Coordinador.php';
require_once 'Actividad.php';

class Avance extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model(array(
			"Modelo_proyecto",
			"Modelo_actividad",
			"Modelo_meta_actividad",
			"Modelo_producto",
			"Modelo_indicador_producto",
			"Modelo_avance",
			"Modelo_documento_avance",
			"Modelo_usuario",
			"Modelo_actividad_usuario"
		));

		$this->load->library(array("Item_validacion", "Archivo"));

		$this->load->helper(array("array_helper"));

		$this->load->database("default");
	}

	public function ver_avances($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto) {
				$this->cargar_vista_ver_avances($id_proyecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_ver_avances($id_proyecto) {
		$id_usuario = $this->session->userdata("id");
		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario);

		if ($proyecto) {
			$titulo = "Avances";
			$actividades = $this->Modelo_actividad->select_actividades_de_proyecto_con_avance($id_proyecto);

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["actividades"] = $actividades;
			$datos["cantidad_meta_por_defecto"] = Actividad::CANTIDAD_META_POR_DEFECTO;
			$datos["unidad_meta_por_defecto"] = Actividad::UNIDAD_META_POR_DEFECTO;

			$this->load->view("avance/avances", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	public function registrar_avance($id_proyecto = FALSE, $id_actividad = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_actividad) {
				if (isset($_POST["submit"])) {
					$this->registrar_avance_bd($id_proyecto, $id_actividad);
				} else {
					$this->cargar_vista_registrar_avance($id_proyecto, $id_actividad);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_avance($id_proyecto, $id_actividad) {
		$id_usuario = $this->session->userdata("id");
		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario);
		$actividad = $this->Modelo_actividad->select_actividad_por_id($id_actividad, $id_proyecto, $id_usuario);

		if ($proyecto && $actividad) {
			$titulo = "Registrar avance";

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["actividad"] = $actividad;

			$this->load->view("avance/formulario_avance", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function registrar_avance_bd($id_proyecto, $id_actividad) {
		$cantidad = $this->input->post("cantidad");
		$descripcion = $this->input->post("descripcion");
		$con_archivos = $this->input->post("con-archivos") == "on";
		$archivos = FALSE;

		if ($this->item_validacion->validar("cantidad", "descripcion")) {
			$id_usuario = $this->session->userdata("id");
			$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario);
			$actividad = $this->Modelo_actividad->select_actividad_por_id($id_actividad, $id_proyecto, $id_usuario);

			if ($proyecto && $actividad) {
				if ($con_archivos) {
					$archivos = $this->archivo->subir_archivos("archivos", $proyecto->nombre . "/" . $actividad->nombre);

					if (!$archivos) {
						redirect(base_url("avance/registrar_avance/" . $id_proyecto . "/" . $id_actividad), "refresh");
					}
				}
				
				if ($this->Modelo_avance->insert_avance($id_actividad, $cantidad, $descripcion, $con_archivos, $archivos)) {
					redirect(base_url("avance/ver_avances/" . $id_proyecto));
				} else {
					redirect(base_url("avance/registrar_avance/" . $id_proyecto . "/" . $id_actividad), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_avance($id_proyecto, $id_actividad);
		}
	}

}
