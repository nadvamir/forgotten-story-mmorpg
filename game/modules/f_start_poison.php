<?php
  // funkcija nachinaet krovotechenie u npc ili igroka
  function start_poison ($name)
  {
    //$name = preg_replace ('/[^a-z0-9_\.]/i', '', $name);

    $id = is_player ($name);
    if ($id)
    {
      $q = do_mysql ("SELECT status1 FROM players WHERE id_player = '".$id."';");
      $st = mysql_result ($q, 0);
      $st[3] = 1;
      do_mysql ("UPDATE players SET status1 = '".$st."' WHERE id_player = '".$id."';");
      return 1;
    }

    // proverjatq na npc nenado set_affected proverit
    include_once ('modules/f_set_affected.php');
    set_affected ($name, 'otravlen');
    return 1;
  }
?>