<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Personal
 *
 * @author Jose
 */
require_once 'Coordinador.php';

class Personal extends Coordinador {

	public function __construct() {
		parent::__construct();

		$this->load->library(array("Usuario_validacion"));
	}

	public function personal_proyecto($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto) {
				$this->cargar_vista_personal_proyecto($id_proyecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_personal_proyecto($id_proyecto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);

		if ($proyecto) {
			$titulo = "Personal del proyecto";
			$usuarios = $this->Modelo_usuario->select_usuarios_de_proyecto($id_proyecto);

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["usuarios"] = $usuarios;

			$this->load->view("personal/personal_proyecto", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	public function registrar_personal_proyecto($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto) {
				if (isset($_POST["submit"])) {
					$this->registrar_personal_proyecto_bd($id_proyecto);
				} else {
					$this->cargar_vista_registrar_personal_proyecto($id_proyecto);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_personal_proyecto($id_proyecto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);

		if ($proyecto) {
			$titulo = "Registrar personal";
			$usuarios = $this->Modelo_usuario->select_usuarios_empleados();
			$roles = $this->Modelo_rol_proyecto->select_roles();

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["usuarios"] = $usuarios;
			$datos["roles"] = $roles;

			$this->load->view("personal/formulario_personal", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function registrar_personal_proyecto_bd($id_proyecto) {
		$id_usuario = $this->input->post("usuario");
		$id_rol_proyecto = $this->input->post("rol_proyecto");

		if ($this->usuario_validacion->validar(array("usuario", "rol_proyecto"))) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);

			if ($proyecto) {
				if ($this->Modelo_proyecto_usuario->insert_proyecto_usuario($id_usuario, $id_proyecto, $id_rol_proyecto)) {
					redirect(base_url("personal/personal_proyecto/" . $id_proyecto));
				} else {
					$this->session->set_flashdata("error", "El usuario seleccionado ya se encuentra registrado en este proyecto.");
					redirect(base_url("personal/registrar_personal_proyecto/" . $id_proyecto), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_personal_proyecto($id_proyecto);
		}
	}

}
