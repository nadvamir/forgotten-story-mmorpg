<?php
  // glavnaja foruma
  $f = gen_header ('&#187;форум&#171;');
  $f .= '<div class="y" id="gasd"><b>форум v1.0.0</b></div>';
  $f .= '<div class="n" id="oiqytqe">';
  do_mysql ("INSERT INTO fonline VALUES ('".$LOGIN."', 'главная форума', NOW());");

  // kolichestvo nechitanyh ls
  $qrl = "SELECT COUNT(*) FROM ls WHERE sentfor = '".$p['id_player']."' AND readed = 'no';";
  $arl = do_mysql($qrl);
  $ls = mysql_result($arl,0);
  if ($ls > 0)
  {
    $f .= 'нов. сообщений: ';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">'.$ls.'</a><br/>';
  }

  if ($p['admin'] == -2) $f .= '<b>вы в блоке с доступом на форум. это означает, что насчет вас есть сомнения и вы можете объяснится тут на форуме. контакты неработуют</b><br/>';

  $f .= '<b>форумы:</b></div>';
  $q = do_mysql ("SELECT * FROM forums ORDER BY id_forum;");
  while ($fo = mysql_fetch_assoc ($q))
  {
    if ($fo['id_forum'] == 8 && $p['admin'] < 1) continue; 
    if ($fo['id_forum'] == 10 && $p['id_player'] != 1 && $p['id_player'] != 5 && $p['id_player'] != 10) continue;
    $f .= '<div class="n" id="lgf'.$fo['id_forum'].'">';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showthemes&id_forum='.$fo['id_forum'].'">'.$fo['name'].'</a>';
    $q2 = do_mysql ("SELECT COUNT(*) FROM themes WHERE id_forum = '".$fo['id_forum']."';");
    $c = mysql_result ($q2, 0);
    $f .= ' ('.$c.')</div>';
    $a = do_mysql ("SELECT id_theme, name FROM themes WHERE id_forum = '".$fo['id_forum']."' ORDER by lpost DESC LIMIT 0, 1;");
    if (!mysql_num_rows ($a)) continue;
    $f .= '<div class="n" id="algf'.$fo['id_forum'].'">';
    $lt = mysql_fetch_assoc ($a);
    $a = do_mysql ("SELECT author FROM posts WHERE id_theme = '".$lt['id_theme']."' ORDER BY puttime DESC LIMIT 0, 1;");
    if (!mysql_num_rows ($a)) { $f .= '..новая тема "<a class="blue" href="game.php?sid='.$sid.'&id_forum='.$fo['id_forum'].'&id_theme='.$lt['id_theme'].'&sub_action=showposts&action=forum">'.$lt['name'].'</a>"</div>'; continue; }
    $lp = mysql_result ($a, 0);
    $id = is_player ($lp);
    $a = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
    $lp = mysql_result ($a, 0);
    $f .= 'last: <a class="blue" href="game.php?sid='.$sid.'&id_forum='.$fo['id_forum'].'&id_theme='.$lt['id_theme'].'&sub_action=showposts&action=forum&start=10000">'.$lp.'</a> in "<a class="blue" href="game.php?sid='.$sid.'&id_forum='.$fo['id_forum'].'&id_theme='.$lt['id_theme'].'&sub_action=showposts&action=forum">'.$lt['name'].'</a>"';
    $f .= '</div>';
  }

  $f .= '<div class="n" id="oiqytqe">';
  $f .= '<b>навигация:</b><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">друзья</a><br/>';
  if ($p['admin'] > 0) $f .= '&#187;<a class="red" href="game.php?sid='.$sid.'&action=moder">модераторская</a><br/>';
  $q = do_mysql ("SELECT COUNT(*) FROM fonline;");
  $c = mysql_result ($q, 0);
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showfonline">на форуме</a> '.$c.'<br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showsmiles">смайлы</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showlast">последниe сообщения</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showbbcode">BBCode</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
  $f .= '</div>';
  $f .= gen_footer();
  exit ($f);
?>