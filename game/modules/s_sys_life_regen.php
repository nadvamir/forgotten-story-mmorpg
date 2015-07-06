<?php
//echo 'included<br/><pre>';
  // vsjakoe - 
  // potushim kostry
  do_mysql ("UPDATE items SET on_take = 'off' WHERE realname LIKE 'i.o.sta.fireplace%' AND on_take = 'on' AND on_use < '".(time ())."';");
  // udalenija staryh - 
  // esli ostalisq starye, ih nado udalitq, no eshe i s lokacii vykinutq
  $a = do_mysql ("SELECT login FROM session WHERE puttime < NOW() - INTERVAL '10' MINUTE");
  // perebor
  while ($del = mysql_fetch_assoc ($a))
  {
    $del_loc = get_pl_info ($del['login'], 'location');
    do_mysql ("UPDATE players SET active = '0' WHERE login = '".$del['login']."';");
    do_mysql ("DELETE FROM session WHERE login = '".$del['login']."';");
  }

  // vosstonovlenie zhizni u npc
  // u ljudej po ihnim lichnym dannym
  // npc tolqko te chto v karte
  $map = substr ($p['location'], 0, 4);
  include_once ('modules/f_upd_affected.php');
  include_once ('modules/f_get_affected.php');
  // na skolqko
  /*$mon = get_month();
  $q = do_mysql ("SELECT life_regen FROM gamesys WHERE month = '".$mon."';");
  $all['life_regen'] = mysql_result ($q, 0);*/

  if (!$all['life_regen']) $all['life_regen'] = $time - 30;

  $lp = floor (($time - $all['life_regen']) / 5);
  $treg = $all['life_regen'] + $lp * 5;
  if (!$treg) $treg = $time;
  do_mysql ("UPDATE gamesys SET life_regen = '".$treg."' WHERE month = '".$mon."';");
  $qn = do_mysql ("SELECT id_npc, fullname, life, affected FROM npc WHERE type <> 's' AND type <> 't';");
  while ($n = mysql_fetch_assoc ($qn))
  {
    // zaodno i effekty
    if (isset ($naff)) unset ($naff);
    $naff = $n['affected'];
    if ($n['affected'])
    {
      upd_affected ($n['fullname']);
      $naff = get_affected ($n['fullname']);
    }
    if (is_in ('zarazhen', $naff)) continue;
    $n['life'] = explode ('|', $n['life']);
    if (is_in ('krovotechenie', $naff))
    {
//echo 'k ';
      $n['life'][0] -= ($lp * 10);
      $m = 1;
    }
    if (is_in ('otravlen', $naff))
    {
//echo 'o ';
      //$n['life'][0] -= ($lp * (round ($n['life'][1] / 100)));
      $n['life'][0] -= ($lp * 7);
      $m = 1;
    }
    if (is_in ('gorit', $naff))
    {
//echo 'g ';
      //$n['life'][0] -= ($lp * (round ($n['life'][1] / 20)));
      $n['life'][0] -= ($lp * 20);
      $m = 1;
    }
    if ($n['life'][0] < $n['life'][1] && !isset ($m) && !is_in ('prokljat', $naff) && !is_in ('zarazhen', $naff))
    {
      if ($n['life'][0] + $lp > $n['life'][1]) $n['life'][0] = $n['life'][1];
      else $n['life'][0] += $lp;
    }
    if ($n['life'][0] <= 0)
    {
/*echo '<pre>sam umer!!! (жизнь +'.$lp.' была), при смерти '.$n['life'][0].'/'.$n['life'][1].'<br/>';
print_r ($naff);
echo 'сейчас '.$time.'сек униксовых,<br/>';
echo 'а последний раз выполнялось когда было '.$all['life_regen'].'<br/>';
echo 'treg: '.$treg.'<br/>';
echo 'month: '.$mon.'<br/>';
echo '<pre>';
print_r ($TESTALL);*/
      include_once ('modules/f_make_die.php');
      make_die ($n['fullname']);
    }
    else
    {
      $lf = $n['life'][0].'|'.$n['life'][1];
      do_mysql ("UPDATE npc SET life = '".$lf."' WHERE id_npc = '".$n['id_npc']."';");
    }
  }
?>