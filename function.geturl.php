<?
# ...................................................................
function geturl ($forparams = true) {
	if($_SERVER['HTTPS'])
		$my_url = 'https://';
	else
		$my_url = 'http://';

	$my_url .= $_SERVER['HTTP_HOST'];

	if($forparams && !$_SERVER['QUERY_STRING'])
		$my_url .= $_SERVER['REQUEST_URI'] . '?';
	else
		$my_url .= $_SERVER['REQUEST_URI'];
	
	if($_SERVER['QUERY_STRING'] != null)  
			$my_url .= '?' . $_SERVER['QUERY_STRING'];
	
	/*
	$my_url .= $_SERVER["REDIRECT_URL"] ? $_SERVER["REDIRECT_URL"] : $_SERVER['SCRIPT_NAME'];

	if($_SERVER['QUERY_STRING'] != null)  
			$my_url .= '?' . $_SERVER['QUERY_STRING'];
	*/

	return $my_url;
	}
?>
