<?php
/** Kontrola e-mailové adresy
* @param string e-mailová adresa
* @return bool syntaktická správnost adresy
* @copyright Jakub Vrána, http://php.vrana.cz/
*/

function check_email($email) {
  $atom = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
  $domain = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
  return preg_match(":^$atom+(\\.$atom+)*@($domain?\\.)+$domain\$:i", $email);
}

/*
function check_email($email) {
	// preg pattern for user name
	// http://tools.ietf.org/html/rfc2822#section-3.2.4
	$atext = "[a-z0-9\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~]";
	$atom = "$atext+(\.$atext+)*";

	// preg pattern for domain
	// http://tools.ietf.org/html/rfc1034#section-3.5
	$dtext = "[a-z0-9]";
	$dpart = "$dtext+(-$dtext+)*";
	$domain = "$dpart+(\.$dpart+)+";

	if(preg_match("/^$atom@$domain$/i", $addres)) {
		list($username, $host)=split('@', $addres);
		if(checkdnsrr($host,'MX')) {
			return TRUE;
			}
		}
	return FALSE;
	}
*/
?>