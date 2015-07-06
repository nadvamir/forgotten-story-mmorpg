<?php
  // funkcija nachinaet krovotechenie u npc ili igroka
  function end_fire ($name)
  {
    //$name = preg_replace ('/[^a-z0-9_\.]/i', '', $name);

    $id = is_player ($name);
    if ($id)
    {
      $q = do_mysql ("SELECT status1 FROM players WHERE id_player = '".$id."';");
      $st = mysql_result ($q, 0);
      $st[4] = 0;
      do_mysql ("UPDATE players SET status1 = '".$st."' WHERE id_player = '".$id."';");
      return 1;
    }

    $id = is_npc($name);
    $q = do_mysql ("SELECT affected FROM npc WHERE id_npc = '".$id."';");
    $aff = mysql_result ($q, 0);
    if (!$aff) return 1;
    $aff = explode ('|', $aff);
    $c = count ($aff);
    for ($i = 0; $i < $c; $i++)
    {
      $aff[$i] = explode (':', $aff[$i]);
      //echo $aff[$i][0].' '.$aff[$i][1].' '.(time()).'<br/>';
      if ($aff[$i][0] == 'gorit')
        unset ($aff[$i]);
      if (isset ($aff[$i]))
        $aff[$i] = implode (':', $aff[$i]);
    }

    if (isset ($aff)) $aff = implode ('|', $aff);
    else $aff = '';
    if ($aff == '|') $aff = '';
    do_mysql ("UPDATE npc SET affected = '".$aff."' WHERE id_npc = '".$id."';");
    return 1;
  }
?>