<?php

/**
 * @author      http://roshanbh.com.np/2007/12/getting-real-ip-address-in-php.html
 * @return      string     Returns "real" IP address of visitor
 */
function getip() {
	# check ip from share internet
	if (!empty ($_SERVER['HTTP_CLIENT_IP']))
		$ip = $_SERVER['HTTP_CLIENT_IP'];
  # to check ip is pass from proxy
	elseif (!empty ($_SERVER['HTTP_X_FORWARDED_FOR']))
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  # regular ip
	else
		$ip = $_SERVER['REMOTE_ADDR'];
	
	return $ip;
	}
?>