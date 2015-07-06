<?php
  // onlain
  require_once ('modules/config.php');
  require_once ('modules/f_defend.php');
  defend();
  require_once ('site_header.php');
  require_once ('site_footer.php');
  $f = gen_sheader ('Забытая История');
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
  $qno = "SELECT login FROM session LIMIT ".$start.", ".$num.";";
  $ano = mysql_query($qno, $dbcnx);
  if (!$ano)
  {
    exit("<p>could not connect to mysql to get online...</p>");
  }
  // vyvedem na ekran
  $f .= '<div class="n" id="wt743t">';
  while ($uon = mysql_fetch_assoc($ano))
  {
    $q = mysql_query ("SELECT name FROM players WHERE login = '".$uon['login']."';");
    $uon['login'] = mysql_result ($q, 0);
    $f .= $uon['login'].'<br/>';
  }
  $f .= '</div>';
  //--
  // listanie
  $f .= '<div class="y" id="iy">';
  if ($start > 0)
  {
    $f .= '<a class="blue" href="online.php?start='.($start - $num).'">';
    $f .= '&#171;</a>';
  }
  else
  {
    $f .= '&#171;';
  }
  $f .= ' | ';
  if ($on > $start + $num)
  {
    $f .= '<a class="blue" href="online.php?start='.($start + $num).'">';
    $f .= '&#187;</a>';
  }
  else
  {
    $f .= '&#187;';
  }
  $f .= '</div>';
  $f .= '<div class="n" id="wat743t"><a class="blue" href="index.php">на главную</a></div>';
  $f .= gen_sfooter();
  exit ($f);
?>