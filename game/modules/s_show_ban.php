﻿<?php
  // pokazatq ban i razbanitq zaodno
  if ($p['admin'] > 0)
  {
    if (!isset($_GET['to']))
    {
      $f = gen_header ('бан');
      $f .= '<div class="y" id="oit"><b>баня</b></div><p>';
      $q = do_mysql ("SELECT login FROM players WHERE admin = '-1';");
      while ($b = mysql_fetch_assoc ($q))
        $f .= '&#187;'.$b['login'].' (<a class="red" href="game.php?sid='.$sid.'&action=show_ban&to='.$b['login'].'">x</a>)<br/>';
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=moder"/>модераторская</a><br/>';
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=forum"/>форум</a><br/>';
      $f .= '<a class="blue" href="game.php?sid='.$sid.'"/>в игру</a></p>';
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
    exit_msg ('баня', 'игрок '.$to.' paзбанен!<br/><a class="blue" href="game.php?sid='.$sid.'&action=forum"/>форум</a>');
  }
?>