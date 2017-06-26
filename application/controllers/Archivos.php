<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Archivos
 *
 * @author Jose
 */
class Archivos extends CI_Controller {

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
			"Modelo_actividad_usuario",
			"Modelo_aporte",
			"Modelo_financiador",
			"Modelo_tipo_financiador"
		));

		$this->load->library(array("Item_validacion", "Archivo"));

		$this->load->helper(array("array_helper"));

		$this->load->database("default");
	}

	public function registrar_archivo($id_proyecto = FALSE, $id_avance = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "técnico") {
			if ($id_proyecto && $id_avance) {
				if (isset($_POST["submit"])) {
					$this->registrar_archivo_bd($id_proyecto, $id_avance);
				} else {
					$this->cargar_vista_registrar_archivo($id_proyecto, $id_avance);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_archivo($id_proyecto, $id_avance) {
		$id_usuario = $this->session->userdata("id");
		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario);
		$avance = $this->Modelo_avance->select_avance_por_id($id_avance);

		if ($proyecto && $avance && !$proyecto->finalizado) {
			$actividad = $this->Modelo_actividad->select_actividad_con_personal($avance->id_actividad);

			if ($actividad && !$actividad->finalizada && $actividad->usuarios && is_value_in_array($this->session->userdata("id"), $actividad->usuarios, "id")) {
				$titulo = "Registrar archivos";
				$extensiones_validas = Archivo::EXTENSIONES_VALIDAS;
				$reglas_cliente = $this->item_validacion->get_reglas_cliente(array("archivos[]"));

				$datos = array();
				$datos["titulo"] = $titulo;
				$datos["proyecto"] = $proyecto;
				$datos["actividad"] = $actividad;
				$datos["avance"] = $avance;
				$datos["extensiones_validas"] = $extensiones_validas;
				$datos["reglas_cliente"] = $reglas_cliente;

				$this->load->view("archivos/formulario_archivo", $datos);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function registrar_archivo_bd($id_proyecto, $id_avance) {
		$id_usuario = $this->session->userdata("id");
		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario);
		$avance = $this->Modelo_avance->select_avance_por_id($id_avance);

		if ($proyecto && $avance && !$proyecto->finalizado) {
			$actividad = $this->Modelo_actividad->select_actividad_con_personal($avance->id_actividad);

			if ($actividad && !$actividad->finalizada && $actividad->usuarios && is_value_in_array($this->session->userdata("id"), $actividad->usuarios, "id")) {
				$archivos = $this->archivo->subir_archivos("archivos", $proyecto->nombre . "/" . $actividad->nombre);

				if ($archivos) {
					if ($this->Modelo_documento_avance->insert_documentos($id_avance, $archivos)) {
						redirect(base_url("avance/ver_avances/" . $id_proyecto));
					} else {
						redirect(base_url("avance/ver_avances/" . $id_proyecto), "refresh");
					}
				} else {
					redirect(base_url("archivos/registrar_archivo/" . $id_proyecto . "/" . $id_avance), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	public function eliminar_archivo($id_proyecto = FALSE, $id_archivo = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "técnico") {
			if ($id_archivo) {
				$this->eliminar_archivo_bd($id_proyecto, $id_archivo);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function eliminar_archivo_bd($id_proyecto, $id_archivo) {
		$id_usuario = $this->session->userdata("id");
		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario);
		$archivo = $this->Modelo_documento_avance->select_archivo_por_id($id_archivo);

		if ($proyecto && !$proyecto->finalizado) {
			$avance = $this->Modelo_avance->select_avance_por_id($archivo->id_avance);

			if ($avance) {
				$actividad = $this->Modelo_actividad->select_actividad_con_personal($avance->id_actividad);

				if ($actividad && !$actividad->finalizada && $actividad->usuarios && is_value_in_array($this->session->userdata("id"), $actividad->usuarios, "id")) {
					if ($this->Modelo_documento_avance->delete_documento($id_archivo)) {
						redirect(base_url("avance/ver_avances/" . $id_proyecto));
					} else {
						redirect(base_url("avance/ver_avances/" . $id_proyecto), "refresh");
					}
				} else {
					redirect(base_url("proyecto/proyectos"));
				}
			} else {
				redirect(base_url());
			}
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

}
