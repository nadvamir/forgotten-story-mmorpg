<?php
  // onlain
  $f = gen_header ('Забытая История');
  $qco = mysql_query ("SELECT COUNT(*) FROM session;", $dbcnx);
  $on = mysql_result ($qco, 0);
  $f .= '<div class="y" id="fdfdg">';
  $f .= 'Oнлайн '.$on.':</div>';
  // pokaz
  $num = 10;
  //--
  // ishem start v GET
  if (!isset ($_GET['start'])) $start = 0;
  else $start = preg_replace('/[^0-9]/', '', $_GET['start']);
  if ($start > $on)
  {
    $start = $on - $num;
  }
  // menqshe nulja bytq nemozhet
  if ($start < 0)
  {
    $start = 0;
  }
  //--
  // imena onlajn
  $qno = "SELECT login, ip FROM session LIMIT ".$start.", ".$num.";";
  $ano = mysql_query($qno, $dbcnx);
  if (!$ano)
  {
    exit("<p>could not connect to mysql to get online...</p>");
  }
  // vyvedem na ekran
  $f .= '<p>';
  while ($uon = mysql_fetch_assoc($ano))
  {
    $id = is_player ($uon['login']);
    $q = do_mysql ("SELECT name, stats, clan FROM players WHERE id_player = '".$id."';");
    $u = mysql_fetch_assoc ($q);
    $u['stats'] = explode ('|', $u['stats']);
    $f .= $u['stats'][0].' ';
    $f .= '<b>'.$u['name'].'</b> ';
    if ($u['clan'])
      $f .= '<small>*'.(substr ($u['clan'], 0, (strpos ($u['clan'], '|')))).'*</small> ';
    $q = do_mysql ("SELECT is_in FROM fonline WHERE login = '".$uon['login']."';");
    if (mysql_num_rows ($q)) $f .= '<small>на форуме</small>';
    $f .= '<br/>';
    if ($p['admin'] > 0)
    {
      $q = do_mysql ("SELECT location FROM players WHERE id_player = '".$id."';");
      $luon = mysql_result ($q, 0);
      $f .= $uon['login'].'<br/> - <small>IP: '.$uon['ip'].';</small><br/> -<small> loc: '.$luon.'</small><br/>';
    }
  }
  $f .= '</p>';
  //--
  // listanie
  $f .= '<div class="y" id="iy">';
  if ($start > 0)
  {
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=online&start='.($start - $num).'">';
    $f .= '&#171;</a>';
  }
  else
  {
    $f .= '&#171;';
  }
  $f .= ' | ';
  if ($on > $start + $num)
  {
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=online&start='.($start + $num).'">';
    $f .= '&#187;</a>';
  }
  else
  {
    $f .= '&#187;';
  }
  $f .= '</div>';
  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'&action=showinventory">в инвентарь</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  die ($f);
?>