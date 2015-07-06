<?php
  // vygnatq iz klana
  if ($p['clan'][0] && $p['clan'][1] > 6)
  {
    $f = '';
    if (isset ($_GET['to']))
    {
      // vygonjaem
      $to = preg_replace ('/[^a-z_0-9]/i', '', $_GET['to']);
      $id = is_player ($to);
      $q = do_mysql ("SELECT clan, stats FROM players WHERE id_player = '".$id."';");
      if (!mysql_num_rows ($q)) put_g_error ('нету такого игрока');
      $c = mysql_fetch_assoc ($q);
      $c['clan'] = explode ('|', $c['clan']);
      if ($c['clan'][0] != $p['clan'][0]) put_error ('это не ваш соклан');
      if ($c['clan'][1] == 7) put_g_error ('себя нелзя =)');
      // delaem:
      do_mysql ("UPDATE players SET clan = '' WHERE id_player = '".$id."';");
      $f .= '<u>вы выгнали игрока '.$to.' !</u><br/>';
    }
    // spisok soklanov, kotoryh mozhno vygnatq
    $q = do_mysql ("SELECT COUNT(*) FROM players WHERE clan LIKE '".$p['clan'][0]."%';");
    $c = mysql_result ($q, 0);
    $show = 10;
    if (!isset ($_GET['start'])) $start = 0;
    else $start = preg_replace ('/[^0-9]/', '', $_GET['start']);
    if ($start >= $c) $start = $c - $show;
    if ($start < 0) $start = 0;
    $to = $start + $show;
    if ($to > $c) $to = $c;
    $i = $start;
    $q = do_mysql ("SELECT login, stats, clan FROM players WHERE clan LIKE '".$p['clan'][0]."%' ORDER BY clan DESC LIMIT ".$start.", ".$show.";");
    while ($s = mysql_fetch_assoc ($q))
    {
      $s['stats'] = explode ('|', $s['stats']);
      $s['clan'] = explode ('|', $s['clan']);
      $f .= ($i + 1).'. <a class="red" href="game.php?sid='.$sid.'&action=seek_from_clan&to='.$s['login'].'&start='.$start.'">'.$s['login'].'</a> #'.$s['clan'][1].'<br/>';
      $i++;
    }
    // teperq md'shnye ssylki dlja prosmotra
    $nw = floor ($c / $show);
    for ($i = 0; $i <= $nw; $i++)
    {
      if ($i * $show == $start) $f .= ($i + 1).' : ';
      elseif ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=seek_from_clan&start='.($i * $show).'">'.($i + 1).'</a> : ';
    }
    $f .= '<span class="gray">('.$c.')</span>';
    exit_msg ('выгнать из клана:', $f);
  }
?>