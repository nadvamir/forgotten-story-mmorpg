<?php
  // funkcija nachinaet krovotechenie u npc ili igroka
  function start_blood ($name)
  {
    //$name = preg_replace ('/[^a-z0-9_\.]/i', '', $name);

    $id = is_player ($name);
    if ($id)
    {
      $q = do_mysql ("SELECT status1 FROM players WHERE id_player = '".$id."';");
      $st = mysql_result ($q, 0);
      $st[2] = 1;
      do_mysql ("UPDATE players SET status1 = '".$st."' WHERE id_player = '".$id."';");

      // regeneracija sposobna so vremenem pereborotq krovotechenie:
      $q = do_mysql ("SELECT skills, last FROM players WHERE id_player = '".$id."';");
      $r = mysql_fetch_assoc ($q);
      $r['skills'] = explode ('|', $r['skills']);
      $r['last'] = explode ('|', $r['last']);
      if ($r['skills'][5] > 0)
      {
        $time = time();
        $plus = 130 - 10 * $r['skills'][5];
        if ($plus < 30) $plus = 30;
        $r['last'][5] = $time + $plus;
        $last = $r['last'][0].'|'.$r['last'][1].'|'.$r['last'][2].'|'.$r['last'][3].'|'.$r['last'][4].'|'.$r['last'][5].'|'.$r['last'][6].'|'.$r['last'][7].'|'.$r['last'][8];
        do_mysql ("UPDATE players SET last = '".$last."' WHERE id_player = '".$id."';");
      }
      return 1;
    }

    // proverjatq na npc nenado set_affected proverit
    include_once ('modules/f_set_affected.php');
    set_affected ($name, 'krovotechenie');
    return 1;
  }
?>