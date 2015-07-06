<?php
  // funkcija poluchenija harakteristik npc
  function get_npc_battle_har ($npc)
  {
    //$npc = preg_replace ('/[^a-z\._0-9]/i', '', $npc);
    $id = is_npc ($npc);
    $q = do_mysql ("SELECT chanse FROM npc WHERE id_npc = '".$id."';");
    if (!mysql_num_rows($q))
      include ('modules/s_main.php');
    $c = mysql_result ($q, 0);
    $c = explode ('~', $c);
    include_once ('modules/f_get_affected.php');
    $aff = get_affected ($npc);
    if (is_in ('osleplen', $aff))
    {
      for ($i = 0; $i < 10; $i++) $с[$i] = round ($с[$i] / 2);
    }
    return $c;
  }
?>