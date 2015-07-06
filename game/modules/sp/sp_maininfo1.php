<?php
  // chastq stranicy main
  // statusy
  // POLNAJA VERSIJA
  //////////////////////
  // zhiznq mana 
  // esli zhizni malo, to po krasnomu ee
  /*if ($p['life'][0] * 4 < $p['life'][1])
  {
    $redl1 = '<span class="red">';
    $redl2 = '</span>';
  }
  else
  {
    $redl1 = '';
    $redl2 = '';
  }
  $f .= '<div class="y" id="sadas">';
  $f .= 'HP: '.$redl1.''.$p['life'][0].'|'.$p['life'][1].''.$redl2.' MP: '.$p['mana'][0].'|'.$p['mana'][1].'</div>';*/
  // teperq ssylki
  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'&action=showinventory" accesskey="*">';
  $f .= 'игрок</a> | <a class="blue" href="game.php?sid='.$sid.'&action=showcontacts" accesskey="0">';
  $f .= 'друзья</a> | ';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=forum" accesskey="#">форум</a>';
  if (!$p['clan'][0]) $clan = 'not';
  else $clan = $p['clan'][0];
  $qtotth = do_mysql ("SELECT id_chat FROM chat WHERE msgto = '".$LOGIN."' OR msgto = '".$clan."' OR msgfrom = '".$LOGIN."' OR  map <> '' ORDER BY puttime DESC LIMIT 0, 1;");
  if (!mysql_num_rows ($qtotth)) $lastchat = 0;
  else
    $lastchat = mysql_result($qtotth,0);
  if ($p['last'][7] > 1000000000) $p['last'][7] = 0;
  if ($lastchat > $p['last'][7]) $lc = 'red';
  else $lc = 'blue';
  $f .= ' | <a class="'.$lc.'" href="game.php?sid='.$sid.'&action=chat">чат</a>';
  $f .= ' | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=maininfo&set=0">-</a><br/>';
  // kolichestvo nechitanyh ls
  $qrl = "SELECT COUNT(*) FROM ls WHERE sentfor = '".$p['id_player']."' AND readed = 'no';";
  $arl = do_mysql($qrl);
  $ls = mysql_result($arl,0);
  if ($ls > 0)
  {
    $f .= 'нов. сообщений: ';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">'.$ls.'</a><br/>';
  }

  // novye novosti:
  $q = do_mysql ("SELECT puttime FROM news WHERE puttime > '".$p['lastnews']."' ORDER BY puttime DESC;");
  if (mysql_num_rows ($q))
  {
    $pt = mysql_result ($q, 0);
    $f .= 'Новости от <a class="black" href="game.php?sid='.$sid.'&action=news">'.$pt.'</a><br/>';
  }

  // smena oruzhij
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wea';");
  if (!mysql_num_rows ($q)) $wea = '';
  else $wea = mysql_fetch_assoc ($q);
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wst';");
  if (!mysql_num_rows ($q)) $wst = '';
  else $wst = mysql_fetch_assoc ($q);
  include_once ('modules/f_get_it_name.php');
  if ($wea || $wst)
  {
    $f .= '<small>';
    if ($wea)
    {
      $f .= $wea['name'];
    }
    else
    {
      $f .= 'кулаки';
    }
    $f .= ' | ';
    if ($wst)
    {
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=change_weapon">'.$wst['name'].'</a>';
    }
    else
    {
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=change_weapon">кулаки</a>';
    }
    $f .= '</small><br/>';
  }

  // razrushennostq shmota-
  $a = 0;
  $q = do_mysql ("SELECT realname, str FROM items WHERE belongs = '".$LOGIN."' AND is_in <> 'ban' AND is_in <> 'inv' AND is_in <> 'mar';");
  while ($di = mysql_fetch_assoc ($q))
  {
    if ($di['str'] > 500) continue;
    $prt = substr ($di['realname'], 4, 3);
    $clr = 'orange';
    if ($di['str'] < 200) $clr = 'red';
    if ($di['str'] == 0) $clr = 'gray';
    $f .= '<span class="'.$clr.'">'.$prt.'</span>, ';
    $a = 1;
  }
  if ($a) $f .= '<br/>';

  // stroka opyta
  $points = $p['stats'][4] / $p['stats'][5] * 15;
  $left = 15 - $points;
  $f .= '<span class="green"><b>';
  for ($i = 0; $i < $points; $i++) $f .= '_';
  $f .= '</span>';
  $f .= '<span class="gray">';
  for ($i = 0; $i < $left; $i++) $f .= '_';
  $f .= '</b></span>';
  $lperc = round ($p['stats'][1] / $p['stats'][2] * 100);
  $f .= ' &#171;'.$lperc.'%lvl&#187;</p>';
?>