<?php

function langmonth($string, $format = 1, $lang="cs") {
	
	$mesice['cs'][1] = array (1=>'leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec');
	$mesice['cs'][2] = array (1=>'ledna', 'února', 'března', 'dubna', 'května', 'června', 'července', 'srpna', 'září', 'října', 'listopadu', 'prosince');
	$mesice['cs'][3] = array (1=>'Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec');
	$mesice['cs'][4] = array (1=>'Ledna', 'Února', 'Března', 'Dubna', 'Května', 'Června', 'Července', 'Srpna', 'Září', 'Října', 'Listopadu', 'Prosince');

	$mesice['de'][3] = array (1=>'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
	$mesice['de'][4] = $mesice['de'][3];
	$mesice['de'][1] = array (1=>'januar', 'februar', 'märz', 'april', 'mai', 'juni', 'juli', 'august', 'september', 'oktober', 'november', 'dezember');
	$mesice['de'][2] = $mesice['de'][1];

	$mesice['fr'][3] = array (1=>'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
	$mesice['fr'][4] = $mesice['fr'][3];
	$mesice['fr'][1] = array (1=>'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
	$mesice['fr'][2] = $mesice['fr'][1];

	$mesice['it'][3] = array (1=>'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');
	$mesice['it'][4] = $mesice['it'][3];
	$mesice['it'][1] = array (1=>'gennaio', 'febbraio', 'marzo', 'aprile', 'maggio', 'giugno', 'luglio', 'agosto', 'settembre', 'ottobre', 'novembre', 'dicembre');
	$mesice['it'][2] = $mesice['it'][1];

	$mesice['es'][3] = array (1=>'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$mesice['es'][4] = $mesice['es'][3];
	$mesice['es'][1] = array (1=>'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
	$mesice['es'][2] = $mesice['es'][1];

	$mesice['pl'][3] = array (1=>'Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień');
	$mesice['pl'][4] = $mesice['pl'][3];
	$mesice['pl'][1] = array (1=>'styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec', 'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień');
	$mesice['pl'][2] = $mesice['pl'][1];

	$mesice['ru'][3] = array (1=>'Январь', 'Февраль', 'Марш', 'Апрель', 'МАЯ', 'Июнь', 'Июнь', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
	$mesice['ru'][4] = $mesice['ru'][3];
	$mesice['ru'][1] = array (1=>'январь', 'февраль', 'марш', 'апрель', 'мая', 'июнь', 'июнь', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
	$mesice['ru'][2] = $mesice['ru'][1];


	$firstupper = $firstupper ? 2 : 0;

	$mesice = $mesice[$lang][$format+$firstupper];

	if (0 < (int) $string && (int) $string < 13)
		return $mesice[(int) $string];
	elseif($string != '')
		return $mesice[date('n', $string)];
	elseif (isset($default_date) && $default_date != '')
		return $mesice[date('n', $default_date)];
	else
		return;
	}

function date_lang ($format='F', $timestamp, $lang='0') {
	$save_lang = setlocale (LC_TIME, 0);
  setlocale (LC_TIME, $lang.'.UTF8', $lang.'.UTF-8', $lang);
	$output = date ($format, $timestamp);
	setlocale (LC_TIME, $save_lang);
	return ($output);
	}

?>
