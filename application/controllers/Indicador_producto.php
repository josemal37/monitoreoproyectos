<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Indicador_producto
 *
 * @author Jose
 */
require_once 'Coordinador.php';

class Indicador_producto extends Coordinador {

	public function __construct() {
		parent::__construct();

		$this->load->library(array("Item_validacion"));
	}

	public function registrar_indicador_producto($id_proyecto = FALSE, $id_producto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_producto) {
				if (isset($_POST["submit"])) {
					$this->registrar_indicador_producto_bd($id_proyecto, $id_producto);
				} else {
					$this->cargar_vista_registrar_indicador_producto($id_proyecto, $id_producto);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_indicador_producto($id_proyecto, $id_producto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$producto = $this->get_producto_de_proyecto($id_producto, $id_proyecto);

		if ($proyecto && $producto) {
			$titulo = "Registrar indicador de producto";
			$indicadores_efecto = $this->Modelo_indicador_efecto->select_indicadores_efecto_de_efecto($producto->id_efecto);
			$reglas_cliente = $this->item_validacion->get_reglas_cliente(array("descripcion", "cantidad", "unidad", "porcentaje", "indicador-efecto"));

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["indicadores_efecto"] = $indicadores_efecto;
			$datos["producto"] = $producto;
			$datos["reglas_cliente"] = $reglas_cliente;

			$this->load->view("indicador_producto/formulario_indicador_producto", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function registrar_indicador_producto_bd($id_proyecto, $id_producto) {
		$descripcion = $this->input->post("descripcion");
		$con_meta = $this->input->post("con-meta") == "on";
		$con_indicador_efecto = $this->input->post("con-indicador-efecto") == "on";

		$array_validacion = array("descripcion");

		if ($con_meta) {
			$cantidad = $this->input->post("cantidad");
			$unidad = $this->input->post("unidad");

			$array_validacion[] = "cantidad";
			$array_validacion[] = "unidad";
		}

		if ($con_indicador_efecto) {
			$id_indicador_efecto = $this->input->post("indicador-efecto");
			$porcentaje = $this->input->post("porcentaje");

			$array_validacion[] = "indicador-efecto";
			$array_validacion[] = "porcentaje";
		}

		if ($this->item_validacion->validar($array_validacion)) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			$producto = $this->get_producto_de_proyecto($id_producto, $id_proyecto);

			if ($proyecto && $producto) {
				if ($this->Modelo_indicador_producto->insert_indicador_producto($id_producto, $descripcion, $con_meta, $cantidad, $unidad, $con_indicador_efecto, $id_indicador_efecto, $porcentaje)) {
					redirect(base_url("marco_logico/editar_marco_logico/" . $id_proyecto));
				} else {
					redirect(base_url("indicador_producto/registrar_indicador_producto/" . $id_proyecto . "/" . $id_producto), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_indicador_producto($id_proyecto, $id_producto);
		}
	}

	public function modificar_indicador_producto($id_proyecto = FALSE, $id_indicador_producto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_indicador_producto) {
				if (isset($_POST["submit"])) {
					$this->modificar_indicador_producto_bd($id_proyecto, $id_indicador_producto);
				} else {
					$this->cargar_vista_modificar_indicador_producto($id_proyecto, $id_indicador_producto);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_modificar_indicador_producto($id_proyecto, $id_indicador_producto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$indicador_producto = $this->get_indicador_producto_de_proyecto($id_indicador_producto, $id_proyecto);

		if ($proyecto && $indicador_producto) {
			$titulo = "Modificar indicador producto";
			$producto = $this->get_producto_de_proyecto($indicador_producto->id_producto, $id_proyecto);
			$indicadores_efecto = $this->Modelo_indicador_efecto->select_indicadores_efecto_de_efecto($producto->id_efecto);
			$reglas_cliente = $this->item_validacion->get_reglas_cliente(array("descripcion", "cantidad", "unidad", "porcentaje", "indicador-efecto"));

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["indicador_producto"] = $indicador_producto;
			$datos["producto"] = $producto;
			$datos["indicadores_efecto"] = $indicadores_efecto;
			$datos["reglas_cliente"] = $reglas_cliente;

			$this->load->view("indicador_producto/formulario_indicador_producto", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function modificar_indicador_producto_bd($id_proyecto, $id_indicador_producto) {
		$descripcion = $this->input->post("descripcion");
		$con_meta = $this->input->post("con-meta") == "on";
		$con_indicador_efecto = $this->input->post("con-indicador-efecto") == "on";

		$array_validacion = array("descripcion");

		if ($con_meta) {
			$cantidad = $this->input->post("cantidad");
			$unidad = $this->input->post("unidad");

			$array_validacion[] = "cantidad";
			$array_validacion[] = "unidad";
		}

		if ($con_indicador_efecto) {
			$id_indicador_efecto = $this->input->post("indicador-efecto");
			$porcentaje = $this->input->post("porcentaje");

			$array_validacion[] = "indicador-efecto";
			$array_validacion[] = "porcentaje";
		}

		if ($this->item_validacion->validar($array_validacion)) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			$indicador_producto = $this->get_indicador_producto_de_proyecto($id_indicador_producto, $id_proyecto);

			if ($proyecto && $indicador_producto) {
				if ($this->Modelo_indicador_producto->update_indicador_producto($id_indicador_producto, $descripcion, $con_meta, $cantidad, $unidad, $con_indicador_efecto, $id_indicador_efecto, $porcentaje)) {
					redirect(base_url("marco_logico/editar_marco_logico/" . $id_proyecto));
				} else {
					redirect(base_url("indicador_producto/modificar_indicador_producto/" . $id_proyecto . "/" . $id_indicador_producto), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_indicador_producto($id_proyecto, $id_indicador_producto);
		}
	}

	public function eliminar_indicador_producto($id_proyecto = FALSE, $id_indicador_producto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_indicador_producto) {
				$this->eliminar_indicador_producto_bd($id_proyecto, $id_indicador_producto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function eliminar_indicador_producto_bd($id_proyecto, $id_indicador_producto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$indicador_producto = $this->get_indicador_producto_de_proyecto($id_indicador_producto, $id_proyecto);

		if ($proyecto && $indicador_producto) {
			if ($this->Modelo_indicador_producto->delete_indicador_producto($id_indicador_producto)) {
				redirect(base_url("marco_logico/editar_marco_logico/" . $id_proyecto));
			} else {
				redirect(base_url("marco_logico/editar_marco_logico/" . $id_proyecto), "refresh");
			}
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

}
