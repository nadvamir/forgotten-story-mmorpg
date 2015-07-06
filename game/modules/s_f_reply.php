<?php
  // otvet konkretnomu igroku:
  do_mysql ("INSERT INTO fonline VALUES ('".$LOGIN."', 'ответ на сообщение', NOW());");
  $id_forum = preg_replace ('/[^0-9]/', '', $_GET['id_forum']);
  $id_theme = preg_replace ('/[^0-9]/', '', $_GET['id_theme']);
  $to = preg_replace ('/[^a-z0-9_]/i', '', $_GET['to']);

  $f = gen_header ('ответить');
  $f .= '<div class="y" id="dgvdglhk"><b>ответить:</b></div><div class="n" id="eiwyt54">';

  // kolichestvo nechitanyh ls
  $qrl = "SELECT COUNT(*) FROM ls WHERE sentfor = '".$p['id_player']."' AND readed = 'no';";
  $arl = do_mysql($qrl);
  $ls = mysql_result($arl,0);
  if ($ls > 0)
  {
    $f .= 'нов. сообщений: ';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">'.$ls.'</a><br/>';
  }

  $id = is_player ($to);
  $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
  $name = mysql_result ($q, 0);
  $f .= '<b>сообшение:</b> <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$to.'">'.$name.'</a>,<br/>';
  $f .= '<form action="game.php" method="get">';
  $f .= '<textarea name="msg" rows="2"></textarea>';
  $f .= '<input type="hidden" name="action" value="forum"/>';
  $f .= '<input type="hidden" name="sub_action" value="add_post"/>';
  $f .= "<input type=\"hidden\" name=\"id_forum\" value=\"".$id_forum."\"/>";
  $f .= "<input type=\"hidden\" name=\"id_theme\" value=\"".$id_theme."\"/>";
  $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
  $f .= '<input type="hidden" name="to" value="'.$to.'"/>';
  // translit
  $f .= '<br/><input type="radio" name="t" value="1"/>транслит<br/>';
  $f .= '<input type="radio" name="t" value="0"/>как есть<br/>';
  $f .= '<input type="submit" value="написать"/></form>';

  // moderam:
  if ($p['admin'] > 0)
  {
    $q = do_mysql ("SELECT admin FROM players WHERE id_player = '".$id."';");
    $adm = mysql_result ($q, 0);
    // zabanitq
    if ($adm != -1 && $adm < 1) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=ban&to='.$to.'">забанить</a><br/>';
    if ($adm == -1) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=unban&to='.$to.'">paзбанить</a><br/>';
    if ($p['admin'] > 1 && $adm < 2) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=del_all_themes&to='.$to.'">удалить все темы</a><br/>';
  }

  $f .= '<b>навигация:</b><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showposts&id_forum='.$id_forum.'&id_theme='.$id_theme.'&start=1000000">назад</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showthemes&id_forum='.$id_forum.'">темы</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum">форумы</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">друзья</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
  $f .= '</div>';
  $f .= gen_footer();
  exit ($f);
?>