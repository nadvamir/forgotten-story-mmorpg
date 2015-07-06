<?php
  // posle inloc idut perehody
  // tut razvetvlenie, snachala sdelaem chtoby polnostqju perehody pokazali, potom chastichno (tolqko storony)
  if ($p['settings'][2] == 1) $f .= '<div class="y" id="auto53"><a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=locmode&set=0">-</a>';
  else $f .= '<div class="y" id="auto53"><a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=locmode&set=1">+</a>';
  $f .= '<b>путь:</b></div><p>';
  // pereberem vse vozmozhnye
  $stl = strlen ($loc[0][4]);
  for ($i = 0; $i < $stl; $i++)
  {
    $ac = $loc[0][4][$i];
    if ($ac > 4) $ac++;
    // proverka, estq li tam ktoto
    $cinl = do_mysql ("SELECT COUNT(*) FROM players WHERE location = '".$loc[$loc[0][4][$i]][0]."' AND active = '1' AND hidden = '0';");
    $cinl = mysql_result ($cinl, 0);
    $cinl2 = do_mysql ("SELECT COUNT(*) FROM npc WHERE location = '".$loc[$loc[0][4][$i]][0]."' AND hidden = '0';");
    $cinl2 = mysql_result ($cinl2, 0);
    unset ($color);
    if (!$cinl && !$cinl2) $color = 'blue';
    else
    {
      if (substr ($p['weapon'], 4, 3) == 'bow' || substr ($p['weapon'], 4, 3) == 'arb') $ARCHER = 1;
      else $ARCHER = 0;
      $color = 'red';
    }
    // storona perehoda
    if ($p['settings'][6] == 1)
    {
      $in = substr ($color, 0, 1);
      switch ($loc[0][4][$i])
      {
        case 1: $st = '<img src="smile/'.$in.'1.png" alt="."/>'; break;
        case 2: $st = '<img src="smile/'.$in.'2.png" alt="."/>'; break;
        case 3: $st = '<img src="smile/'.$in.'3.png" alt="."/>'; break;
        case 4: $st = '<img src="smile/'.$in.'4.png" alt="."/>'; break;
        case 5: $st = '<img src="smile/'.$in.'5.png" alt="."/>'; break;
        case 6: $st = '<img src="smile/'.$in.'6.png" alt="."/>'; break;
        case 7: $st = '<img src="smile/'.$in.'7.png" alt="."/>'; break;
        case 8: $st = '<img src="smile/'.$in.'8.png" alt="."/>'; break;
      }
    }
    else
    {
      switch ($loc[0][4][$i])
      {
        case 1: $st = 'сз'; break;
        case 2: $st = 'с'; break;
        case 3: $st = 'св'; break;
        case 4: $st = 'з'; break;
        case 5: $st = 'в'; break;
        case 6: $st = 'юз'; break;
        case 7: $st = 'ю'; break;
        case 8: $st = 'юв'; break;
      }
    }
    if ($p['settings'][2] == 2) $f .= '['.$st.']';
    else
    {
      $f .= '<a class="'.$color.'" href="game.php?sid='.$sid.'&action=go_to_loc&loc_go='.$loc[$loc[0][4][$i]][0].'&stor='.$loc[0][4][$i].'" accesskey="'.$ac.'">';
      $f .= $st.'</a>';
    }
    if ($p['settings'][2] > 0)
    {
      if ($p['settings'][2] == 2)
      {
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=go_to_loc&loc_go='.$loc[$loc[0][4][$i]][0].'&stor='.$loc[0][4][$i].'" accesskey="'.$ac.'">'.$loc[$loc[0][4][$i]][2].'</a>';
        if ($color == 'red') $f .= ' <b>!</b>';
      }
      else $f .= ' - '.$loc[$loc[0][4][$i]][2];
      $f .= '<br/>';
      if ($color == 'red' && $ARCHER)
      {
        $f .= '<small>';
        $q = do_mysql ("SELECT login FROM players WHERE location = '".$loc[$loc[0][4][$i]][0]."' AND active = '1';");
        while ($pla = mysql_fetch_assoc ($q))
        {
          $f .= '>'.$pla['login'];
          $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=attack&to='.$pla['login'].'&near='.$loc[$loc[0][4][$i]][0].'">x</a><br/>';
        }
        $q = do_mysql ("SELECT fullname, name FROM npc WHERE location = '".$loc[$loc[0][4][$i]][0]."' AND type != 's' AND type != 't';");
        while ($pla = mysql_fetch_assoc ($q))
        {
          $f .= '>'.$pla['name'];
          $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=attack&to='.$pla['fullname'].'&near='.$loc[$loc[0][4][$i]][0].'">x</a><br/>';
        }
        $f .= '</small>';
      }
    }
    elseif ($p['settings'][2] == 0) $f .= ' | ';
  }
  if ($loc[0][7])
  {
    $loc[0][7] = explode (':', $loc[0][7]);
    $ac = $loc[0][7][1];
    if ($ac > 4) $ac++;
    if ($p['settings'][2] != 2) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=go_to_loc&loc_go='.$loc[0][7][0].'&stor=nmap" accesskey="'.$ac.'">';
    $nmap = loc ($loc[0][7][0], 'locinfo');

    // proverka, estq li tam ktoto
    $cinl = do_mysql ("SELECT COUNT(*) FROM players WHERE location = '".$loc[0][7][0]."' AND active = '1' AND hidden = '0';");
    $cinl = mysql_result ($cinl, 0);
    $cinl2 = do_mysql ("SELECT COUNT(*) FROM npc WHERE location = '".$loc[0][7][0]."' AND hidden = '0';");
    $cinl2 = mysql_result ($cinl2, 0);
    unset ($color);
    if (!$cinl && !$cinl2) $color = 'blue';
    else $color = 'red';
    if ($p['settings'][6] == 1)
    {
      $in = substr ($color, 0, 1);
      switch ($loc[0][7][1])
      {
        case 1: $st = '<img src="smile/'.$in.'1.png" alt="."/>'; break;
        case 2: $st = '<img src="smile/'.$in.'2.png" alt="."/>'; break;
        case 3: $st = '<img src="smile/'.$in.'3.png" alt="."/>'; break;
        case 4: $st = '<img src="smile/'.$in.'4.png" alt="."/>'; break;
        case 5: $st = '<img src="smile/'.$in.'5.png" alt="."/>'; break;
        case 6: $st = '<img src="smile/'.$in.'6.png" alt="."/>'; break;
        case 7: $st = '<img src="smile/'.$in.'7.png" alt="."/>'; break;
        case 8: $st = '<img src="smile/'.$in.'8.png" alt="."/>'; break;
      }
    }
    else
    {
      switch ($loc[0][7][1])
      {
        case 1: $st = 'сз'; break;
        case 2: $st = 'с'; break;
        case 3: $st = 'св'; break;
        case 4: $st = 'з'; break;
        case 5: $st = 'в'; break;
        case 6: $st = 'юз'; break;
        case 7: $st = 'ю'; break;
        case 8: $st = 'юв'; break;
      }
    }
    if ($p['settings'][2] == 1) $f .= $st.'</a> - '.$nmap[2].'<br/>';
    elseif ($p['settings'][2] == 0) $f .= $st.'</a> | <br/>';
    else
    {
      $f .= '['.$st.']<a class="blue" href="game.php?sid='.$sid.'&action=go_to_loc&loc_go='.$loc[0][7][0].'&stor=nmap" accesskey="'.$ac.'">'.$nmap[2].'</a>';
      if ($color == 'red') $f .= ' <b>!</b>';
      $f .= '<br/>';
    }
  }
?>