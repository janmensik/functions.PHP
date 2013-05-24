<?php

/**
 * int countdays (timestamp, timestamp)
 *
 * Purpose:  Count number of day between  2 timestamps ('22.05.2013 11:30', '21. 5. 2013 9:00' = 1)
 *
 * @param int (unix timestmap), int (unix timestmap)
 * @return int
 */

function countdays ($from, $till) {
	if (!$from || !$till)
		return (0);
	$dd = date_diff (new DateTime ('@'.intval ($from)), new DateTime ('@'.intval ($till)));
	
	return (round ($dd->days));
	}
?>