<?php

/**
 * Return content of dir
 *
 * @param       string   $num   
 * @return      float     Converted float number for DB (always 12.345) , no matter setlocale
 */
function get_db_float($num) {
	preg_match ('/^([0-9]+)(,|\.)*([0-9]*)/x', $num, $cislo);

	return ($cislo[1] . ($cislo[3] ? '.'.$cislo[3] : ''));
	}
?>