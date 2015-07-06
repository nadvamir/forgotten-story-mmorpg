<?php
  // funkcija uvelichivaet karmu:
  function decrease_karma ($login, $minus)
  {
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);
    $minus = preg_replace ('/[^0-9]/', '', $minus);
    $id = is_player ($login);
    if (!$id) return 0;
    $q = do_mysql ("SELECT karma FROM players WHERE id_player = '".$id."';");
    $karma = mysql_result ($q, 0);
    $karma -= $minus;
    do_mysql ("UPDATE players SET karma = '".$karma."' WHERE id_player = '".$id."';");
    add_journal ('карма -'.$minus, $login);
    return 1;
  }
?>