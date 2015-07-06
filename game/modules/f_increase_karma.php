<?php
  // funkcija uvelichivaet karmu:
  function increase_karma ($login, $plus)
  {
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);
    $plus = preg_replace ('/[^0-9]/', '', $plus);
    $id = is_player ($login);
    $q = do_mysql ("SELECT karma FROM players WHERE id_player = '".$id."';");
    $karma = mysql_result ($q, 0);
    $karma += $plus;
    do_mysql ("UPDATE players SET karma = '".$karma."' WHERE id_player = '".$id."';");
    add_journal ('карма +'.$plus, $login);
    return 1;
  }
?>