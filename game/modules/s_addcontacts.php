<?php
  // dobavlenie kontaktov
  // proverim dannyj to
  $to = preg_replace ('/[^a-z0-9_]/i', '', $_GET['to']);
  // zapros, estq li voobshe takoj...
  $id = is_player ($to);
  $is = do_mysql ("SELECT age FROM players WHERE id_player = '".$id."';");
  if (!mysql_num_rows($is)) put_error ('нету такого игрока для контактов');
  // proverka, net li takogo v kontaktah
  if (!$p['contacts']) $p['contacts'] = $to;
  else
  {
    if (strpos ($p['contacts'], $to) === false) $p['contacts'] .= '|'.$to;
    else
    {
      put_g_error ($to.' уже есть у вас в друзьях');
    }
  }
  if ($to == $LOGIN) put_g_error ($to.' уже есть у вас в друзьях');
  // dobavljaem kontakt
  do_mysql ("UPDATE players SET contacts = '".$p['contacts']."' WHERE id_player = '".$p['id_player']."';");
  $f = gen_header ('друзья');
  $f .= '<div class="y" id="kon7"><b>друзья:</b></div>';
  $f .= '<p>'.$to.' успешно добавлен к вам в друзья!<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>