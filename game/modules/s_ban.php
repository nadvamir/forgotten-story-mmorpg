<?php
  // zabanitq
  if ($p['admin'] > 0)
  {
    if (!isset($_GET['to']))
    {
      $f = gen_header ('разбираемся');
      $f .= '<div class="y" id="oit"><b>че делать то?</b></div><div class="n" id="udhgd">';
      $f .= 'логин:<br/>';
      $f .= '<form action="game.php" method="get">';
      $f .= '<input type="hidden" name="action" value="ban"/>';
      $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
      $f .= '<input type="text" name="to"/><br/>-1 ban. -2 blok<br/>';
      $f .= '<input type="text" name="how"/>';
      $f .= '<br/><input type="submit" value="всё!"/></form>';
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=moder"/>модераторская</a><br/>';
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=forum"/>форум</a><br/>';
      $f .= '<a class="blue" href="game.php?sid='.$sid.'"/>в игру</a></div>';
      $f .= gen_footer();
      exit ($f);
    }
    $to = preg_replace ('/[^a-z0-9]/i', '', $_GET['to']);
    $how = preg_replace ('/[^-0-9]/i', '', $_GET['how']);
    if (!$how) $how = -1;
    $id = is_player ($to);
    if (!$id) put_g_error ('такого игрока нету');
    $q = do_mysql ("SELECT admin FROM players WHERE id_player = '".$id."';");
    $adm = mysql_result ($q, 0);
    if ($adm == 2) put_g_error ('меня банить! да я те шя...');
    if ($p['admin'] < 2 && $how < -2 || $p['admin'] < 2 && $how > -1) put_g_error ('низя!');
    do_mysql ("UPDATE players SET admin = '".$how."' WHERE id_player = '".$id."';");
    exit_msg ('разборки', 'с игроком '.$to.' все ясно!<br/><a class="blue" href="game.php?sid='.$sid.'&action=forum"/>форум</a>');
  }
?>