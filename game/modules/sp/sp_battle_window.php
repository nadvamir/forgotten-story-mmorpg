<?php
  // okno bitvy :)
  // na dele prosto grazhdane s kotorymi vojuem
  $f .= '<div class="y" id="battle"><b>бой:</b></div><div class="n" id="aishfgas">';
  include_once ('modules/f_get_npc_battle_har.php');
  include_once ('modules/f_get_pl_battle_har.php');
  include_once ('modules/f_get_chanses.php');
  include_once ('modules/f_get_dmg.php');
  $pl_dmg = get_dmg($LOGIN);
  $pl_har = get_pl_battle_har ($LOGIN);
  // nado!

  $q2 = do_mysql ("SELECT fullname, name, on_take FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'pot';");
  if (mysql_num_rows ($q2))
  {
    $f .= '<b>на поясе:</b><br/><small>';
    while ($pot = mysql_fetch_assoc ($q2))
    {
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_item&item='.$pot['fullname'].'&battle=1">';
      $f .= $pot['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$pot['fullname'].'">?</a><br/>';
    }
    $f .= '</small>';
  }

  $tob = 0;
  if ($p['in_battle'] == 1) $tob = 2;
  else $tob = 1;

  $inb = array();
  $q2 = do_mysql ("SELECT login FROM players WHERE location = '".$p['location']."' AND in_battle = '".$tob."';");
  while ($a = mysql_fetch_assoc ($q2))
  {
    $inb[] = $a;
  }
  $q2 = do_mysql ("SELECT fullname FROM npc WHERE location = '".$p['location']."' AND in_battle = '".$tob."';");
  while ($a = mysql_fetch_assoc ($q2))
  {
    $inb[] = $a;
  }

  $c = count ($inb);
  $c_inb = 0;

  for ($i = 0; $i < $c; $i++)
  {
    if (isset ($inb[$i]['login'])) $to = $inb[$i]['login'];
    else if (isset ($inb[$i]['fullname'])) $to = $inb[$i]['fullname'];
    else continue;
    if (!$to) continue;
    if (substr ($to, 0, 2) == 'n.')
    {
      include_once ('modules/f_get_npc_info.php');
      $op = get_npc_info ($to, 'all');
      $npc_har = get_npc_battle_har ($to);
        $lvl = round ($op['exp'] / 20);
    }
    elseif (is_player ($to))
    {
      include_once ('modules/f_get_pl_info.php');
      $op = get_pl_info ($to, 'all');
      $npc_har = get_pl_battle_har ($to);
     
      $lvl = $op['stats'][0];
    }
    if ($op['location'] != $p['location'])
    {
      include ('modules/f_end_battle.php');
      end_battle ($LOGIN);
      continue;
    }
    $md = $lvl - $p['stats'][0];
    if ($md < -1) $clr = '#696969';
    else if ($md == -1) $clr = '#31F3F5';
    else if ($md == 0) $clr = '#006400';
    else if ($md == 1) $clr = '#ff8c00';
    else $clr = '#8b0000';

    if (!isset ($op['name'])) $op['name'] = $op['login'];
    $ch = get_chanses ($pl_har, $p['life'], $npc_har, $op['life']);
    if (substr ($p['weapon'], 4, 3) != 'bow' || substr ($p['weapon'], 4, 3) != 'arb') $f .= '<small><b>A:</b> '.$ch[0][0].'%; <b>D:</b> '.$ch[0][1].'%</small><br/>';
    else $f .= '<small><b>A:</b> '.(100 - $ch[1][8]).'%; <b>D:</b> '.$ch[0][1].'%</small><br/>';
    $f .= '><b><span style="color:'.$clr.'">'.$op['name'].'</span></b>['.(round($op['life'][0] / $op['life'][1] * 100)).'%]';
      // effecty
      upd_affected ($to);
      $aff = get_affected ($to);
     // print_r ($aff);
      if (!$aff) $eff = '';
      else
      {
        $eff = '<small>';
        $aff = implode ('|', $aff);
        include_once ('modules/f_translit.php');
        $aff = translit ($aff);
        $eff .= $aff.'</small>';
      } 
    $f .= $eff.' - ';
    ////
    $f .= '<small><u>Att:</u></small>';
    if ($pl_dmg[0][1] > 0) $f .= ' <a class="red" href="game.php?sid='.$sid.'&action=do_dmg&type=rez&to='.$to.'">></a>';
    if ($pl_dmg[1][1] > 0) $f .= ' <a class="red" href="game.php?sid='.$sid.'&action=do_dmg&type=kol&to='.$to.'">x</a>';
    if ($pl_dmg[2][1] > 0) $f .= ' <a class="red" href="game.php?sid='.$sid.'&action=do_dmg&type=drob&to='.$to.'">o</a>';
    if ($pl_dmg[3][1] > 0) $f .= ' <a class="red" href="game.php?sid='.$sid.'&action=do_dmg&type=rub&to='.$to.'">^</a>';

    if ($p['mbook'])
    {
      // ispolqzovatq magiju iz knigi:
      $f .= '<form action="game.php" method="get"/><input type="hidden" name="sid" value="'.$sid.'"/>книга маг.:<input type="text" name="num" size="2"/><input type="hidden" name="action" value="quick_use_magic_b"/><input type="hidden" name="to" value="'.$to.'"/><input type="submit" value="&#187;"/></form>';
    }

    $f .= '<br/>';
    $c_inb++;
  }
  if ($c_inb == 0 )
  {
    include_once ('modules/f_end_battle.php');
    end_battle ($LOGIN);
  }
  $f .= '</div>';
  //exit_msg ('бой', $f);
?>