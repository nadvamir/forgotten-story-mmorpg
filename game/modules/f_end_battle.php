<?php
  // funkcija zavershaet boj s ukazanym igrokom/npc
  function end_battle ($who)
  {
    $id = is_player ($who);
    if ($id)
    {
      do_mysql ("UPDATE players SET in_battle = '0' WHERE id_player = '".$id."';");
    }
    else
    {
      $id = is_npc ($who);
      do_mysql ("UPDATE npc SET in_battle = '0' WHERE id_npc = '".$id."';");
    }
    return 1;
  }
?>