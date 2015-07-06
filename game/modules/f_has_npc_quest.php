<?php
  // funkcija, proverjajushija, estq liu npc kvest
  function has_npc_quest ($npc)
  {
     $id = is_npc ($npc);
     $q = do_mysql ("SELECT quest FROM npc WHERE id_npc = '".$id."';");
     $quest = mysql_result ($q, 0);
     if ($quest) return 1;
     else return 0;
  }
?>