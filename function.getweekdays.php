<?php

/**
 * Return content of dir
 *
 * @param       string   $dirname    The directory to delete
 * @return      bool|array     Returns array of content (dirs, files, etc), false on failure
 */
# ...................................................................
function getWeekdays ($from, $till = 0) {
	$from = intval ($from);
	$till = intval ($till);
	if ($from<1)
		return false;
	if ($till<$from)
		$till = time ();

	# ziskam vsechny datumy pro dany interval
	for ($i=0; $i <= round (($till - $from) / 86400); $i++)
		$output[date ('w', mktime (12, 0, 0, date ('n', $from), date ('j', $from) + $i, date ('Y', $from)))]++;

	return ($output);
	}
?>