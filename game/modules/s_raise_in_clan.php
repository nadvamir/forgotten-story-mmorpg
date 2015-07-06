<?php
  // podnjatq v klane
  if ($p['clan'][0] && $p['clan'][1] > 6)
  {
    $f = '';
    if (isset ($_GET['to']))
    {
      // podnimaem:
      $to = preg_replace ('/[^a-z_0-9]/i', '', $_GET['to']);
      $id = is_player ($to);
      $q = do_mysql ("SELECT clan, stats FROM players WHERE id_player = '".$id."';");
      if (!mysql_num_rows ($q)) put_g_error ('нету такого игрока');
      $c = mysql_fetch_assoc ($q);
      $c['stats'] = explode ('|', $c['stats']);
      $c['clan'] = explode ('|', $c['clan']);
      if ($c['clan'][0] != $p['clan'][0]) put_error ('это не ваш соклан');
      if ($c['clan'][1] > 5) put_error ('вы неможете тут сделать соклана Лордом');

      if ($c['stats'][0] == $c['clan'][1]) put_error ('нелзя занимать позицию выше своего уровня');
      // delaem:
      do_mysql ("UPDATE players SET clan = '".$c['clan'][0]."|".($c['clan'][1] + 1)."' WHERE id_player = '".$id."';");
      $f .= '<i>вы повысили игрока '.$to.' до клановой должности #'.($c['clan'][1] + 1).'</i><br/>';
    }
    // spisok soklanov, kotoryh mozhno povysitq.
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
      if ($s['clan'][1] > 5 || $s['stats'][0] == $s['clan'][1]) $f .= ($i + 1).'. '.$s['login'].' #'.$s['clan'][1].'<br/>';
      else $f .= ($i + 1).'. <a class="blue" href="game.php?sid='.$sid.'&action=raise_in_clan&to='.$s['login'].'&start='.$start.'">'.$s['login'].'</a> #'.$s['clan'][1].'<br/>';
      $i++;
    }
    // teperq md'shnye ssylki dlja prosmotra
    $nw = floor ($c / $show);
    for ($i = 0; $i <= $nw; $i++)
    {
      if ($i * $show == $start) $f .= ($i + 1).' : ';
      elseif ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=raise_in_clan&start='.($i * $show).'">'.($i + 1).'</a> : ';
    }
    $f .= '<span class="gray">('.$c.')</span>';
    exit_msg ('повысить в клане:', $f);
  }
?>