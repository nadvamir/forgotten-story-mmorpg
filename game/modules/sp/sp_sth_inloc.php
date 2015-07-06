<?php
  // chastq skripta gde abrabatyvaetsja lokacija:
  $show = 50;
  if (!isset ($_GET['start'])) $start = 0;
  else $start = preg_replace ('/[^0-9]/', '', $_GET['start']);
  if ($start === false) put_error ('try not to cheat');

  // zapros na kolichestvo  v lokacii:
  // igrokov:
  $c1 = do_mysql ("SELECT COUNT(*) FROM players WHERE location = '".$p['location']."' AND login != '".$LOGIN."' AND active = 1;");
  $c1 = mysql_result ($c1, 0);
#  echo $c1.' ';
  // npc:
  $c2 = do_mysql ("SELECT COUNT(*) FROM npc WHERE location = '".$p['location']."';");
  $c2 = mysql_result ($c2, 0);
#  echo $c2.' ';
  // veshei:
  $c3 = do_mysql ("SELECT COUNT(*) FROM items WHERE location = '".$p['location']."';");
  $c3 = mysql_result ($c3, 0);
#  echo $c3.' ';
  // trupov:
  $c4 = do_mysql ("SELECT COUNT(*) FROM dead WHERE location = '".$p['location']."';");
  $c4 = mysql_result ($c4, 0);
#  echo $c4.' ';
  // obshee:
  $c = $c1 + $c2 + $c3 + $c4;

  ///////////////////////////////////////////////////////////////
  // vse tipy teh, kto v lokacii
  $INL_P = array();
  $INL_N = array();
  $INL_I = array();
  $INL_D = array();
  $INL_I_C = array(); // kolichestvo veshej v lokacii
  ///////////////////////////////////////////////////////////////

  // esli estq igroki, kotoryh nado pokazatq
  $show = 10000;
  if ($c1 > $start)
  {
    // esli igrokov hvatit chtoby vesq $show vypisatq
    if ($c1 >= $start + $show)
    {
      $lim = 'LIMIT '.$start.', '.$show;
    }
    else
    {
      // igrokov nehvataet, nado budet dopolnitq $next drugimi
      $next = $start + $show - $c1;
      $to = $show - $next;
      if ($to < 0) $to = 0;
      $lim = 'LIMIT '.$start.', '.$to.'';
    }
    /* tut zaprosy, while i td */
    $i = 0;
    $a = do_mysql ("SELECT id_player, login, classof, rase, stats, life, clan, status1, in_battle, karma, affected, admin, name, walking FROM players WHERE location = '".$p['location']."' AND login <> '".$LOGIN."' AND active = '1' AND admin > '-2' AND hidden = '0' ORDER BY id_player DESC ".$lim.";");
    while ($INL_P[] = mysql_fetch_assoc ($a))
    {
      if ($INL_P[$i]['karma'] < -69) $INL_P[$i]['nc'] = 'red'; // cvet imja
      elseif ($INL_P[$i]['karma'] < -29) $INL_P[$i]['nc'] = 'orange';
      elseif ($INL_P[$i]['karma'] < 300) $INL_P[$i]['nc'] = 'blue';
      else $INL_P[$i]['nc'] = 'green';
      if (strpos ($INL_P[$i]['affected'], 'hamelion') !== false) $INL_P[$i]['nc'] = 'hamelion';
      if (strpos ($INL_P[$i]['affected'], 'blagouhanie') !== false) $INL_P[$i]['nc'] = 'blagouhanie';
      $INL_P[$i]['life'] = explode ('|', $INL_P[$i]['life']);
      $INL_P[$i]['clan'] = explode ('|', $INL_P[$i]['clan']); 
      $INL_P[$i]['stats'] = explode ('|', $INL_P[$i]['stats']);
      $i++;
    }
  }
  else
  {
    // igrokov bolqshe net
    $next = $show;
  }

  $i = 0;
  // esli nado
  if (isset ($next))
  {
    // esli estq npc, kotoryh nado pokazatq
    if ($c1 + $c2 > $start)
    {
      if ($c1 + $c2 >= $start + $show)
      {
        $from = $start - $c1;
        if ($from < 0) $from = 0;
        $lim = 'LIMIT '.$from.', '.$next;
      }
      else
      {
        $next2 = $start + $show - $c1 - $c2;
        $from = $start - $c1;
        if ($from < 0) $from = 0;
        $to = $show - $next2;
        if ($to < 0) $to = 0;
        $lim = 'LIMIT '.$from.', '.$to.'';
      }
      /* tut zaprosy, while i td */
      $a = do_mysql ("SELECT name, fullname, type, life, exp, in_battle, belongs, quest, lvl FROM npc WHERE location = '".$p['location']."' AND hidden = '0' ORDER BY id_npc DESC ".$lim.";");
      while ($INL_N[] = mysql_fetch_assoc ($a))
      {
        //if (in_array ($INL_N[$i]['fullname'], $p['in_battle'])) continue;
        $INL_N[$i]['life'] = explode ('|', $INL_N[$i]['life']);
        $i++;
      }
    }
    else
    {
      $next2 = $next;
    }
  }

  $i = 0;
  // esli nado
  if (isset ($next2))
  {
    // esli estq veshi, kotorye nado pokazatq
    if ($c1 + $c2 + $c3 > $start)
    {
      if ($c1 + $c2 + $c3 >= $start + $show)
      {
        $from = $start - $c1 - $c2;
        if ($from < 0) $from = 0;
        $lim = 'LIMIT '.$from.', '.$next2;
      }
      else
      {
        $next3 = $start + $show - $c1 - $c2 - $c3;
        $from = $start - $c1 - $c2;
        if ($from < 0) $from = 0;
        $to = $show - $next3;
        if ($to < 0) $to = 0;
        $lim = 'LIMIT '.$from.', '.$to.'';
      }
      /* tut zaprosy, while i td */
      $a = do_mysql("SELECT fullname, name, on_take, type, on_drop, realname FROM items WHERE location = '".$p['location']."' ORDER BY id_item DESC ".$lim.";");
      while ($INL_I[] = mysql_fetch_assoc ($a))
      {
        if (!isset ($INL_I_C[$INL_I[$i]['realname']])) $INL_I_C[$INL_I[$i]['realname']] = 1;
        else $INL_I_C[$INL_I[$i]['realname']]++;
        // nichego...
        $i++;
      }
    }
    else
    {
      $next3 = $next2;
    }
  }

  $i = 0;
  // esli nado
  if (isset ($next3))
  {
    // esli estq veshi, kotorye nado pokazatq
    if ($c > $start)
    {
      if ($c >= $start + $show)
      {
        $from = $start - $c1 - $c2 - $c3;
        if ($from < 0) $from = 0;
        $lim = 'LIMIT '.$from.', '.$next3;
      }
      else
      {
#        $next3 = $start + $show - $c;
        $next3 = $start + $c;
        $from = $start - $c1 - $c2 - $c3;
        if ($from < 0) $from = 0;
        $lim = 'LIMIT '.$from.', '.$next3.'';
      }
      /* tut zaprosy, while i td */
      $a = do_mysql ("SELECT fullname, name, hunt FROM dead WHERE location = '".$p['location']."' ORDER BY fullname ".$lim.";");
      while ($INL_D[] = mysql_fetch_assoc ($a))
      {
      }
    }
  }
?>