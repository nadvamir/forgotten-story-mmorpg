<?php
  // formuljar sozdanija tem
  do_mysql ("INSERT INTO fonline VALUES ('".$LOGIN."', 'создание темы', NOW());");
  $f = gen_header ('создать тему');
  $f .= '<div class="y" id="g"><b>создать тему:</b></div><div class="n" id="aisfa">';
  // kolichestvo nechitanyh ls
  $qrl = "SELECT COUNT(*) FROM ls WHERE sentfor = '".$p['id_player']."' AND readed = 'no';";
  $arl = do_mysql($qrl);
  $ls = mysql_result($arl,0);
  if ($ls > 0)
  {
    $f .= 'нов. сообщений: ';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">'.$ls.'</a><br/>';
  }
  $id_forum = preg_replace ('/[^0-9]/', '', $_GET['id_forum']);
  $f .= '<form action="game.php" metchod="get">';
  $f .= '<input type="hidden" name="action" value="forum"/>';
  $f .= '<input type="hidden" name="sub_action" value="add_theme"/>';
  $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
  $f .= 'название:<br/>';
  $f .= '<input type="text" name="name" maxlength="36"/>';
  $f .= '<input type="hidden" name="id_forum" value="'.$id_forum.'"/>';
  // translit
  $f .= '<br/><input type="radio" name="t" value="1"/>транслит<br/>';
  $f .= '<input type="radio" name="t" value="0"/>как есть<br/>';
  $f .= '<input type="submit" value="создать"/></form></p>';

  $f .= '<br/><b>навигация:</b><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showthemes&id_forum='.$id_forum.'">темы</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum">форумы</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">друзья</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
  $f .= '</div>';
  $f .= gen_footer();
  exit ($f);
?>