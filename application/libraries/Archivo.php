<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Archivo
 *
 * @author Jose
 */
class Archivo {

	protected $ci;

	const PATH_BASE_ARCHIVO = "archivos/";
	const EXTENSIONES_VALIDAS = "pdf|doc|docx|xls|xlsx|ppt|pptx|jpg|png|gif|rar|zip";

	public function __construct() {
		$this->ci = & get_instance();

		$this->ci->load->library(array("Upload"));

		$this->ci->load->helper(array("Security_helper"));
	}

	public function subir_archivos($archivos = FALSE, $path = FALSE) {
		$subidos = FALSE;

		if ($archivos) {
			if ($path) {
				$path = sanitize_spanish_filename($path);
				$path = str_replace(" ", "_", $path);
				$path = self::PATH_BASE_ARCHIVO . $path;
			} else {
				$path = self::PATH_BASE_ARCHIVO;
			}

			if ($this->crear_directorio($path)) {
				$subidos = $this->guardar_archivos($path, $archivos);
			} else {
				$this->ci->session->set_flashdata("error_archivo", "Ocurrió un error al preparar el dorectorio de los archivos.");
			}
		} else {
			$this->ci->session->set_flashdata("error_archivo", "Ocurrió un error al procesar los archivos.");
		}

		return $subidos;
	}

	private function guardar_archivos($path, $archivos) {
		$guardado = FALSE;
		
		$this->ci->upload->initialize(array(
			"upload_path" => $path,
			"allowed_types" => self::EXTENSIONES_VALIDAS
		));

		if ($this->ci->upload->do_multi_upload($archivos)) {
			$guardado = $this->ci->upload->get_multi_upload_data();
			
			if ($guardado) {
				$i = 0;
				foreach ($guardado as $archivo) {
					$guardado[$i]["path"] = $path . "/" . $archivo["file_name"];
					$i += 1;
				}
			}
		} else {
			$this->ci->session->set_flashdata("error_archivo", implode(" ", $this->ci->upload->error_msg));
		}
		
		return $guardado;
	}

	private function crear_directorio($path) {
		$creado = FALSE;

		if (!file_exists($path)) {
			$creado = mkdir($path, 0777, TRUE);
		} else if (!is_dir($path)) {
			$creado = mkdir($path, 0777, TRUE);
		} else {
			$creado = TRUE;
		}

		return $creado;
	}

}
