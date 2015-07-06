<?php
  // reitingi
  $f = gen_header ('рейтинги');
  // osnovnaja
  $show = 10;
  $f .= '<div class="y" id="osnovn1">';
  $f .= '<b>рейтинги:</b></div><div class="n" id="a0376g">';
  if (!isset ($_GET['how'])) $_GET['how'] = 'exp';
  if ($_GET['how'] == 'exp')
  {
    // pokazyvaem reiting po opytu
    $q = do_mysql ("SELECT COUNT(*) FROM players;");
    $c = mysql_result ($q, 0);
    $pe = array();
    $q = do_mysql ("SELECT login, name, stats FROM players ORDER BY id_player;");
    for ($i = 0; $i < $c; $i++)
      $pe[] = mysql_fetch_assoc ($q);
    // teperq sortiruem:
    $max = array();
    for ($i = 0; $i < $show; $i++) $max[$i] = $c - 1;
    for ($i = 0; $i < $show; $i++)
    {
      for ($j = 0; $j < $c; $j++)
      {
        if (in_array ($j, $max)) continue;
        if ($i == 0) $pe[$j]['stats'] = explode ('|', $pe[$j]['stats']);
        if ($pe[$j]['stats'][0] > $pe[$max[$i]]['stats'][0] || $pe[$j]['stats'][0] == $pe[$max[$i]]['stats'][0] && $pe[$j]['stats'][1] >= $pe[$max[$i]]['stats'][1])
          $max[$i] = $j;
      }
    }
    $f .= '<b>по опыту:</b><br/>';
    for ($i = 0; $i < $show; $i++)
    {
      $f .= ($i + 1).': <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$pe[$max[$i]]['login'].'">'.$pe[$max[$i]]['name'].'</a> (yp. '.$pe[$max[$i]]['stats'][0].' exp '.$pe[$max[$i]]['stats'][1].')<br/>';
    }
    $f .= '&#187;по опыту<br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=hunt">';
    $f .= 'по качеству охоты</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=pvp">';
    $f .= 'по качеству PvP</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=karmam">';
    $f .= 'по карме-</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=karmap">';
    $f .= 'по карме+</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=money">';
    $f .= 'по деньгам</a><br/>';
  }
  if ($_GET['how'] == 'money')
  {
    // pokazyvaem reiting po denqgam
    $q = do_mysql ("SELECT name, money FROM players ORDER BY money DESC LIMIT ".$show.";");
    $f .= '<b>по деньгам:</b><br/>';
    $i = 1;
    while ($r = mysql_fetch_assoc ($q))
    {
      $f .= $i.': '.$r['name'].' ('.$r['money'].')<br/>';
      $i++;
    }
    $f .= '&#187;по деньгам<br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=hunt">';
    $f .= 'по качеству охоты</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=pvp">';
    $f .= 'по качеству PvP</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=karmam">';
    $f .= 'по карме-</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=karmap">';
    $f .= 'по карме+</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=exp">';
    $f .= 'по опыту</a><br/>';
  }
  if ($_GET['how'] == 'karmap')
  {
    // pokazyvaem reiting po denqgam
    $q = do_mysql ("SELECT name, karma FROM players ORDER BY karma DESC LIMIT ".$show.";");
    $f .= '<b>по положительной карме:</b><br/>';
    $i = 1;
    while ($r = mysql_fetch_assoc ($q))
    {
      $f .= $i.': '.$r['name'].' ('.$r['karma'].')<br/>';
      $i++;
    }
    $f .= '&#187;по карме+<br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=exp">';
    $f .= 'по опыту</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=hunt">';
    $f .= 'по качеству охоты</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=pvp">';
    $f .= 'по качеству PvP</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=money">';
    $f .= 'по деньгам</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=karmam">';
    $f .= 'по карме-</a><br/>';
  }
  if ($_GET['how'] == 'karmam')
  {
    // pokazyvaem reiting po denqgam
    $q = do_mysql ("SELECT name, karma FROM players ORDER BY karma LIMIT ".$show.";");
    $f .= '<b>по отрицательной карме:</b><br/>';
    $i = 1;
    while ($r = mysql_fetch_assoc ($q))
    {
      $f .= $i.': '.$r['name'].' ('.$r['karma'].')<br/>';
      $i++;
    }
    $f .= '&#187;по карме-<br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=exp">';
    $f .= 'по опыту</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=hunt">';
    $f .= 'по качеству охоты</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=pvp">';
    $f .= 'по качеству PvP</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=money">';
    $f .= 'по деньгам</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=karmap">';
    $f .= 'по карме+</a><br/>';
  }
  if ($_GET['how'] == 'hunt')
  {
    // pokazyvaem reiting po denqgam
    $q = do_mysql ("SELECT name, monsterkill FROM players ORDER BY monsterkill DESC LIMIT ".$show.";");
    $f .= '<b>по качеству охоты:</b><br/>';
    $i = 1;
    while ($r = mysql_fetch_assoc ($q))
    {
      $f .= $i.': '.$r['name'].' ('.($r['monsterkill']).')<br/>';
      // +'.$r['monsterkill'].' - '.$r['kbmonster'].' = 
      $i++;
    }
    $f .= '&#187;по качеству охоты<br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=exp">';
    $f .= 'по опыту</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=money">';
    $f .= 'по деньгам</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=pvp">';
    $f .= 'по качеству PvP</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=karmam">';
    $f .= 'по карме-</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=karmap">';
    $f .= 'по карме+</a><br/>';
  }
  if ($_GET['how'] == 'pvp')
  {
    // pokazyvaem reiting po denqgam
    $q = do_mysql ("SELECT name, playerkill FROM players ORDER BY playerkill DESC LIMIT ".$show.";");
    $f .= '<b>по качеству PvP:</b><br/>';
    $i = 1;
    while ($r = mysql_fetch_assoc ($q))
    {
      $f .= $i.': '.$r['name'].' ('.($r['playerkill']).')<br/>';
      $i++;
    }
    $f .= '&#187;по качеству PvP<br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=exp">';
    $f .= 'по опыту</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=money">';
    $f .= 'по деньгам</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=hunt">';
    $f .= 'по качеству охоты</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=karmam">';
    $f .= 'по карме-</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_ratings&how=karmap">';
    $f .= 'по карме+</a><br/>';
  }
  $f .= '</div>';
  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'&action=mir_igry">мир игры</a>';
  $f .= '<br/><a class="blue" href="game.php?sid='.$sid.'&action=showinventory">в инвентарь</a>';
  $f .= '<br/><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>