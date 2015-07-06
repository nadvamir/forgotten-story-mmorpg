<?php
  // opyt za pobedu
  function gain_battle_exp ($who, $from, $dmg)
  {
    //$who = preg_replace ('/[^a-z0-9\._]/i', '', $who);
    //$from = preg_replace ('/[^a-z0-9\._]/i', '', $from);
    $tid = is_player ($from);
    if ($tid)
    {
      $q = do_mysql ("SELECT stats FROM players WHERE id_player = '".$tid."';");
      $stats2 = mysql_result ($q, 0);
      $q = do_mysql ("SELECT life FROM players WHERE id_player = '".$tid."';");
      $life = mysql_result ($q, 0);
      $life = explode ('|', $life);
      if (!$stats2) return 0;
      $stats2 = explode ('|', $stats2);
      $exp = $stats2[0] * 20;
      $nlvl = $stats2[0];
      $player = 1;
    }
    else
    {
      $tid = is_npc ($from);
      $q = do_mysql ("SELECT exp FROM npc WHERE id_npc = '".$tid."';");
      $q2 = do_mysql ("SELECT life FROM npc WHERE id_npc = '".$tid."';");
      $life = mysql_result ($q2, 0);
      $life = explode ('|', $life);
      $exp = mysql_result ($q, 0);
      $q = do_mysql ("SELECT lvl FROM npc WHERE id_npc = '".$tid."';");
      $nlvl = mysql_result ($q, 0);
      if (!$exp) return 0;
      $player = 0;
    }
    $id = is_player ($who);
    if (!$id)
    {
      $id = is_npc ($who);
      // dadim opyt npc:
      $q = do_mysql ("SELECT lvl, location, name FROM npc WHERE id_npc = '".$id."';");
      $npc = mysql_fetch_assoc ($q);
      $exp = round ($exp * ($nlvl / $npc['lvl']) * ($dmg / $life[1]));

      //add_journal ($npc['name'].' +'.$exp.'exp!', 'l.'.$npc['location']);

      do_mysql ("UPDATE npc SET expto = expto + '".$exp."', exphas = exphas + '".$exp."' WHERE id_npc = '".$id."';");
      include_once ('modules/f_check_npc_exp.php');
      check_npc_exp ($who);
      return 1;
    }
    else
    {
      if ($player) return 1;
      $q = do_mysql ("SELECT stats FROM players WHERE id_player = '".$id."';");
      $stats = mysql_result ($q, 0);
      if (!$stats) return 0;
      $stats = explode ('|', $stats);
      $lvl = $stats[0];
      $exp = round ($exp * ($nlvl / $lvl) * ($dmg / $life[1]));

      //$exp *= 2; // dvojnoj opyt

      $slv = round ($exp / 2);
      
      $q = do_mysql ("SELECT account FROM players WHERE id_player = '".$id."';");
      $acc = mysql_result ($q, 0);
      if ($acc == 2 || $acc == 4) $exp = round ($exp * 1.35);
      if ($acc == 1 || $acc == 4) $slv *= 2;

      // dobavlenie i proverka:
      $stats[1] += $exp;
      $stats[4] += $exp;
      $nstats = $stats[0].'|'.$stats[1].'|'.$stats[2].'|'.$stats[3].'|'.$stats[4].'|'.$stats[5].'|'.$stats[6].'|'.$stats[7];
      include_once ('modules/f_check_pl_exp.php');
      //if (isset ($bel)) { do_mysql ("UPDATE players SET stats = '".$nstats."' WHERE login = '".$bel."';"); add_journal ('exp +'.$exp, $bel); check_pl_exp ($bel); return 1; }
      do_mysql ("UPDATE players SET stats = '".$nstats."' WHERE id_player = '".$id."';");
      add_journal ('exp +'.$exp, $who);

      // kak priz serebro:
      include_once ('modules/f_gain_silver.php');
      gain_silver ($slv, $who);

      check_pl_exp ($who);
      return 1;
    }
  }
?>