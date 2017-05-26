<?php

function sanitize_spanish_filename($str, $relative_path = FALSE) {
	
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
