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
		$this->load->model(array("Modelo_proyecto", "Modelo_rol_proyecto"));
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
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function cargar_vista_registrar_proyecto() {
		$titulo = "Registrar proyecto";
		$reglas_cliente = $this->proyecto_validacion->get_reglas_cliente(array("nombre", "objetivo", "fecha_inicio", "fecha_fin"));

		$datos = array();
		$datos["titulo"] = $titulo;
		$datos["reglas_cliente"] = $reglas_cliente;

		$this->load->view("proyecto/formulario_proyecto", $datos);
	}

	private function registrar_proyecto_bd() {
		$nombre = $this->input->post("nombre");
		$objetivo = $this->input->post("objetivo");
		$fecha_inicio = $this->input->post("fecha_inicio");
		$fecha_fin = $this->input->post("fecha_fin");
		$id_usuario = $this->session->userdata("id");

		if ($this->proyecto_validacion->validar(array("nombre", "objetivo", "fecha_inicio", "fecha_fin"))) {
			if ($this->Modelo_proyecto->insert_proyecto($nombre, $objetivo, $fecha_inicio, $fecha_fin, $id_usuario)) {
				redirect(base_url("proyecto/proyectos"));
			} else {
				redirect(base_url("proyecto/registrar_proyecto"), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_proyecto();
		}
	}

	public function modificar_proyecto($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id) {
				if (isset($_POST["submit"])) {
					$this->modificar_proyecto_bd();
				} else {
					$this->cargar_vista_modificar_proyecto($id);
				}
			} else {
				redirect(base_url("proyecto/proyectos"), "refresh");
			}
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function cargar_vista_modificar_proyecto($id) {
		$titulo = "Modificar proyecto";
		$id_usuario = $this->session->userdata("id");
		$id_rol_coordinador = $this->Modelo_rol_proyecto->select_id_rol_coordinador();
		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id, $id_usuario, $id_rol_coordinador);
		$reglas_cliente = $this->proyecto_validacion->get_reglas_cliente(array("id", "nombre", "objetivo", "fecha_inicio", "fecha_fin"));

		if ($proyecto) {
			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["reglas_cliente"] = $reglas_cliente;

			$this->load->view("proyecto/formulario_proyecto", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function modificar_proyecto_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$objetivo = $this->input->post("objetivo");
		$fecha_inicio = $this->input->post("fecha_inicio");
		$fecha_fin = $this->input->post("fecha_fin");

		if ($this->proyecto_validacion->validar(array("id", "nombre", "objetivo", "fecha_inicio", "fecha_fin"))) {
			if ($this->Modelo_proyecto->update_proyecto($id, $nombre, $objetivo, $fecha_inicio, $fecha_fin)) {
				redirect(base_url("proyecto/proyectos"));
			} else {
				redirect(base_url("proyecto/modificar_proyecto/" . $id), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_proyecto($id);
		}
	}

	public function eliminar_proyecto($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id) {
				$this->eliminar_proyecto_bd($id);
			} else {
				redirect(base_url("proyecto/proyectos"), "refresh");
			}
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function eliminar_proyecto_bd($id) {
		$id_usuario = $this->session->userdata("id");
		$id_rol_coordinador = $this->Modelo_rol_proyecto->select_id_rol_coordinador();
		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id, $id_usuario, $id_rol_coordinador);

		if ($proyecto) {
			if ($this->Modelo_proyecto->delete_proyecto($id)) {
				redirect(base_url("proyecto/proyectos"));
			} else {
				redirect(base_url("proyecto/proyectos"), "refresh");
			}
		} else {
			redirect(base_url("proyecto/proyectos"), "refresh");
		}
	}

}
