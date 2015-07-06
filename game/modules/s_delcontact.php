<?php
  // udalenie starogo druga :(
  $to = preg_replace ('/[^a-z0-9_]/i', '', $_GET['to']);
  // zapros, estq li voobshe takoj...
  //$id = is_player ($to);
  //if (!$id) put_error ('нету такого игрока для контактов');
  // proverka, net li takogo v kontaktah
  if (!$p['contacts']) put_error ('ваши контакты пусты');
  else
  {
    if (strpos ($p['contacts'], $to) === false) put_error ('такого в контактах нет');
    else
    {
      // nado udalitq
      if ($p['contacts'] == $to) $p['contacts'] = '';
      else
      {
        $p['contacts'] = str_replace ('|'.$to, '', $p['contacts']);
        $p['contacts'] = str_replace ($to.'|', '', $p['contacts']);
      }
    }
  }
  // udaljaem kontakt
  do_mysql ("UPDATE players SET contacts = '".$p['contacts']."' WHERE id_player = '".$p['id_player']."';");
  $f = gen_header ('друзья');
  $f .= '<div class="y" id="kon7"><b>друзья:</b></div>';
  $f .= '<p>'.$to.' успешно удален из друзей!<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>