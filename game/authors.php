<?php
  // autory
  require_once ('modules/config.php');
  require_once ('modules/f_defend.php');
  require_once ('site_header.php');
  require_once ('site_footer.php');
  defend();
  $f = gen_sheader ('Забытая История');
  $f .= '<div class="y" id="fdfdg">';
  $f .= 'Авторы:</div><div class="n" id="wt743t">';
  $f .= '<b>Движек:</b><br/>';
  $f .= '_himura_<br/>';
  $f .= '<b>Вещи:</b><br/>';
  $f .= 'Sandam<br/>';
  $f .= '<b>Разработка мира:</b><br/>';
  $f .= '_himura_, Sandam, Lord_Smit<br/>';
  $f .= '<a class="blue" href="index.php">на главную</a></div>';
  $f .= gen_sfooter();
  exit ($f);
?>