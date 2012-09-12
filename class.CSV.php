<?
class CSV {
var $cache; # cache soubor
var $DEF = array (); # nastaveni
var $ERROR = array (); # chybove hlasky
var $TYPE = array (); # mozne typy

# ...................................................................
# KONSTRUKTOR
function CSV ($filename = null) {
	$this->cache = array ();

	$this->DEF['filename'] = $filename;
	$this->DEF['sortcolumn'] = 0;
	$this->DEF['sortway'] = true;
	$this->DEF['sort'] = true;

	$this->TYPE = array ('text', 'yearmonth', 'year', 'datetime', 'date', 'timestamp', 'num', 'int');

	return (true);
	}

# ...................................................................
# nastaveni promenych
function setting ($option = null) {
	if (is_array ($option))
		foreach ($option as $key=>$value)
			$this->DEF[$key] = $value;

	return (true);
	}

# ...................................................................
# vrati promene nastaveni
function getSetting ($option = null) {
	if ($option)
		return ($this->DEF[$option]);
	else
		return ($this->DEF);
	}

# ...................................................................
# vrati vse
function get () {
	# kdyz nemam nacteno, nactu
	if (!$this->cace['loadtime']) {
		//$this->_loadTextFile ();

		# nacteni z csv
		$this->cache['data'] = $this->_getcsvxls ($this->DEF['filename']);
		$this->cache['loadtime'] = time ();
		$this->cache['rows'] = count ($text);
		$this->cache['def'] = $this->DEF;
		
		# setrideni
		if ($this->DEF['sort'])
			$this->cache['data'] = $this->sortcsv ();
		}

	return ($this->cache);
	}

# ...................................................................
# vrati pouze cista data
function getData () {
	# kdyz nemam nacteno, nactu
	if (!$this->cace['loadtime'])
		$this->get ();

	return ($this->cache['data']);
	}


# ...................................................................
# setridim podle datumu zadani (1. prvni pole) sestupne
function sortcsv ($data = null) {
	if (!is_array ($data))
		$data = $this->cache['data'];

	if (is_array ($data)) {
		switch($this->cache['sorttype'][$this->DEF['sortcolumn']]) {
			case 'TEXT':
				$code .= 'strcasecmp ($b["' . $this->DEF['sortcolumn'] . '"], $a["' . $this->DEF['sortcolumn'] . '"])';
        break;
			case 'YEAR':
				$code .= '(strtotime ($a["' . $this->DEF['sortcolumn'] . '"] . "-01-01") - strtotime ($b["' . $this->DEF['sortcolumn'] . '"] . "-01-01"))';
        break;
			case 'YEARMONTH':
				$code .= '(strtotime ($a["' . $this->DEF['sortcolumn'] . '"] . "-01") - strtotime ($b["' . $this->DEF['sortcolumn'] . '"] . "-01"))';
        break;
			case 'DATE':
			case 'DATETIME':
				$code .= '(strtotime ($a["' . $this->DEF['sortcolumn'] . '"]) - strtotime ($b["' . $this->DEF['sortcolumn'] . '"]))';
        break;
			case 'INT':
			case 'NUM':
			case 'TIMESTAMP':
			default:
				$code .= '($a["' . $this->DEF['sortcolumn'] . '"] - $b["' . $this->DEF['sortcolumn'] . '"])';
			}
		# podle toho jestli ASC nebo DESC doupravim
		if ($this->DEF['sortway'] == 'DSC' || $this->DEF['sortway'] == 'DESC' || (int) $this->DEF['sortway'] < 0 || !$this->DEF['sortway'])
			$code = '-1*' . $code;

		$compare = create_function('$a, $b', 'return (' . $code . ');');
		}

	usort ($data, $compare);
	
	return ($data);
	}

# ...................................................................
# funkce pro nacteni csv souboru
function _getcsvxls($filename) {
	$source = @file ($filename);
	if (is_array ($source)) {
		$source_title = $source[0];
		unset ($source[0]);
		$buffer = implode ("", $source);
		}
	
	# nacteni a zpracovani title
	$titles = array ();
	$titles = explode (';', $source_title);
	foreach ($titles as $index=>$title) {	
		foreach ($this->TYPE as $type) {	
			unset ($pozice);
			$pozice = strpos (strtoupper ($title), strtoupper ($type));

			if ($pozice !== false) {
				$this->cache['title'][$index] = trim (substr ($title, $pozice + strlen ($type) + 1));
				$this->cache['sorttype'][$index] = strtoupper ($type);
				break;
				}
			}
		# default type
		if ($pozice === false)
			$this->cache['sorttype'][$index] = $this->TYPE[0];
		# default title
		if ((!$this->cache['title'][$index] || trim ($this->cache['title'][$index]) == '' || trim ($this->cache['title'][$index]) == " ") && $title)
			$this->cache['title'][$index] = trim ($title);
		}


	$buffer = str_replace('""', '"', $buffer);
	$n = strlen($buffer);
	$i = $line = 0;
	$del = false;
	while($i < $n) {
		$part = substr($buffer, $i);
		if((substr($part, 0, 1) == ';' && !$del) || (substr($part, 0, 2) == '";' && $del)) {
			$i ++;
			if($del) {
				$str = substr($str, 1, strlen($str) - 1);
				$i ++;
				}
			$data[$line][] = $str;
			$del = false;
			$str = '';
			}
		else if(substr($part, 0, 2) == "\r\n") {
			$data[$line][] = $str;
			$str = '';
			$del = false;
			$line ++;
			$i += 2;
			}
		else {
			if($part[0] == '"')
				$del = true;
			$str .= $part[0];
			$i ++;
			}
		}
	return $data;
	}

# ...................................................................
# funkce pro ulozeni csv souboru
function _fputcsvxls ($filePointer,$dataArray,$delimiter=';',$enclosure='"') {
	// Write a line to a file
	// $filePointer = the file resource to write to
	// $dataArray = the data to write out
	// $delimeter = the field separator

	// Build the string
	$string = "";

	// No leading delimiter
	$writeDelimiter = FALSE;
	foreach($dataArray as $dataElement) {
		$dataElement = stripslashes ($dataElement);

		// Replaces a double quote with two double quotes
		$dataElement = ereg_replace ("\"", "\"\"", $dataElement);

		// Replace enters to <br />
		$dataElement = preg_replace("(\r\n)", '<br />', $dataElement);

		// Adds a delimiter before each field (except the first)
		if($writeDelimiter) $string .= $delimiter;

		// Encloses each field with $enclosure and adds it to the string
		if (strpos ($dataElement, $enclosure) || strpos ($dataElement, $delimiter))
		$string .= $enclosure . $dataElement . $enclosure;
		else
		$string .= $dataElement;

		// Delimiters are used every time except the first.
		$writeDelimiter = TRUE;
		} // end foreach($dataArray as $dataElement)

	// Append new line
	$string .= "\r\n";

	// Write the string to the file
	fwrite($filePointer,$string);
	}
	
} # end of class
?>