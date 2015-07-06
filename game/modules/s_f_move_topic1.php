<?php
  // peremestitq temu. // list vseh forumov:
  if ($p['admin'] > 0)
  {
    $id_theme = preg_replace ('/[^0-9]/', '', $_GET['id_theme']);
    $q = do_mysql ("SELECT * FROM forums;");
    $f = gen_header ('переместить тему');
    $f .= '<div class="y" id="lisd"><b>переместить тему</b></div><p>';
    $f .= 'выберите форум в который переместить:<br/>';
    while ($to = mysql_fetch_assoc ($q))
    {
      $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=move_topic2&id_theme='.$id_theme.'&id_forum='.$to['id_forum'].'">';
      $f .= $to['name'].'</a>,<br/>';
    }
    $f .= '<hr/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum">форум</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
    $f .= gen_footer ();
    exit ($f);
  }
?>