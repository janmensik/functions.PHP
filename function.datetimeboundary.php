<?php
# ěšččřžýáýů

# ...................................................................
# podle levelu a data vratim skutecny pocatek ci konec
# napr.: level day, start, input (v ts) "2012-01-01 14:57", output (v ts) "2012-01-01 00:00"
# napr.: level month, end, input (v ts) "2012-01-01 14:57", output (v ts) "2012-01-31 23:59"
# PODPORUJI: hour, day, month, year
function datetimeboundary ($level = "day",$ts=1, $end=false) {
	if ($ts==1 || (int) $ts<1)
		$ts = time ();
	
	switch ($level) {
		case "hour":
			return (mktime (date('H', $ts), ($end?59:0), ($end?59:0), date ('n', $ts), date ('j', $ts), date ('Y', $ts)));
		
		case "day":		
			return (mktime (($end?23:0), ($end?59:0), ($end?59:0), date ('n', $ts), date ('j', $ts), date ('Y', $ts)));
		
		case "month":		
			return (mktime (($end?23:0), ($end?59:0), ($end?59:0), date ('n', $ts), ($end?date ('t', $ts):1), date ('Y', $ts)));
		
		case "year":		
			return (mktime (($end?23:0), ($end?59:0), ($end?59:0), ($end?12:1), ($end?31:1), date ('Y', $ts)));
		}
	}
?>