<?php
  // funkcija onnovlenija vremeni poslednej ataki (uchityvaetsja dlja normalqnoj ataki i kombo, ne dlja otvetki)
  function upd_last_attack ($pl)
  {
    //$pl = preg_replace ('/[^a-z0-9_\.]/i', '', $pl);
    $now = time();
    $id = is_player ($pl);
    if (!$id)
    {
      $id = is_npc ($pl);
      // npc
      do_mysql ("UPDATE npc SET lastattack = '".$now."' WHERE id_npc = '".$id."';");
      return 1;
    }
    $q = do_mysql ("SELECT last FROM players WHERE id_player = '".$id."';");
    $last = mysql_result ($q, 0);
    $last = explode ('|', $last);
    $last[1] = $now;
    $nlast = $last[0].'|'.$last[1].'|'.$last[2].'|'.$last[3].'|'.$last[4].'|'.$last[5].'|'.$last[6].'|'.$last[7].'|'.$last[8];
    do_mysql ("UPDATE players SET last = '".$nlast."' WHERE id_player = '".$id."';");
    return 1;
  }
?>