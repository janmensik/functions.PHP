<?php

/**
 * Return content of dir
 *
 * @param       string   $dirname    The directory to delete
 * @return      bool|array     Returns array of content (dirs, files, etc), false on failure
 */
function getdir($dirname) {
	# prohledam adresar a hledam odpovijici obrazky, priradim do vysledku
	$dir = @opendir ($dirname);
	if ($dir)	{
		while ($soubor = readdir ($dir)) {
			$output[] = $soubor;
			}
		closedir ($dir);
		return ($output);
		}
	else 
		return (false);
	}
?>