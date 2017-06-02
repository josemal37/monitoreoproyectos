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
				$path = $this->sanitize_spanish_filename($path);
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

	private function sanitize_spanish_filename($str, $relative_path = FALSE) {

		$str = str_replace(array('á', 'à', 'â', 'ã', 'ª', 'ä'), "a", $str);
		$str = str_replace(array('Á', 'À', 'Â', 'Ã', 'Ä'), "A", $str);
		$str = str_replace(array('Í', 'Ì', 'Î', 'Ï'), "I", $str);
		$str = str_replace(array('í', 'ì', 'î', 'ï'), "i", $str);
		$str = str_replace(array('é', 'è', 'ê', 'ë'), "e", $str);
		$str = str_replace(array('É', 'È', 'Ê', 'Ë'), "E", $str);
		$str = str_replace(array('ó', 'ò', 'ô', 'õ', 'ö', 'º'), "o", $str);
		$str = str_replace(array('Ó', 'Ò', 'Ô', 'Õ', 'Ö'), "O", $str);
		$str = str_replace(array('ú', 'ù', 'û', 'ü'), "u", $str);
		$str = str_replace(array('Ú', 'Ù', 'Û', 'Ü'), "U", $str);
		$str = str_replace(array('[', '^', '´', '`', '¨', '~', ']', ',', '+', '=', '&'), "", $str);
		$str = str_replace("ç", "c", $str);
		$str = str_replace("Ç", "C", $str);
		$str = str_replace("ñ", "n", $str);
		$str = str_replace("Ñ", "N", $str);
		$str = str_replace("Ý", "Y", $str);
		$str = str_replace("ý", "y", $str);

		return $str;
	}

}
