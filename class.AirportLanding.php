<?
# ěščřžýáíů

class AirportLanding {
	var $cache;

	var $cachefile = '/../cache/airport-landings.txt'; # link from this class
		
	# ...................................................................
	# KONSTRUKTOR
	function AirportLanding () {
		$this->cachefile = dirname(__FILE__).$this->cachefile;

		return (true);
		}

	# ...................................................................
	function get ($flightnumber = null) {
		# nacitam z cache
		$data = $this->load ();
		
		$fnsant = $this->sanitizeFlightnumber ($flightnumber);

		if ($fnsant)
			return ($data['landings'][$fnsant]);
		else
			return ($data);
		}	

	# ...................................................................
	function enhanceData ($data=null, $arkey = 'flightnumber') {		
		if (!is_array ($data))
			return (null);

		$flights = $this->load ();
		if (is_array ($flights['landings'])) {
			foreach ($data as $key=>$value) {
				$fnsant = $this->sanitizeFlightnumber ($value[$arkey]);
				if ($flights['landings'][$fnsant]) {
				//print_r ($flights['landings'][$fnsant]);echo ('1');
					$data[$key][$arkey.'_details'] = $flights['landings'][$fnsant];
					}
				}
			}
		
		return ($data);
		}

	# ...................................................................
	function sanitizeFlightnumber ($flightnumber='') { 
		if ($flightnumber && preg_match ('/([0-9]{2} [0-9]{3,4})/i', $flightnumber, $matches))
			return (strtoupper ($matches[1]));
		elseif ($flightnumber && preg_match ('/([a-z]{2,3}|[a-z][0-9]) *([0-9]{3,4})/i', $flightnumber, $matches))
			return (strtoupper ($matches[1]).' '.$matches[2]);
		else
			return (null);		
		}
	
	# ...................................................................
	function checkExpiration ($expiration=300) { /* default 5 mins in seconds */
		$time = filemtime ($this->cachefile);
		if ($time && $time>=time ()-$expiration)
			return (true);
		else
			return (false);
		}
	
	# ...................................................................
	function load ($force = false) {
		if ($force || !$this->checkExpiration () || !$this->loadCache () || !is_array ($this->cachedata))
			$this->loadData ();
		if (!$this->cachedata)
			$this->loadCache ();
		return ($this->cachedata);
		}
	
	# ...................................................................
	function loadData () {
		require_once(dirname(__FILE__).'/../lib/simplehtmldom/simple_html_dom.php');

		# prepare request
		$fields = array(
			'hour' => 'all',
			'destination' => '0',
			'carrier' => '0',
			'act' => urlencode('main->param->param->param->setFiltr')
			);
		foreach($fields as $key=>$value) 
			$fields_string .= $key.'='.$value.'&';
		rtrim($fields_string, '&');

		# request html page
		$ch = curl_init('http://m.prg.aero/cs/informace-o-letech/prilety-a-odlety/prilety/');
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);

		if (!$output)
			return (null);

		# parse page and elements
		$html = str_get_html ($output);

		$data['datetime'] = $html->find('form.customFormStretch',0)->first_child()->plaintext;
		$data['timestamp'] = parseDate (substr ($data['datetime'], strpos ($data['datetime'],':')+1));

		foreach ($html->find ('table.letistepraha_cms_ui_content_departurearrival_arrival tbody tr') as $row) {
			unset ($datarow);
			$cells = $row->find ('td div');
			$datarow['plan'] = $cells[0]->plaintext;
			$datarow['plan_ts'] = parseDate ($datarow['plan']);
			$datarow['flight'] = $cells[1]->plaintext;
			$datarow['from'] = $cells[2]->plaintext;
			$datarow['terminal'] = $cells[3]->plaintext;
			$datarow['status'] = trim ($cells[4]->plaintext);
			if (is_object ($cells[4]))
				$datarow['landing'] = $cells[4]->find('strong',0)->plaintext;
				
			if ($datarow['landing']) {
				$datarow['landing_ts'] = parseDate (preg_replace ('/[0-9]{2}:[0-9]{2}/', $datarow['landing'], $datarow['plan'], 1));
				$datarow['status'] = trim (str_replace ($datarow['landing'], '', $datarow['status']));				
				}
			
			switch ($datarow['status']) {
				case 'Přistálo':
					$datarow['status_code'] = 3;
					break;
				case 'Zpožděno':
					$datarow['status_code'] = 2;
					break;
				case 'Předpoklad':
					$datarow['status_code'] = 1;
					break;
				case 'Zrušeno':
					$datarow['status_code'] = 5;
					break;
				default :
					$datarow['status_code'] = 0;
				}

			if ($datarow['flight'] && $this->sanitizeFlightnumber ($datarow['flight']) && !$data['landings'][$datarow['flight']])
				$data['landings'][$datarow['flight']] = $datarow;
			}

		# save to cache
		$this->cachedata = $data;

		# save to file
		file_put_contents ($this->cachefile, serialize ($this->cachedata));
		return ($data);
		}

	# ...................................................................
	function loadCache () {
		if (is_array ($this->cachedata))
			return (true);
		
		$data = unserialize (file_get_contents ($this->cachefile));
		if (is_array ($data)) {
			$this->cachedata = $data;
			return (true);
			}
		else {
			$this->cachedata = null;
			return (false);
			}
		}

	}

?>