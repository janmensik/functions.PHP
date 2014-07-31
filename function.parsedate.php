<?php

/**
 * int parsedate (string [, bool force_nonull ])
 *
 * Purpose:  Convert text date ('21. 5. 2008', '21.05.2008', atd) na timestamp (poledne!)
 *
 * If 2. param is TRUE and function should return null, return now() instead.
 *
 * @param string, string
 * @return int (unix timestmap)
 */

function parsedate ($data, $force = false) {
	# timestmamp
	if (preg_match ('/([0-9]{9,11})/', $data, $datum))
		$output = $datum[1];
	# 21. [0]9. 2013 [11:30.59]
	elseif (preg_match ('/([0-9]{1,2})\. ?([0-9]{1,2})\. ?([1-9][0-9]{3})( ?-? *([0-9]{1,2}):([0-9]{1,2})([:.]([0-9]{1,2}))?)?/', $data, $datum))
		$output = mktime (isset ($datum[5]) ? $datum[5] : 12, $datum[6] ? $datum[6] : 0, $datum[8] ? $datum[8] : 0, $datum[2], $datum[1], $datum[3]);
	# 21. [0]9. [11:30.59]  - bez roku
	elseif (preg_match ('/([0-9]{1,2})\. ?([0-9]{1,2})\. ?( ?-? *([0-9]{1,2}):([0-9]{1,2})([:.]([0-9]{1,2}))?)?/', $data, $datum2)) {
		$output = mktime (isset ($datum2[4]) ? $datum2[4] : 12, $datum2[5] ? $datum2[5] : 0, $datum2[7] ? $datum2[7] : 0, $datum2[2], $datum2[1]);
		//print_r ($data);
		}
	elseif ($force)
		$output = mktime (12,0,0);
	else
		$output = null;
	
	return ($output);
	}
?>