<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Actividad
 *
 * @author Jose
 */
require_once 'Coordinador.php';

class Actividad extends Coordinador {

	public function __construct() {
		parent::__construct();

		$this->load->library(array("Actividad_validacion"));
	}

	public function index() {
		$this->actividades();
	}

	public function actividades($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto) {
				$this->cargar_vista_actividades($id_proyecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_actividades($id_proyecto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);

		if ($proyecto) {
			$titulo = "Actividades";
			$actividades = $this->Modelo_actividad->select_actividades_de_proyecto($id_proyecto);

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["actividades"] = $actividades;

			$this->load->view("actividad/actividades", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	public function registrar_actividad($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto) {
				if (isset($_POST["submit"])) {
					$this->registrar_actividad_bd($id_proyecto);
				} else {
					$this->cargar_vista_registrar_actividad($id_proyecto);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_actividad($id_proyecto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);

		if ($proyecto) {
			$titulo = "Registrar actividad";
			$productos = $this->Modelo_producto->select_productos_de_proyecto($id_proyecto);
			$indicadores_producto = FALSE;

			if ($productos) {
				$indicadores_producto = $this->Modelo_indicador_producto->select_indicadores_producto_de_producto($productos[0]->id);
			}

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["productos"] = $productos;
			$datos["indicadores_producto"] = $indicadores_producto;

			$this->load->view("actividad/formulario_actividad", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function registrar_actividad_bd($id_proyecto) {
		$nombre = $this->input->post("nombre");
		$fecha_inicio = $this->input->post("fecha_inicio");
		$fecha_fin = $this->input->post("fecha_fin");
		$con_meta = $this->input->post("con-meta") == "on";
		$con_producto = $this->input->post("con-producto") == "on";
		
		$array_validacion = array("nombre", "fecha_inicio", "fecha_fin");

		if ($con_meta) {
			$cantidad = $this->input->post("cantidad");
			$unidad = $this->input->post("unidad");
			
			$array_validacion[] = "cantidad";
			$array_validacion[] = "unidad";
		}

		if ($con_producto) {
			$id_producto = $this->input->post("producto");
			$con_indicador_producto = $this->input->post("con-indicador-producto") == "on";
			
			$array_validacion[] = "producto";

			if ($con_indicador_producto) {
				$porcentaje = $this->input->post("porcentaje");
				$id_indicador_producto = $this->input->post("indicador-producto");
				
				$array_validacion[] = "porcentaje";
				$array_validacion[] = "indicador-producto";
			}
		}
		
		if ($this->actividad_validacion->validar($array_validacion)) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			
			if ($proyecto) {
				if ($this->Modelo_actividad->insert_actividad($id_proyecto, $nombre, $fecha_inicio, $fecha_fin, $con_meta, $cantidad, $unidad, $con_producto, $id_producto, $con_indicador_producto, $porcentaje, $id_indicador_producto)) {
					redirect(base_url("actividad/actividades/" . $id_proyecto));
				} else {
					redirect(base_url("actividad/registrar_actividad/" . $id_proyecto), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_actividad($id_proyecto);
		}
	}

}
