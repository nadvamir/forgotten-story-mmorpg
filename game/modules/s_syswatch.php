<?php
  // sistemnaja slezhka za igroj
  // poluchenie $all vyneseno v s_loadmaps
  //$mon = get_month();
  //$time = time();
  // berem vse iz gamesys na etot mesjac
  //$all = do_mysql ("SELECT * FROM gamesys WHERE month = '".$mon."';");
  //$all = mysql_fetch_assoc ($all);
  if ($time >= $all['npc_move'] + 180) include 'modules/s_sys_move_npc.php';
  // zaodno i karmu s pogodoj vmeste podnimem
  if ($time >= $all['weather_ch'] + 14400) include 'modules/s_sys_change_weather.php';
  if ($time >= $all['life_regen'] + 30) include 'modules/s_sys_life_regen.php';
  //if ($time >= $all['trader_ch'] + 900) include 'modules/s_sys_trader_ch.php';
  if ($time >= $all['quests_ch'] + 600) include 'modules/s_sys_quests_ch.php';
  // TRUPY udaljajutsja tam ^
  //////////////////////////////////////////

  // ubratq krovotechenie pri regeneracii:
  if ($p['last'][5] <= $time && $p['last'][5])
  {
    include_once ('modules/f_end_blood.php');
    end_blood ($LOGIN);
    $p['last'][5] = '';
  }

  if ($time - $p['last'][2] >= 30) include 'modules/s_sys_pl_life_regen.php';
  $p['last'][0] = $time;
  $last = $p['last'][0].'|'.$p['last'][1].'|'.$p['last'][2].'|'.$p['last'][3].'|'.$p['last'][4].'|'.$p['last'][5].'|'.$p['last'][6].'|'.$p['last'][7].'|'.$p['last'][8];
  do_mysql ("UPDATE players SET last = '".$last."' WHERE id_player = '".$p['id_player']."';");
?>