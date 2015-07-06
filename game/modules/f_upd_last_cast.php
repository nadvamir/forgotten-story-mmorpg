<?php
  // funkcija onnovlenija vremeni poslednej ataki (uchityvaetsja dlja normalqnoj ataki i kombo, ne dlja otvetki)
  function upd_last_cast ($pl, $spell)
  {
    //$pl = preg_replace ('/[^a-z0-9_]/i', '', $pl);
    //$spell = preg_replace ('/[^a-z0-9_]/i', '', $spell);
    $now = time();
    $id = is_player ($pl);
    if (!$id)
      put_error ('npc cant cast spell');

    $q = do_mysql ("SELECT last FROM players WHERE id_player = '".$id."';");
    $last = mysql_result ($q, 0);
    $last = explode ('|', $last);

    // vremja zaklinanija:
    $q = do_mysql ("SELECT timewait FROM magic WHERE fullname = '".$spell."';");
    if (!mysql_num_rows ($q)) put_error ('there are no such spell: '.$spell.'');
    $tw = mysql_result ($q, 0);

    $last[3] = $now + $tw;

    // obrabotka effektami:
    #include_once ('modules/f_get_affected.php');
    // effecty:
    #$aff = get_affected ($LOGIN);
    // primer: if (is_in ('oglushen', $aff)) $last[3] += 10;

    $nlast = $last[0].'|'.$last[1].'|'.$last[2].'|'.$last[3].'|'.$last[4].'|'.$last[5].'|'.$last[6].'|'.$last[7].'|'.$last[8];
    do_mysql ("UPDATE players SET last = '".$nlast."' WHERE id_player = '".$id."';");
    return 1;
  }
?>