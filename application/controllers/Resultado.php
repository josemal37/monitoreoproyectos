<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Resultado
 *
 * @author Jose
 */
require_once 'Coordinador.php';

class Resultado extends Coordinador {

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_resultado", "Modelo_proyecto", "Modelo_rol_proyecto"));

		$this->load->library(array("Item_validacion"));

		$this->load->database("default");
	}

	public function registrar_resultado($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto) {
				if (isset($_POST["submit"])) {
					$this->registrar_resultado_bd($id_proyecto);
				} else {
					$this->cargar_vista_registrar_resultado($id_proyecto);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_resultado($id_proyecto) {
		$titulo = "Registrar resultado";
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);

		if ($proyecto && !$proyecto->finalizado) {
			$reglas_cliente = $this->item_validacion->get_reglas_cliente(array("nombre"));
			
			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["reglas_cliente"] = $reglas_cliente;

			$this->load->view("resultado/formulario_resultado", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function registrar_resultado_bd($id_proyecto) {
		$nombre = $this->input->post("nombre");

		if ($this->item_validacion->validar(array("nombre"))) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			if ($proyecto && !$proyecto->finalizado) {
				if ($this->Modelo_resultado->insert_resultado($id_proyecto, $nombre)) {
					redirect(base_url("marco_logico/editar_marco_logico/" . $id_proyecto));
				} else {
					redirect(base_url("resultado/registrar_resultado/" . $id_proyecto), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_resultado($id_proyecto);
		}
	}

	public function modificar_resultado($id_proyecto = FALSE, $id_resultado = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_resultado) {
				if (isset($_POST["submit"])) {
					$this->modificar_resultado_bd($id_proyecto, $id_resultado);
				} else {
					$this->cargar_vista_modificar_resultado($id_proyecto, $id_resultado);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_modificar_resultado($id_proyecto, $id_resultado) {
		$titulo = "Modificar resultado";
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$resultado = $this->Modelo_resultado->select_resultado_de_proyecto($id_resultado, $id_proyecto);

		if ($proyecto && $resultado && !$proyecto->finalizado) {
			$reglas_cliente = $this->item_validacion->get_reglas_cliente(array("nombre"));
			
			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["resultado"] = $resultado;
			$datos["reglas_cliente"] = $reglas_cliente;

			$this->load->view("resultado/formulario_resultado", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function modificar_resultado_bd($id_proyecto, $id_resultado) {
		$nombre = $this->input->post("nombre");

		if ($this->item_validacion->validar(array("nombre"))) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			$resultado = $this->get_resultado_de_proyecto($id_resultado, $id_proyecto);
			if ($proyecto && $resultado && !$proyecto->finalizado) {
				if ($this->Modelo_resultado->update_resultado($id_resultado, $nombre)) {
					redirect(base_url("marco_logico/editar_marco_logico/" . $id_proyecto));
				} else {
					redirect(base_url("resultado/modificar_resultado/" . $id_proyecto . "/" . $id_resultado));
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_resultado($id_proyecto, $id_resultado);
		}
	}

	public function eliminar_resultado($id_proyecto = FALSE, $id_resultado = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_resultado) {
				$this->eliminar_resultado_bd($id_proyecto, $id_resultado);
			} else {
				redirect("proyecto/proyectos");
			}
		} else {
			redirect();
		}
	}

	private function eliminar_resultado_bd($id_proyecto, $id_resultado) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$resultado = $this->get_resultado_de_proyecto($id_resultado, $id_proyecto);

		if ($proyecto && $resultado && !$proyecto->finalizado) {
			if ($this->Modelo_resultado->delete_resultado($id_resultado)) {
				redirect(base_url("marco_logico/editar_marco_logico/" . $id_proyecto));
			} else {
				redirect(base_url("marco_logico/editar_marco_logico/" . $id_proyecto), "refresh");
			}
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

}
