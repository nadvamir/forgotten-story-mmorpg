<?php
  // blokirovatq udar (napisatq ob etom)
  function uklon ($to)
  {
    $id = is_player ($to);
    if ($id)
    {
      $q = do_mysql ("SELECT name, location FROM players WHERE id_player = '".$id."';");
      $p = mysql_fetch_assoc ($q);
      add_journal ($p['name'].' уклонился!', 'l.'.$p['location']);
    }
    else
    {
      $id = is_npc ($to);
      $q = do_mysql ("SELECT name, location FROM npc WHERE id_npc = '".$id."';");
      $n = mysql_fetch_assoc ($q);
      add_journal ($n['name'].' уклонился!', 'l.'.$n['location']);
    }
    return 1;
  }
?>