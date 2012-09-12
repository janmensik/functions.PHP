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
	if (ereg ('([0-9]{1,2})\. ?([0-9]{1,2})\. ?([1-9][0-9]{3})( -? ?([0-9]{1,2}):([0-9]{1,2})([:.]([0-9]{1,2}))?)?', $data, $datum))
		$output = mktime ($datum[5] ? $datum[5] : 12,$datum[6] ? $datum[6] : 0, $datum[8] ? $datum[8] : 0, $datum[2], $datum[1], $datum[3]);
	elseif ($force)
		$output = mktime (12,0,0);
	else
		$output = null;
	
	return ($output);
	}
?>