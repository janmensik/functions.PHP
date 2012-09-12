<?php

# vytvori nahodne heslo o delce $length
	function createpassword ($length = 5, $konstatna = 'tajna konstanta') {
		return (substr (md5(time () . $konstatna), 0, $length));
		}
?>