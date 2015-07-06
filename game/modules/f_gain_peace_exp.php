<?php
  // funkcija s neba daet opyt, ukazanyj
  function gain_peace_exp ($exp, $login)
  {
    $exp = preg_replace('/[^0-9]/', '', $exp);
    //$login = preg_replace ('/[^a-z0-9_]/', '', $login);
    $id = is_player ($login);
    $q = do_mysql ("SELECT stats FROM players WHERE id_player = '".$id."';");
    $stats = mysql_result ($q, 0);
    $stats = explode ('|', $stats);

    $stats[1] += $exp;
    $stats[4] += $exp;
    $nstats = $stats[0].'|'.$stats[1].'|'.$stats[2].'|'.$stats[3].'|'.$stats[4].'|'.$stats[5].'|'.$stats[6].'|'.$stats[7];
    include_once ('modules/f_check_pl_exp.php');
    do_mysql ("UPDATE players SET stats = '".$nstats."' WHERE id_player = '".$id."';");
    add_journal ('exp +'.$exp, $login);
    check_pl_exp ($login);
    return 1;
  }
?>