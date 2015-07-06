<?php
  //////////////////////////////// NOVOSTI /////////////////////////

  if (isset ($_GET['sid'])) // VYRUBLENNO
  {
    $sid = mysql_real_escape_string ($_GET['sid']);
    include 'modules/autorize.php';
  }

  include_once ('modules/config.php');
  include_once ('site_header.php');
  include_once ('site_footer.php');
  $f = gen_sheader ('новости');

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
    elseif ($i * $show < $c) $f .= '<a class="blue" href="news.php?start='.($i * $show).'">'.($i + 1).'</a> : ';
  }
  $f .= '<span class="gray">('.$c.')</span>';

  if (isset ($sid)) $f .= '&#187;<a class="black" href="game.php?sid='.$sid.'">в игру</a><br/>';
  $f .= '<br/>&#187;<a class="black" href="index.php">на главную</a>';
  $f .= '</div>';
  $f .= gen_sfooter();
  exit ($f);
?>