<?php

/**
 * string utf2ascii (string)
 * 
 * Version: 1
 * Purpose:  Convert utf-8 string to ascii string (no diacritics).
 * Note: Only for Latin-1 and Czech (common) chars.
 *
 * @param string
 * @return string
 */

function utf2ascii ($string) {
	$string=iconv('utf-8','windows-1250',$string);
	$win = "μθψύανιςοϊωσφόδΜΘΨέΑΝΙÒΟΪΩΣΦάΛΔ\x97\x96\x91\x92\x84\x93\x94\xAB\xBB";
	$ascii="escrzyaietnduuoouaESCRZYAIETNDUUOOUEAOUEA\x2D\x2D\x27\x27\x22\x22\x22\x22\x22";
	$string = StrTr($string,$win,$ascii);
	return $string;
	}
?>