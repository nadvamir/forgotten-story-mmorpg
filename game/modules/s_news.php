<?php
  //////////////////////////////// NOVOSTI vnutri igry /////////////////////////

  $f = gen_header ('новости');

  if (!isset ($_GET['start'])) $start = 0;
  else $start = preg_replace ('/[^-0-9]/', '', $_GET['start']);
  $show = 5;
  if (!$start) $start = 0;
  // qtotth zaprashivaem kolichestvo novostej
  $qtotth = mysql_query ("SELECT count(*) FROM news;", $dbcnx);
  $totth = mysql_result($qtotth,0);
  if ($start > $totth) $start = $totth - 3;

  if ($start < 0) $start = 0;

  $goto = $start + $show;
  if ($goto > $totth) $goto = $totth;

  $f .= '<div class="y" id="dgvdglhk"><b>новости: ('.$start.'-'.$goto.'/'.$totth.')</b></div><div class="n" id="wt743dt">';

  // proverka novyh novostej:
  if (!$start)
  {
    $q = do_mysql ("SELECT puttime FROM news WHERE puttime > '".$p['lastnews']."' ORDER BY puttime DESC;");
    if (mysql_num_rows ($q))
    {
      $pt = mysql_result ($q, 0);
      $p['lastnews'] = $pt;
      do_mysql ("UPDATE players SET lastnews = '".$p['lastnews']."' WHERE id_player = '".$p['id_player']."';");

    }
  }

  $qnew = "SELECT * FROM news ORDER BY puttime DESC LIMIT ".$start.", ".$show.";";
  $anew = mysql_query($qnew, $dbcnx);
  // poluchjaem vse dannye
  while ($new = mysql_fetch_assoc($anew))
  {
    $f .= '<b>'.$new['puttime'].'</b><br/>';
    $f .= ' - ';
    if (!file_exists ('modules/news/new_'.$new['id_new'].'.txt')) {mysql_query ("DELETE FROM news WHERE id_new = '".$new['id_new']."';", $dbcnx); $f .= '-<br/>'; continue; }
    $f .= file_get_contents ('modules/news/new_'.$new['id_new'].'.txt');
    $f .= '<br/>';
    $f .= '<small>добавил: <b>'.$new['author'].'</b></small><br/>';
  }

  $c = $totth;
  // teperq md'shnye ssylki dlja prosmotra
  $nw = floor ($c / $show);
  for ($i = 0; $i <= $nw; $i++)
  {
    if ($i * $show == $start) $f .= ($i + 1).' : ';
    elseif ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=news&start='.($i * $show).'">'.($i + 1).'</a> : ';
  }
  $f .= '<span class="gray">('.$c.')</span>';

  $f .= '<br/>&#187;<a class="black" href="game.php?sid='.$sid.'&action=mir_igry">мир игры</a><br/>';
  $f .= '&#187;<a class="black" href="game.php?sid='.$sid.'">в игру</a><br/>';
  $f .= '</div>';
  $f .= gen_footer();
  exit ($f);
?>