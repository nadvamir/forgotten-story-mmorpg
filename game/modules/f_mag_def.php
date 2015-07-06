<?php
  // funkcija magicheskogo parirovanija, soprotivlenija i uklona
  // vozvrashjaet nomer dejstvija, 0 - netu takovyh
  // skill eto navyk konkretnogo zakla napadajushego
  function mag_def ($off, $skill, $location, $def)
  {
    //$off = preg_replace ('/[^a-z0-9_\.]/i', '', $off);
    //$def = preg_replace ('/[^a-z0-9_\.]/i', '', $def);

    // berem shansy
    $id = is_player ($off);
    if ($id)
    {
      include_once ('modules/f_get_pl_battle_har.php');
      $off_har = get_pl_battle_har ($off);
      $off_har[5] += $skill * 3;
      $off_har[6] += $skill * 3;
      $off_har[7] += $skill * 3;
      $q = do_mysql ("SELECT life FROM players WHERE id_player = '".$id."';");
      $off_life = mysql_result ($q, 0);
      $off_life = explode ('|', $off_life);
      $off_name = $off;
    }
    else
    {
      $id = is_npc ($off);
      include_once ('modules/f_get_npc_battle_har.php');
      $off_har = get_npc_battle_har ($off);
      $q = do_mysql ("SELECT life, name FROM npc WHERE id_npc = '".$id."';");
      $off_a = mysql_fetch_assoc ($q);
      $off_life = explode ('|', $off_a['life']);
      $off_name = $off_a['name'];
    }
    $tid = is_player ($def);
    if ($tid)
    {
      include_once ('modules/f_get_pl_battle_har.php');
      $def_har = get_pl_battle_har ($def);
      $q = do_mysql ("SELECT life FROM players WHERE id_player = '".$tid."';");
      $def_life = mysql_result ($q, 0);
      $def_life = explode ('|', $def_life);
      $def_name = $def;
    }
    else
    {
      $tid = is_npc ($def);
      include_once ('modules/f_get_npc_battle_har.php');
      $def_har = get_npc_battle_har ($def);
      $q = do_mysql ("SELECT life, name FROM npc WHERE id_npc = '".$tid."';");
      $def_a = mysql_fetch_assoc ($q);
      $def_life = explode ('|', $def_a['life']);
      $def_name = $def_a['name'];
    }

    // teperq formiruem shansy proporcianalqno:
    include_once ('modules/f_get_chanses.php');
    $ch = get_chanses ($off_har, $off_life, $def_har, $def_life);
    // ch[0] eto napadajushij, ch[1] eto zashishjajushijsja
    // 5 - blok, 6 - sopr, 7 - uklon
    // vyberem sluchaino:
    $do = rand (5, 7);
    // teperq shans eto sdelatq:
    $proc = rand (0, 100);
    // esli vyjdet to sdelaem i vozvratim znachenie:
    if ($proc <= $ch[1][$do])
    {
      // znachit taki sdelali
      if ($do == 5)
      {
        // blok:
        add_journal ($def_name.' блокировал магию '.$off_name.'!', 'l.'.$location);
        return 1;
      }
      elseif ($do == 6)
      {
        // soprotivlenie:
        add_journal ($def_name.' сопротивился магии '.$off_name.'!', 'l.'.$location);
        return 2;
      }
      else
      {
        // uklon:
        add_journal ($def_name.' уклонился от магии '.$off_name.'!', 'l.'.$location);
        return 3;
      }
    }
    else
      return 0;
  }
?>