<?
# ěščřžýáíýž
class GpsCalc extends Modul {
	# SQL cast pro pouziti
	# (((acos(sin(('.$gps_lang.'*pi()/180)) * sin((kl.gps_lang*pi()/180))+cos(('.$gps_lang.'*pi()/180)) * cos((kl.gps_lang*pi()/180)) * cos((('.$gps_long.'- kl.gps_long)*pi()/180))))*180/pi())*60*1.1515*1.609344) AS distance
	# ____________________________________________


	# ...................................................................
	# KONSTRUKTOR třídy na práci s souřadnicemi a počítání vzdáleností
	function GpsCalc () {
		return (true);
		}

	# vrati vzdalenost (v metrech) mezi dvema body
	function distance ($Lat1, $Lon1, $Lat2, $Lon2, $units = "meters") {
		# 1. metoda
		//return (round (sqrt (pow (abs ($lang1 - $lang2),2) + pow (abs ($long1 - $long2),2))*91.9867*1000,0));

		# 2. metoda
		//$output = 3958.75 * acos(  sin($Lat1/57.2958) * sin($Lat2/57.2958) + cos($Lat1/57.2958) * cos($Lat2/57.2958) * cos($Lon2/57.2958 - $Lon1/57.2958)); 		 
		
		# 3. metoda
		$output = (sin(deg2rad($Lat1)) * sin(deg2rad($Lat2))) + (cos(deg2rad($Lat1)) * cos(deg2rad($Lat2)) * cos(deg2rad($Lon1 - $Lon2)));
		$output = acos($output);
		$output = rad2deg($output);
		$output = $output * 60 * 1.1515;
		
		switch ($units) { 
			default: 
			case "": 
			case "mile":
			case "miles": 
					$units = "Miles"; 
					$output = $output * 1; 
					break; 
			case "yards": 
					$units = "Yards"; 
					$output = $output * 1760; 
					break; 
			case "parsec": 
					$units = "Parsecs"; 
					$output = $output * 0.0000000000000521553443; 
					break; 
			case "nauticalmiles": 
					$units = "Nautical Miles"; 
					$output = $output * 0.868974087; 
					break; 
			case "nanometer": 
					$units = "Nanometers"; 
					$output = $output * 1609344000000; 
					break; 
			case "millimeter": 
					$units = "Millimeters"; 
					$output = $output * 1609344; 
					break; 
			case "mil": 
					$units = "Mils"; 
					$output = $output * 63360000; 
					break; 
			case "micrometer": 
					$units = "Micrometers"; 
					$output = $output * 1609344000; 
					break; 
			case "lightyear": 
					$units = "Light Years"; 
					$output = $output * 0.0000000000001701114356; 
					break; 
			case "kilometer": 
					$units = "Kilometers"; 
					$output = $output * 1.609344; 
					break; 
			case "inches": 
					$units = "Inches"; 
					$output = $output * 63360; 
					break; 
			case "hectometer": 
					$units = "Hectometers"; 
					$output = $output * 16.09344; 
					break; 
			case "furlong": 
					$units = "Furlongs"; 
					$output = $output * 8; 
					break; 
			case "feet": 
					$units = "Feet"; 
					$output = $output * 5280; 
					break; 
			case "dekameter": 
					$units = "Dekameters"; 
					$output = $output * 160.9344; 
					break; 
			case "centimeter": 
					$units = "Centimeters"; 
					$output = $output * 160934.4; 
					break; 
			case "meter": 
			case "meters":
			default:
					$units = "Meters"; 
					$output = $output * 1609.344; 
					break; 
			} 		 
		return ($output); 
		
		}

