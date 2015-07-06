<?php
  // sozdatq novoe bd
  $num = preg_replace ('/[^0-9]/', '', $_GET['num']);
  if (!$num) $num = 0;
  if ($num > 9) $num = 9;
  $p['bd'][$num] = '';
  $nbd = implode ('|', $p['bd']);
  do_mysql ("UPDATE players SET bd = '".$nbd."' WHERE login = '".$LOGIN."';");
  $f = '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=show_bd">бд</a><br/>';
  $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a>';
  exit_msg ('удаленно!', $f);
?>