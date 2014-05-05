<?php

/**
 * array (int from, int till) text2timeinterval (string [, int now])
 *
 * Purpose:  Convert string (like yasterday, lastweek, etc.) to time interval based on $now timestamp
 * Note: Returns array of 2 unix_timestamps: form and till
 *
 * @param string, int (unix_timestamp)
 * @return array
 */

function text2timeinterval ($input, $now = null) {
	if (!$now)
		$now = time ();
	
	switch ($input) {
		case "today":
			$output['from'] = mktime (0, 0, 0, date ('n', $now), date ('j', $now), date ('Y', $now));
			$output['till'] = mktime (23, 59, 59, date ('n', $now), date ('j', $now), date ('Y', $now));
			break;
		case "yesterday":
			$vcera = strtotime ('-1 day', $now);
			$output['from'] = mktime (0, 0, 0, date ('n', $vcera), date ('j', $vcera), date ('Y', $vcera));
			$output['till'] = mktime (23, 59, 59, date ('n', $vcera), date ('j', $vcera), date ('Y', $vcera));
			break;
		case "last7":
			$from = strtotime ('-6 day', $now);
			$output['from'] = mktime (0, 0, 0, date ('n', $from), date ('j', $from), date ('Y', $from));
			$output['till'] = mktime (23, 59, 59, date ('n', $now), date ('j', $now), date ('Y', $now));
			break;
		case "lastweek":
			$from = strtotime ('-1 week last monday', $now);
			$till = strtotime ('-1 week sunday', $now);
			$output['from'] = mktime (0, 0, 0, date ('n', $from), date ('j', $from), date ('Y', $from));
			$output['till'] = mktime (23, 59, 59, date ('n', $till), date ('j', $till), date ('Y', $till));
			break;
		case "month":
			$output['from'] = mktime (0, 0, 0, date ('n', $now), 1, date ('Y', $now));
			$output['till'] = mktime (23, 59, 59, date ('n', $now), date ('t', $now), date ('Y', $now));
			break;
		case "lastmonth":
			$from = strtotime ('-1 month', $now);
			//$till = strtotime ('-1 month', $now);
			$till = mktime (12, 0, 0, date ('n', $now)-1, 5, date ('Y', $now));
			$output['from'] = mktime (0, 0, 0, date ('n', $from), 1, date ('Y', $from));
			$output['till'] = mktime (23, 59, 59, date ('n', $till), date ('t', $till), date ('Y', $till));
			break;
		case "tomorrow":
			$zitra = strtotime ('+1 day', $now);
			$output['from'] = mktime (0, 0, 0, date ('n', $zitra), date ('j', $zitra), date ('Y', $zitra));
			$output['till'] = mktime (23, 59, 59, date ('n', $zitra), date ('j', $zitra), date ('Y', $zitra));
			break;
		case "nextmonth":
			$from = strtotime ('+1 month', $now);
			$till = strtotime ('+1 month', $now);
			$output['from'] = mktime (0, 0, 0, date ('n', $from), 1, date ('Y', $from));
			$output['till'] = mktime (23, 59, 59, date ('n', $till), date ('t', $till), date ('Y', $till));
			break;
		case "next7":
			$till = strtotime ('+6 day', $now);
			$output['from'] = mktime (0, 0, 0, date ('n', $now), date ('j', $now), date ('Y', $now));
			$output['till'] = mktime (23, 59, 59, date ('n', $till), date ('j', $till), date ('Y', $till));
			break;
		case "thisyear":
			$output['from'] = mktime (0, 0, 0, 1, 1, date ('Y', $now));
			$output['till'] = mktime (23, 59, 59, 12, 31, date ('Y', $now));
			break;
		case "lastyear":
			$output['from'] = mktime (0, 0, 0, 1, 1, date ('Y', $now) - 1);
			$output['till'] = mktime (23, 59, 59, 12, 31, date ('Y', $now) - 1);
			break;
		case "last6months":
			$from = strtotime ('-6 months', $now);
			$output['from'] = mktime (0, 0, 0, date ('n', $from), date ('j', $from), date ('Y', $from));
			$output['till'] = mktime (23, 59, 59, date ('n', $now), date ('j', $now), date ('Y', $now));
			break;
		case "last3months":
			$from = strtotime ('-3 months', $now);
			$output['from'] = mktime (0, 0, 0, date ('n', $from), date ('j', $from), date ('Y', $from));
			$output['till'] = mktime (23, 59, 59, date ('n', $now), date ('j', $now), date ('Y', $now));
			break;
		case "all":
		default :
		}

	return ($output);
	}
?>