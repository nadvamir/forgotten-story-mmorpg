<?php
  // funkcija magicheskogo napadenija:
  function mag_decl_attack ($who, $to)
  {
    // po idee magiej npc napadatq nebudut, no na vsjakij pozharnyj i tak puwu:
    //$who = preg_replace ('/[^a-z0-9_\.]/i', '', $who);
    //$to = preg_replace ('/[^a-z0-9_\.]/i', '', $to);
    if ($to == $who) put_g_error ('на себя напасть нелзя!');
    $id = is_player ($who);
    $n = 0;
    if ($id) $q = do_mysql ("SELECT in_battle, status1, location, last FROM players WHERE id_player = '".$id."';");
    else
    {
      $id = is_npc ($who);
      $n = 1;
      $q = do_mysql ("SELECT in_battle, location FROM npc WHERE id_npc = '".$id."';");
    }
    $w_inf = mysql_fetch_assoc ($q);

    $tid = is_player ($to);
    $tn = 0;
    if ($tid) $q = do_mysql ("SELECT in_battle, status1, location FROM players WHERE id_player = '".$tid."';");
    else
    {
      $tid = is_npc ($to);
      $tn = 1;
      $q = do_mysql ("SELECT in_battle, location FROM npc WHERE id_npc = '".$tid."';");
    }
    $t_inf = mysql_fetch_assoc ($q);

    if ($w_inf['location'] != $t_inf['location']) return 0; // celq nedostezhima

    include_once ('modules/f_attack.php');
    attack ($who, $to);

    return 1;
  }
?>