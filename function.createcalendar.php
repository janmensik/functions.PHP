<?php
# ...................................................................
function createCalendar ($month = null, $year = null, $fill = false, $return_format = 'ts-noon') {
	$month = (int) $month >= 1 && (int) $month <= 12 ? (int) $month : date ('n');
	$year = (int) $year >= 1970 && (int) $year <= 2038 ? (int) $year : date ('Y');

	$startdate = mktime (12, 0, 0, $month, 1, $year);
	$enddate = mktime (12, 0, 0, $month, date ('t', $startdate), $year);

	$tyden = 0;
	$denvtydnu = 1; # 1-7 = po-ne
	$startday = date("w", $startdate);
	if ($startday == 0)
		$startday = 7;

	# dopisu dny na zacatku
	for ($i = 1; $i < $startday; $i++, $denvtydnu++)
		$output[$tyden][$i] = $fill ? strtotime ('-' . ($startday-$i) . ' days', $startdate) : false;
	# zapisuji
	for ($den=$startdate; $den <= $enddate; $den = strtotime ('+1 day', $den)) {
		if ($denvtydnu == 8) {
			$tyden++;
			$denvtydnu = 1;
			}
		$output[$tyden][$denvtydnu] = $den;
		$denvtydnu++;
		}
	# dopisu dny na konci
	if ($denvtydnu <= 7)
		for ($i = $denvtydnu; $i < 8; $i++, $denvtydnu++)
			$output[$tyden][$i] = $fill ? strtotime ('+' . ($i-1) . ' days', $enddate) : false;

	//print_r ($output);

	switch ($return_format) {
		case 'day':
			foreach ($output as $tyden_k=>$tyden_v)
				foreach ($tyden_v as $den_k=>$den_v)
					$output[$tyden_k][$den_k] = date ('j', $den_v);
			break;
		case 'ts-noon':
		default :
		}

	return ($output);
	}
?>