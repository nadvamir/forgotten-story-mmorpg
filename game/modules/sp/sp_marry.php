<?php
  // chastq, gde budet vyvoditsja na glavnoe okno vse chto nado znatq pro zhenitqbu
  $id = is_player ($p['marry']);
  $q = do_mysql ("SELECT life FROM players WHERE id_player = '".$id."' AND active = 1");
  if (mysql_num_rows ($q))
  {
    $wl = mysql_result ($q, 0);
    $wl = explode ('|', $wl);
    if ($wl[0] / $wl[1] <= 0.25) $f .= 'ваша вторая половина изтекает <a class="red" href="game.php?sid='.$sid.'&action=teleport2spouse">кровью!</a><br/>';
  }
?>