<?php
  // razbanitq
  if ($p['admin'] > 0)
  {
    if (!isset($_GET['to']))
    {
      $f = gen_header ('бан');
      $f .= '<div class="y" id="oit"><b>paзбанить</b></div></p>';
      $f .= 'логин:<br/>';
      $f .= '<form action="game.php" method="get">';
      $f .= '<input type="hidden" name="action" value="unban"/>';
      $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
      $f .= '<input type="text" name="to"/>';
      $f .= '<br/><input type="submit" value="разбанить!"/></form>';
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=forum"/>форум</a><br/>';
      $f .= '<a class="blue" href="game.php?sid='.$sid.'"/>в игру</a>';
      $f .= gen_footer();
      exit ($f);
    }
    $to = preg_replace ('/[^a-z0-9]/i', '', $_GET['to']);
    $id = is_player ($to);
    if (!$id) put_g_error ('такого игрока нету');
    $q = do_mysql ("SELECT admin FROM players WHERE id_player = '".$id."';");
    $adm = mysql_result ($q, 0);
    if ($adm != -1) put_g_error ('игрок не в бане');
    do_mysql ("UPDATE players SET admin = '0' WHERE id_player = '".$id."';");
    exit_msg ('баня', 'игрок '.$to.' paзбанен!');
  }
?>