<?php
  // funkcija kotoraja vozvrashjaet dannye npc
  //$what eto chto nado vzjatq
  function get_npc_info ($npc, $what)
  {
    //$npc = preg_replace ('/[^a-z\._0-9]/i', '', $npc);
    //$what = preg_replace ('/[^a-z]/i', '', $what);
    // sbnachalo proverim chto za what
    // what == 'name' - imja
    // $what == 'all' - vse, razdroblenno otdatq
    // $what == 'location' - lokaciju
    // $what == 'is_alive' - zhiv li
    // $what == 'life' - zhiznq
    $id = is_npc ($npc);
    if ($what == 'name')
    {
      $alo = do_mysql("SELECT name FROM npc WHERE id_npc = '".$id."';");
      $name = mysql_result ($alo, 0);
      return $name;
    }
    if ($what == 'all')
    {
      $q = do_mysql ("SELECT * FROM npc WHERE id_npc = '".$id."';");
      $all = mysql_fetch_assoc ($q);
      $all['life'] = explode ('|', $all['life']);
      return $all;
    }
    if ($what == 'location')
    {
      $alo = do_mysql("SELECT location FROM npc WHERE id_npc = '".$id."';");
      $loc = mysql_result ($alo, 0);
      return $loc;
    }
    if ($what == 'is_alive')
    {
      $q = do_mysql ("SELECT life FROM npc WHERE id_npc = '".$id."';");
      $al = mysql_result ($q, 0);
      if (substr ($al, 0, 1) == 0) return 0;
      else return 1;
    }
    if ($what == 'life')
    {
      $q = do_mysql ("SELECT life FROM npc WHERE id_npc = '".$id."';");
      $al = mysql_result ($q, 0);
      return $al;
    }
  }
?>