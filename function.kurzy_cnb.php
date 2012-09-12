<?php
# ěšččřžýáýů

# vrati pole s aktualnimi kurzy.
function kurzy_cnb ($cacheFile = '../cache/kurzy_cnb.txt') {
	static $data;
  $cacheDuration = 3600; # 1 hodina

  clearstatcache(); # smazat vyrovnávací pamět s informacemi o souborech

  if(file_exists($cacheFile) && ((time() - filemtime($cacheFile)) < $cacheDuration)) { 
		# soubor s cache existuje a je ještě platný
    $data = file_get_contents($cacheFile);
		if ($data)
			$data = unserialize ($data);
    # pokud se podařilo soubor přečíst a neni v něm blbost, vratim
    if (is_array ($data))
			return ($data);
		}

	# je třeba načíst stav z webu
	$data = kurzy_cnb_get (); # načti stav


	# ulož stav do cache
	if (is_array ($data)) {		
		$fp = @fopen($cacheFile, 'w');
		@fwrite($fp, serialize ($data));
		@fclose($fp);
		}
	elseif (file_exists($cacheFile)) {
		$data = file_get_contents($cacheFile);
		if ($data)
			$data = unserialize ($data);
		else
			$data = null;
		}
	
	return $data;
}	

function kurzy_cnb_get () {
	$fp = @fopen ('http://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt', 'r');
	if ($fp) {
		while (!feof ($fp)) {
			$radka = fgets ($fp);
			if (preg_match ('#([a-ž ]+)\|([a-ž ]+)\|([0-9]+)\|([a-ž]{3})\|([0-9,]+)#i', $radka, $kurz_data)) {
				$kurzy[strtolower ($kurz_data[4])]['zeme'] = $kurz_data[1];
				$kurzy[strtolower ($kurz_data[4])]['mena'] = $kurz_data[2];
				$kurzy[strtolower ($kurz_data[4])]['mnozstvi'] = $kurz_data[3];
				$kurzy[strtolower ($kurz_data[4])]['kod'] = $kurz_data[4];
				$kurzy[strtolower ($kurz_data[4])]['kurz'] = (float) strtr ($kurz_data[5], ',', '.');
				}
			}
		fclose ($fp);
		}
	return ($kurzy);
	}
?>