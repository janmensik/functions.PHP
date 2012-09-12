<?php

/**
 * string text2seolink (string)
 *
 * Purpose:  Convert utf-8 string to seo-like string for link ("Hello-World! - Go hell." => "hello-world-go-hell")
 * Note: Only for Latin-1 and Czech (common) chars (utf2ascii).
 *
 * @param string
 * @return string
 * 
 * require: utf2ascii()
 */

require_once ('function.utf2ascii.php');

function text2seolink ($string) {
	# convert to ascii
	$string = utf2ascii ($string);

	# main magic
	$string =  strtolower (eregi_replace ("[^a-z0-9-]", "-", $string));

	# we don't want "text - text" to be "text---text" but "text-text"
	$string = ereg_replace ("-{2,}", "-", $string);

	# we dont want "-" on beginning or end for string
	if (substr ($string, 0, 1) == "-")
		$string = substr ($string, 1);
	if (substr ($string, -1) == "-")
		$string = substr ($string, 0, -1);

	return $string;
	}
?>