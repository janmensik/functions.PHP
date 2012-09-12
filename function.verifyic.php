<?php

/**
 * Ovìøení IÈ firmy
 *
 * @author      http://www.dgx.cz/trine/item/jak-overit-platne-ic-a-rodne-cislo
 * @param       string   $ic    IC firmy
 * @return      bool     Returns true on success, false on failure
 */
function verifyIC($ic)
{
    // "be liberal in what you receive"
    $ic = preg_replace('#\s+#', '', $ic);

    // má požadovaný tvar?
    if (!preg_match('#^\d{8}$#', $ic)) {
        return FALSE;
    }

    // kontrolní souèet
    $a = 0;
    for ($i = 0; $i < 7; $i++) {
        $a += $ic[$i] * (8 - $i);
    }

    $a = $a % 11;

    if ($a === 0) $c = 1;
    elseif ($a === 10) $c = 1;
    elseif ($a === 1) $c = 0;
    else $c = 11 - $a;

    return (int) $ic[7] === $c;
}
?>