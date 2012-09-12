<?php

/**
 * string doubleimplode (string, string, array)
 * 
 * Version: 1
 * Purpose:  Convert utf-8 string to ascii string (no diacritics).
 * Note: Only for Latin-1 and Czech (common) chars.
 *
 * @param string
 * @return string
 */

function doubleimplode ($separator1, $separator2, $data) {
	if (!is_array ($data))
		return ($data);

	$doubledata = false;

	foreach ($data as $key=>$value) {
		# 1 dimension
		if (!is_array ($value)) {
			$output[] = $value;
			}
		else {
			$output[] = implode ($separator1, $value);
			$doubledata = true;
			}
		}
	
	if ($doubledata)
		return (implode ($separator2, $output));
	else
		return (implode ($separator1, $output));
	}
?>