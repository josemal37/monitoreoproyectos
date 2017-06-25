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
		$this->load->model(array("Modelo_proyecto", "Modelo_rol_proyecto", "Modelo_actividad", "Modelo_financiador", "Modelo_tipo_financiador", "Modelo_aporte"));
		$this->load->library(array("Proyecto_validacion"));
		$this->load->database("default");
	}

	public function index() {
		$this->proyectos();
	}

	public function proyectos() {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado" || $rol == "dirección") {
			$this->cargar_vista_proyectos();
		} else {
			redirect(base_url());
		}
	}

	public function proyectos_terminados() {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado" || $rol == "dirección") {
			$this->cargar_vista_proyectos(TRUE);
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_proyectos($finalizado = FALSE) {
		$titulo = "Proyectos";
		$id_usuario = $this->session->userdata("id");

		$direccion = FALSE;
		if ($this->session->userdata("rol") == "dirección") {
			$direccion = TRUE;
		}

		$proyectos = $this->Modelo_proyecto->select_proyectos_de_usuario($id_usuario, $finalizado, $direccion);

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
		$reglas_cliente = $this->proyecto_validacion->get_reglas_cliente(array(
			"nombre",
			"objetivo",
			"fecha_inicio",
			"fecha_fin",
			"instituciones-ejecutores[]",
			"cantidades-ejecutores[]",
			"conceptos-ejecutores[]",
			"instituciones-financiadores[]",
			"cantidades-financiadores[]",
			"conceptos-financiadores[]",
			"instituciones-otros[]",
			"cantidades-otros[]",
			"conceptos-otros[]"
		));
		$financiadores = $this->Modelo_financiador->select_financiadores();

		$datos = array();
		$datos["titulo"] = $titulo;
		$datos["reglas_cliente"] = $reglas_cliente;
		$datos["financiadores"] = $financiadores;

		$this->load->view("proyecto/formulario_proyecto", $datos);
	}

	private function registrar_proyecto_bd() {
		$nombre = $this->input->post("nombre");
		$objetivo = $this->input->post("objetivo");
		$fecha_inicio = $this->input->post("fecha_inicio");
		$fecha_fin = $this->input->post("fecha_fin");
		$id_usuario = $this->session->userdata("id");
		$reglas_validacion = array("nombre", "objetivo", "fecha_inicio", "fecha_fin");

		$con_financiadores = $this->input->post("con-financiadores") == "on";

		$instituciones_ejecutores = FALSE;
		$cantidades_ejecutores = FALSE;
		$conceptos_ejecutores = FALSE;
		$instituciones_financiadores = FALSE;
		$cantidades_financiadores = FALSE;
		$conceptos_financiadores = FALSE;
		$instituciones_otros = FALSE;
		$cantidades_otros = FALSE;
		$conceptos_otros = FALSE;

		if ($con_financiadores) {
			if (isset($_POST["instituciones-ejecutores"])) {
				$instituciones_ejecutores = $this->input->post("instituciones-ejecutores");
				$cantidades_ejecutores = $this->input->post("cantidades-ejecutores");
				$conceptos_ejecutores = $this->input->post("conceptos-ejecutores");

				$reglas_validacion[] = "instituciones-ejecutores";
				$reglas_validacion[] = "cantidades-ejecutores";
				$reglas_validacion[] = "conceptos-ejecutores";
			}

			if (isset($_POST["instituciones-financiadores"])) {
				$instituciones_financiadores = $this->input->post("instituciones-financiadores");
				$cantidades_financiadores = $this->input->post("cantidades-financiadores");
				$conceptos_financiadores = $this->input->post("conceptos-financiadores");

				$reglas_validacion[] = "instituciones-financiadores";
				$reglas_validacion[] = "cantidades-financiadores";
				$reglas_validacion[] = "conceptos-financiadores";
			}

			if (isset($_POST["instituciones-otros"])) {
				$instituciones_otros = $this->input->post("instituciones-otros");
				$cantidades_otros = $this->input->post("cantidades-otros");
				$conceptos_otros = $this->input->post("conceptos-otros");

				$reglas_validacion[] = "instituciones-otros";
				$reglas_validacion[] = "cantidades-otros";
				$reglas_validacion[] = "conceptos-otros";
			}
		}

		if ($this->proyecto_validacion->validar($reglas_validacion)) {
			if ($this->Modelo_proyecto->insert_proyecto($nombre, $objetivo, $fecha_inicio, $fecha_fin, $id_usuario, $con_financiadores, $instituciones_ejecutores, $cantidades_ejecutores, $conceptos_ejecutores, $instituciones_financiadores, $cantidades_financiadores, $conceptos_financiadores, $instituciones_otros, $cantidades_otros, $conceptos_otros)) {
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
		$reglas_cliente = $this->proyecto_validacion->get_reglas_cliente(array(
			"id",
			"nombre",
			"objetivo",
			"fecha_inicio",
			"fecha_fin",
			"instituciones-ejecutores[]",
			"cantidades-ejecutores[]",
			"conceptos-ejecutores[]",
			"instituciones-financiadores[]",
			"cantidades-financiadores[]",
			"conceptos-financiadores[]",
			"instituciones-otros[]",
			"cantidades-otros[]",
			"conceptos-otros[]"
		));

		if ($proyecto && !$proyecto->finalizado) {
			$financiadores = $this->Modelo_financiador->select_financiadores();
			$id_ejecutor = $this->Modelo_tipo_financiador->select_id_ejecutor();
			$id_financiador = $this->Modelo_tipo_financiador->select_id_financiador();
			$id_otro = $this->Modelo_tipo_financiador->select_id_otro();

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["reglas_cliente"] = $reglas_cliente;
			$datos["financiadores"] = $financiadores;
			$datos["id_ejecutor"] = $id_ejecutor;
			$datos["id_financiador"] = $id_financiador;
			$datos["id_otro"] = $id_otro;

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
		$reglas_validacion = array("nombre", "objetivo", "fecha_inicio", "fecha_fin");

		$con_financiadores = $this->input->post("con-financiadores") == "on";

		$instituciones_ejecutores = FALSE;
		$cantidades_ejecutores = FALSE;
		$conceptos_ejecutores = FALSE;
		$instituciones_financiadores = FALSE;
		$cantidades_financiadores = FALSE;
		$conceptos_financiadores = FALSE;
		$instituciones_otros = FALSE;
		$cantidades_otros = FALSE;
		$conceptos_otros = FALSE;

		if ($con_financiadores) {
			if (isset($_POST["instituciones-ejecutores"])) {
				$instituciones_ejecutores = $this->input->post("instituciones-ejecutores");
				$cantidades_ejecutores = $this->input->post("cantidades-ejecutores");
				$conceptos_ejecutores = $this->input->post("conceptos-ejecutores");

				$reglas_validacion[] = "instituciones-ejecutores";
				$reglas_validacion[] = "cantidades-ejecutores";
				$reglas_validacion[] = "conceptos-ejecutores";
			}

			if (isset($_POST["instituciones-financiadores"])) {
				$instituciones_financiadores = $this->input->post("instituciones-financiadores");
				$cantidades_financiadores = $this->input->post("cantidades-financiadores");
				$conceptos_financiadores = $this->input->post("conceptos-financiadores");

				$reglas_validacion[] = "instituciones-financiadores";
				$reglas_validacion[] = "cantidades-financiadores";
				$reglas_validacion[] = "conceptos-financiadores";
			}

			if (isset($_POST["instituciones-otros"])) {
				$instituciones_otros = $this->input->post("instituciones-otros");
				$cantidades_otros = $this->input->post("cantidades-otros");
				$conceptos_otros = $this->input->post("conceptos-otros");

				$reglas_validacion[] = "instituciones-otros";
				$reglas_validacion[] = "cantidades-otros";
				$reglas_validacion[] = "conceptos-otros";
			}
		}

		if ($this->proyecto_validacion->validar($reglas_validacion)) {
			if ($this->Modelo_proyecto->update_proyecto($id, $nombre, $objetivo, $fecha_inicio, $fecha_fin, $con_financiadores, $instituciones_ejecutores, $cantidades_ejecutores, $conceptos_ejecutores, $instituciones_financiadores, $cantidades_financiadores, $conceptos_financiadores, $instituciones_otros, $cantidades_otros, $conceptos_otros)) {
				redirect(base_url("marco_logico/editar_marco_logico/" . $id));
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

		if ($proyecto && !$proyecto->finalizado) {
			if ($this->Modelo_proyecto->delete_proyecto($id)) {
				redirect(base_url("proyecto/proyectos"));
			} else {
				redirect(base_url("proyecto/proyectos"), "refresh");
			}
		} else {
			redirect(base_url("proyecto/proyectos"), "refresh");
		}
	}

	public function cerrar_proyecto($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id) {
				$this->cerrar_proyecto_bd($id);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cerrar_proyecto_bd($id = FALSE) {
		$id_usuario = $this->session->userdata("id");
		$id_rol_coordindador = $this->Modelo_rol_proyecto->select_id_rol_coordinador();

		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id, $id_usuario, $id_rol_coordindador);

		if ($proyecto) {
			if ($this->Modelo_proyecto->finalizar_proyecto($id)) {
				redirect(base_url("avance/ver_avances/" . $id));
			} else {
				redirect(base_url("avance/ver_avances/" . $id), "refresh");
			}
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

}
