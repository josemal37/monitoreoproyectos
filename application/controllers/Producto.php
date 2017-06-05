<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Producto
 *
 * @author Jose
 */
require_once 'Coordinador.php';

class Producto extends Coordinador {

	public function __construct() {
		parent::__construct();

		$this->load->library(array("Item_validacion"));
	}

	public function registrar_producto($id_proyecto = FALSE, $id_efecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_efecto) {
				if (isset($_POST["submit"])) {
					$this->registrar_producto_bd($id_proyecto, $id_efecto);
				} else {
					$this->cargar_vista_registrar_producto($id_proyecto, $id_efecto);
				}
			} else {
				redirect(base_url("proyecto/proyectos"), "refresh");
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_producto($id_proyecto, $id_efecto) {
		$titulo = "Registrar producto";
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$efecto = $this->get_efecto_de_proyecto($id_efecto, $id_proyecto);

		if ($proyecto && $efecto && !$proyecto->finalizado) {
			$reglas_cliente = $this->item_validacion->get_reglas_cliente(array("descripcion"));
			
			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["efecto"] = $efecto;
			$datos["reglas_cliente"] = $reglas_cliente;

			$this->load->view("producto/formulario_producto", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function registrar_producto_bd($id_proyecto, $id_efecto) {
		$descripcion = $this->input->post("descripcion");

		if ($this->item_validacion->validar(array("descripcion"))) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			$efecto = $this->get_efecto_de_proyecto($id_efecto, $id_proyecto);

			if ($proyecto && $efecto && !$proyecto->finalizado) {
				if ($this->Modelo_producto->insert_producto($id_efecto, $descripcion)) {
					redirect(base_url("marco_logico/editar_marco_logico/" . $id_proyecto));
				} else {
					redirect(base_url("producto/registrar_producto/" . $id_proyecto . "/" . $id_efecto), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_producto($id_proyecto, $id_efecto);
		}
	}

	public function modificar_producto($id_proyecto = FALSE, $id_producto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_producto) {
				if (isset($_POST["submit"])) {
					$this->modificar_producto_bd($id_proyecto, $id_producto);
				} else {
					$this->cargar_vista_modificar_producto($id_proyecto, $id_producto);
				}
			} else {
				redirect(base_url("proyecto/proyectos"), "refresh");
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_modificar_producto($id_proyecto, $id_producto) {
		$titulo = "Modificar producto";
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$producto = $this->get_producto_de_proyecto($id_producto, $id_proyecto);

		if ($proyecto && $producto && !$proyecto->finalizado) {
			$efecto = $this->get_efecto_de_proyecto($producto->id_efecto, $id_proyecto);
			$reglas_cliente = $this->item_validacion->get_reglas_cliente(array("descripcion"));

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["efecto"] = $efecto;
			$datos["producto"] = $producto;
			$datos["reglas_cliente"] = $reglas_cliente;

			$this->load->view("producto/formulario_producto", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}
	
	private function modificar_producto_bd($id_proyecto, $id_producto) {
		$descripcion = $this->input->post("descripcion");
		
		if ($this->item_validacion->validar(array("descripcion"))) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			$producto = $this->get_producto_de_proyecto($id_producto, $id_proyecto);
			
			if ($proyecto && $producto && !$proyecto->finalizado) {
				if ($this->Modelo_producto->update_producto($id_producto, $descripcion)) {
					redirect(base_url("marco_logico/editar_marco_logico/" . $id_proyecto));
				} else {
					redirect(base_url("producto/modificar_producto/" . $id_proyecto . "/" . $id_producto), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_producto($id_proyecto, $id_producto);
		}
	}
	
	public function eliminar_producto($id_proyecto = FALSE, $id_producto = FALSE) {
		$rol = $this->session->userdata("rol");
		
		if ($rol == "empleado") {
			if ($id_proyecto && $id_producto) {
				$this->eliminar_producto_bd($id_proyecto, $id_producto);
			} else {
				redirect(base_url("proyecto/proyectos"), "refresh");
			}
		} else {
			redirect(base_url());
		}
	}
	
	private function eliminar_producto_bd($id_proyecto, $id_producto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$producto = $this->get_producto_de_proyecto($id_producto, $id_proyecto);
		
		if ($proyecto && $producto && !$proyecto->finalizado) {
			if ($this->Modelo_producto->delete_producto($id_producto)) {
				redirect(base_url("marco_logico/editar_marco_logico/" . $id_proyecto));
			} else {
				redirect(base_url("marco_logico/editar_marco_logico/" . $id_proyecto), "refresh");
			}
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

}
