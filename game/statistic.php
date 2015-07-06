<?php
  // statistika
  require_once ('modules/config.php');
  require_once ('modules/f_defend.php');
  defend();
  require_once ('site_header.php');
  require_once ('site_footer.php');
  $f = gen_sheader ('Забытая История');
  $f .= '<div class="y" id="fdfdg">';
  $f .= 'Статистика:</div>';
  $qco = mysql_query ("SELECT COUNT(*) FROM session;", $dbcnx);
  $co = mysql_result ($qco, 0);
  $f .= '<div class="n" id="wt743t">';
  $f .= 'Онлайн: <a class="blue" href="online.php">'.$co.'</a><br/>';
  $qcp = mysql_query ("SELECT COUNT(*) FROM players;", $dbcnx);
  $cp = mysql_result ($qcp, 0);
  $f .= 'Количество игроков: '.$cp.'<br/>';
  ////////////////////////////
  $f .= 'Количество нпц: <br/>';
  $f .= '-Говорящих: 43<br/>';
  $f .= '-Мирных: 18 разновидностей<br/>';
  $f .= '-Монстров: 123 разновидности<br/>';
  $f .= 'Количество вешей: <br/>';
  $f .= '-Оружия: 6380<br/>'; // +5 tipa kirqki udochki
  $f .= '-Брони: 5370<br/>';
  $f .= '-Щитов: 1875<br/>';
  $f .= '-Возможных отваров: 1892<br/>';
  $f .= '-Алхимических формул: 80<br/>';
  $f .= 'Количество городов: 1<br/>';
  $f .= 'Количество квестов: 2 случайных, 2 одноразовых, 3главы<br/>';
  $q = mysql_query ("SELECT COUNT(*) FROM magic;", $dbcnx);
  $c = mysql_result ($q, 0);
  $f .= 'Количество заклинаний: '.$c.'<br/>';
  ///////////////////////////
  $f .= '<a class="blue" href="index.php">на главную</a></div>';
  $f .= gen_sfooter();
  exit($f);
?>