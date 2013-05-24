<?php
# ěšččřžýáýů

# ...................................................................
# http://stackoverflow.com/questions/2768885/how-can-i-calculate-a-trend-line-in-php
function oneFromArray ($data, $key) {
	if (!is_array ($data) || !$key)
		return (null);
	
	foreach ($data as $k=>$value) {
		$output[$k] = $value[$key]; 
		}
	
	return ($output);
	}
?>