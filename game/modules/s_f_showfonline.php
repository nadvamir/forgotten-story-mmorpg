<?php
  do_mysql ("INSERT INTO fonline VALUES ('".$LOGIN."', 'просмотр онлайн', NOW());");
  $f = gen_header ('просмотр онлайн');
  $f .= '<div class="y" id="oi"><b>на форуме:</b></div><p>';
  $q = do_mysql ("SELECT * FROM fonline;");
  while ($fo = mysql_fetch_assoc ($q))
  {
    $id = is_player ($fo['login']);
    $q2 = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
    $name = mysql_result ($q2, 0);
    $f .= '<b>'.$name.'</b>: <small>'.$fo['is_in'].'</small><br/>';
  }
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showfonline">обновить</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum">форум</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer ();
  exit ($f);
?>