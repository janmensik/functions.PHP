<?php

/**
 * Ovìøení rodného èísla
 *
 * @author      http://www.dgx.cz/trine/item/jak-overit-platne-ic-a-rodne-cislo
 * @param       string   $rc    Rodne cislo
 * @return      bool     Returns true on success, false on failure
 */
function verifyRC($rc)
{
    // "be liberal in what you receive"
    if (!preg_match('#^\s*(\d\d)(\d\d)(\d\d)[ /]*(\d\d\d)(\d?)\s*$#', $rc, $matches)) {
        return FALSE;
    }

    list(, $year, $month, $day, $ext, $c) = $matches;

    // do roku 1954 pøidìlovaná devítimístná RÈ nelze ovìøit
    if ($c === '') {
        return $year < 54;
    }

    // kontrolní èíslice
    $mod = ($year . $month . $day . $ext) % 11;
    if ($mod === 10) $mod = 0;
    if ($mod !== (int) $c) {
        return FALSE;
    }

    // kontrola data
    if ($month > 50) $month -= 50;
    $year += $year < 54 ? 200 : 1900;

    if (!checkdate($month, $day, $year)) {
        return FALSE;
    }

    // cislo je OK
    return TRUE;
}
?>