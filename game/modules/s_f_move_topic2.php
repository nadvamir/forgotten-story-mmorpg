<?php
  // perenesti temu v drugoj forum
  if ($p['admin'] > 0)
  {
    $id_theme = preg_replace ('/[^0-9]/', '', $_GET['id_theme']);
    $id_forum = preg_replace ('/[^0-9]/', '', $_GET['id_forum']);
    $q = do_mysql ("SELECT name FROM themes WHERE id_theme = '".$id_theme."';");
    if (!mysql_num_rows ($q)) put_g_error ('нету такой темы');
    $tname = mysql_result ($q, 0);
    $q = do_mysql ("SELECT name FROM forums WHERE id_forum = '".$id_forum."';");
    if (!mysql_num_rows ($q)) put_g_error ('нету такого форума');
    $fname = mysql_result ($q, 0);

    do_mysql ("UPDATE themes SET id_forum = '".$id_forum."' WHERE id_theme = '".$id_theme."';");

    $f = gen_header ('переместить тему');
    $f .= '<div class="y" id="lisd"><b>переместить тему</b></div><p>';
    $f .= 'вы переместили тему '.$tname.' в форум '.$fname.'!<br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum">форум</a><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
    $f .= gen_footer ();
    exit ($f);
  }
?>