<?php
  // nastroiki
  $f = gen_header ('настройки');
  $f .= '<div class="y" id="oa"><b>настройки:</b></div>';
  $f .= '<p>';

  $f .= 'события: ';
  if ($p['settings'][3] == 1) $f .= '+ | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=journal&set=0">-</a><br/>';
  else $f .= '<a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=journal&set=1">+</a> | -<br/>';

  $f .= 'инфо карт: ';
  if ($p['settings'][4] == 1) $f .= '+ | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=mapinfo&set=0">-</a><br/>';
  else $f .= '<a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=mapinfo&set=1">+</a> | -<br/>';

  $f .= 'стрелки: ';
  if ($p['settings'][6] == 1) $f .= '+ | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=daynight&set=0">-</a><br/>';
  else $f .= '<a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=daynight&set=1">+</a> | -<br/>';

  $f .= 'переходы: ';
  if ($p['settings'][2] == 0) $f .= 'мин | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=locmode&set=1">ЗИ</a> | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=locmode&set=2">ПГ</a><br/>';
  else if ($p['settings'][2] == 1) $f .= 'ЗИ | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=locmode&set=0">мин</a> | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=locmode&set=2">ПГ</a><br/>';
  else $f .= 'ПГ | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=locmode&set=1">ЗИ</a> | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=locmode&set=0">мин</a><br/>';

  $f .= 'бд: ';
  if ($p['settings'][8] == 1) $f .= '+ | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=bd&set=0">-</a><br/>';
  else $f .= '<a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=bd&set=1">+</a> | -<br/>';

  $f .= 'инвентарь: ';
  if ($p['settings'][9] == 1) $f .= 'весь | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=invtab&set=0">вкладки</a><br/>';
  else $f .= '<a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=invtab&set=1">весь</a> | вкладки<br/>';

  $f .= '<a class="red" href="game.php?sid='.$sid.'&action=change_pass">сменить пароль</a><br/>';

  // poka hvatit
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">в инвентарь</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>