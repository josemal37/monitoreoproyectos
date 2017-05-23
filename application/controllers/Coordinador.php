<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Coordinador
 *
 * @author Jose
 */
abstract class Coordinador extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model(array(
			"Modelo_proyecto",
			"Modelo_efecto",
			"Modelo_producto",
			"Modelo_resultado",
			"Modelo_resultado_clave",
			"Modelo_indicador_impacto",
			"Modelo_meta_impacto",
			"Modelo_indicador_efecto",
			"Modelo_meta_efecto",
			"Modelo_indicador_producto",
			"Modelo_meta_producto",
			"Modelo_rol_proyecto",
			"Modelo_actividad",
			"Modelo_meta_actividad",
			"Modelo_usuario",
			"Modelo_proyecto_usuario",
			"Modelo_actividad_usuario",
			"Modelo_rol"
		));

		$this->load->database("default");
	}

	public function index() {
		redirect(base_url());
	}

	protected function get_proyecto_de_coordinador($id_proyecto) {
		$id_usuario = $this->session->userdata("id");
		$id_rol_coordinador = $this->Modelo_rol_proyecto->select_id_rol_coordinador();
		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario, $id_rol_coordinador);

		return $proyecto;
	}

	protected function get_resultado_de_proyecto($id_resultado, $id_proyecto) {
		$resultado = $this->Modelo_resultado->select_resultado_de_proyecto($id_resultado, $id_proyecto);

		return $resultado;
	}

	protected function get_resultado_clave_de_proyecto($id_resultado_clave, $id_proyecto) {
		$resultado_clave = $this->Modelo_resultado_clave->select_resultado_clave_de_proyecto($id_resultado_clave, $id_proyecto);

		return $resultado_clave;
	}

	protected function get_efecto_de_proyecto($id_efecto, $id_proyecto) {
		$efecto = $this->Modelo_efecto->select_efecto_de_proyecto($id_efecto, $id_proyecto);

		return $efecto;
	}

	protected function get_producto_de_proyecto($id_producto, $id_proyecto) {
		$producto = $this->Modelo_producto->select_producto_de_proyecto($id_producto, $id_proyecto);

		return $producto;
	}

	protected function get_indicador_impacto_de_proyecto($id_indicador_impacto, $id_proyecto) {
		$indicador = $this->Modelo_indicador_impacto->select_indicador_impacto_de_proyecto($id_indicador_impacto, $id_proyecto);

		return $indicador;
	}

	protected function get_indicador_efecto_de_proyecto($id_indicador_efecto, $id_proyecto) {
		$indicador = $this->Modelo_indicador_efecto->select_indicador_efecto_de_proyecto($id_indicador_efecto, $id_proyecto);

		return $indicador;
	}

	protected function get_indicador_producto_de_proyecto($id_indicador_producto, $id_proyecto) {
		$indicador = $this->Modelo_indicador_producto->select_indicador_producto_de_proyecto($id_indicador_producto, $id_proyecto);

		return $indicador;
	}

	protected function get_actividad_de_proyecto($id_actividad, $id_proyecto) {
		$actividad = $this->Modelo_actividad->select_actividad_de_proyecto($id_actividad, $id_proyecto);

		return $actividad;
	}

}
