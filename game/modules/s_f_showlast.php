<?php
  do_mysql ("INSERT INTO fonline VALUES ('".$LOGIN."', 'просмотр последних', NOW());");
  $f = gen_header ('просмотр последних');
  $f .= '<div class="y" id="oi"><b>последниe посты:</b></div><p>';
  $q = do_mysql ("SELECT * FROM themes WHERE id_forum != 8 AND id_forum != 10 ORDER BY lpost DESC LIMIT 0, 10;");
  while ($t = mysql_fetch_assoc ($q))
  {
    $a = do_mysql ("SELECT author FROM posts WHERE id_theme = '".$t['id_theme']."' ORDER BY puttime DESC LIMIT 0, 1;");
    if (!mysql_num_rows ($a)) { $f .= 'создана тема "<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showposts&id_theme='.$t['id_theme'].'&id_forum='.$t['id_forum'].'&start=0">'.$t['name'].'</a>"!<br/>'; continue; }
    $name = mysql_result ($a, 0);
    $f .= '<small>в теме</small> "<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showposts&id_theme='.$t['id_theme'].'&id_forum='.$t['id_forum'].'&start=0">'.$t['name'].'</a>"<small> отписался</small> <a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showposts&id_theme='.$t['id_theme'].'&id_forum='.$t['id_forum'].'&start=100000">'.$name.'</a>!<br/>';
  }
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showlast">обновить</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum">форум</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer ();
  exit ($f);
?>