<?php
  // $name=login
  $id = is_player ($name);
  if ($id)
  {
    // esli igrok
    $q = do_mysql ("SELECT skills FROM players WHERE id_player = '".$id."';");
    $s = mysql_result ($q, 0);
    $s = explode ('|', $s);
    $s[1] -= 5; // dex -5
    $s = implode ('|', $s);
    do_mysql ("UPDATE players SET skills = '".$s."' WHERE id_player = '".$id."';");
  }
  else
  {
    // esli npc
    $id = is_npc ($name);
    do_mysql ("UPDATE npc SET dex = dex - 5 WHERE id_npc = '".$id."';");
  }
?>