	# z 54.7322 vrati 54 43 55
	function convertDecDeg ($input, $what = 'all') {
		if (!$input || !is_numeric ($input) || $input > 180 || $input < 0)
			return (false);

		$output['input'] = $input;
		$output['deg'] = (int) $input;
		$output['minlong'] = round (60.0 * ($input - (int) $output['deg']),4);
		$output['min'] = (int) $output['minlong'];		
		$output['seclong'] = round (60.0 * ($output['minlong'] - $output['min']),2);
		$output['sec'] = (int) $output['seclong'];

		$output['htmldms'] = $output['deg'] . '&deg;&nbsp;' . $output['min'] . '\'&nbsp;' . strtr ((string) round ($output['seclong'],2),',','.') . '"';
		$output['htmldmm'] = $output['deg'] . '&deg;&nbsp;' . $output['minlong'] . '\'';
		
		$output['dms'] = $output['deg'] . '° ' . $output['min'] . '\' ' . strtr ((string) round ($output['seclong'],2),',','.') . '"';
		$output['dmm'] = $output['deg'] . '° ' . $output['minlong'] . '\'';

		if (in_array ($what, array ('input','deg','minlong','min','seclong','sec','htmldms','htmldmm', 'dms', 'dmm')))
			return ($output[$what]);
		else
			return ($output);
		}

	function geocodeGmaps ($address = null, $googlemaps_apikey = null, $type= 'csv', $countrycode = null) {
		if (!$address)
			return (null);
		if (!$googlemaps_apikey)
			return (false);
		if (!in_array ($type, array ('xml','csv')))
			return (false);

		$delay = 0;
		$base_url = 'http://maps.google.com/maps/geo?output='.$type.'&sensor=false&key='.$googlemaps_apikey. ($countrycode ? '&gl='.$countrycode : '');

		$geocode_pending = true;

		while ($geocode_pending) {
			$request_url = $base_url . "&q=" . urlencode($address);
			//exit ($request_url);
			switch ($type) {
				case 'xml':
					$xml = simplexml_load_file($request_url);
					
					list ($long,$lat)				=	explode (',', (string) $xml->Response->Placemark->Point->coordinates);

					$output['status']					= (string) $xml->Response->Status->code;
					$output['query']					= $address;
					$output['address']				= (string) $xml->Response->Placemark->address;					
					$output['gps_latitude']		= $lat;
					$output['gps_longitude']	= $long;
					$output['accuracy']				= (string) $xml->Response->Placemark->AddressDetails['Accuracy'];
					$output['latitude']				= GpsCalc::convertDecDeg ($lat, 'dms');
					$output['longitude']			= GpsCalc::convertDecDeg ($long, 'dms');
					$output['country']				= (string) $xml->Response->Placemark->AddressDetails->Country->CountryName;				
					$output['country_code']		= (string) $xml->Response->Placemark->AddressDetails->Country->CountryNameCode;
					$output['kraj']						= (string) $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->AdministrativeAreaName;
					if ((string) $xml->Response->Placemark->AddressDetails->Country->CountryNameCode == 'CZ' && $output['kraj'])
						$output['kraj'] = $output['kraj'] == 'Vysočina' ? 'kraj '.$output['kraj'] : $output['kraj'].' kraj';
					$output['psc']						= (string) $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->Locality->PostalCode->PostalCodeNumber;
					$output['city']						= (string) $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->Locality->LocalityName;
					$output['street']						= (string) $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->Locality->Thoroughfare->ThoroughfareName;
					$output['street_number']						= (string) $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->Locality->AddressLine;

					break;
				case 'csv':
				default :								
					$location = explode (',', file_get_contents ($request_url));
					if (!is_array ($location))
						return (false);

					$output['status']					= $location[0];
					$output['query']					= $address;
					$output['address']				= $address;
					$output['gps_latitude']		= $location[2];
					$output['gps_longitude']	= $location[3];
					$output['accuracy']				= $location[1];
					$output['latitude']				= GpsCalc::convertDecDeg ($location[2], 'dms');
					$output['longitude']			= GpsCalc::convertDecDeg ($location[3], 'dms');
				}
			 
			# successful geocode
			if (strcmp($output['status'], "200") === 0)
				return ($output);
			# sent geocodes too fast
			elseif (strcmp($output['status'], "620") === 0)
				$delay += 100000;
			# no API key
			elseif (strcmp($output['status'], "610") === 0)
				return (false);
			# failure to geocode (unknow addresss)
			else
				return (null);
				
			usleep($delay);
			}
		return (false);
		}
	
	}
?>