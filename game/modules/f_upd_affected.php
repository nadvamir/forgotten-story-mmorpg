<?php
  // obnovitq i proveritq effekty
  function upd_affected ($name, $end = 0)
  {
    //$name = preg_replace ('/[^a-z0-9_\.]/i', '', $name);
    $id = is_player ($name);
    $n = 0;
    if ($id) $q = do_mysql ("SELECT affected FROM players WHERE id_player = '".$id."';");
    else
    {
      $id = is_npc($name);
      $n = 1;
      $q = do_mysql ("SELECT affected FROM npc WHERE id_npc = '".$id."';");
    }
    $aff = mysql_result ($q, 0);
    if (!$aff) return 1;
    $aff = explode ('|', $aff);
    $c = count ($aff);
    for ($i = 0; $i < $c; $i++) 
    {
      $aff[$i] = explode (':', $aff[$i]);
      //echo $aff[$i][0].' '.$aff[$i][1].' '.(time()).'<br/>';
      if ($aff[$i][1] <= time() || $end)
      {
        // dalee, esi estq takoj fail, spec izmenenija effekta ustanovim
        if (file_exists ('modules/effects/e_end_'.$aff[$i][0].'.php'))
          include 'modules/effects/e_end_'.$aff[$i][0].'.php';
        unset ($aff[$i]);
      }
      if (isset ($aff[$i]))
        $aff[$i] = implode (':', $aff[$i]);
    }
    $aff = implode ('|', $aff);
    if ($aff == '|') $aff = '';
    if (!$n) do_mysql ("UPDATE players SET affected = '".$aff."' WHERE id_player = '".$id."';");
    else do_mysql ("UPDATE npc SET affected = '".$aff."' WHERE id_npc = '".$id."';");
    return 1;
  }
?>