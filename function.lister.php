<?
# ...................................................................
# array lister ( int items_on_page, int total_items, int this_item )
# zpracovani LISTERu - takove to PREV ... 1 2 3 4 ... NEXT
# VYSTUP pole: [previous] = true/false, [next] = true/false, [active_page] = int, [pages] = array (int)
# vrati vysledek jen pokud ma byt zobrazeno vice jak jedna stranka (jinak nema smysl)
function lister ($onpage = 20, $total = 0, $startfrom = 0, $page_startfrom = true) {
	if (!$total || $total == 0)
		return (false);
	# zjisteni  poctu stranek potrebnych k zobrazeni vsech odkazu (poctu skupin) - zacina od 1
	$total_pages = ceil( $total / $onpage ); 

	# zjisteni aktualni skupiny (zacina 1, 2, 3, ...)
	if ($page_startfrom && $startfrom > 0)
		$this_page = $startfrom;
	else
		$this_page = floor( $startfrom / $onpage ) + 1;

	# ulozeni previous
	if ($this_page > 1)
		$output['previous'] = $this_page - 1;
	# ulozeni next
	if ($total_pages > $this_page)
		$output['next'] = $this_page + 1;
	# ulozeni aktivni stranky
	$output['active_page'] = $this_page;
	# ulozeni first
	if ($this_page != 1)
		$output['first'] = 1;
	# ulozeni last
	if ($total_pages != $this_page)
		$output['last'] = $total_pages;
	# ulozeni total pages a total items
	$output['total_pages'] = $total_pages;
	$output['total_items'] = $total;
	$output['onpage'] = $onpage;
	$output['startfrom'] = $startfrom;
	
	# ulozeni pole se strankamy
	# do budoucna predelat (pridat ... moznost)
	for	($i = 1; $i <= $total_pages; $i++)
		$output['pages'][] = $i;
	
	if ($total_pages > 1)
		return ($output);
	}
?>
