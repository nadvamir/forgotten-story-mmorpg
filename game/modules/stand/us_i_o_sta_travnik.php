<?php
  // stolik archimaga:
  $f = gen_header ('Целительство');
  $f .= '<div class="y" id="lqitr"><b>Столик Целителя:</b></div><p>';
  if (!$p['skills'][6]) put_g_error ('Вы неумеете пользоватся столиком!');
  $f .= '-<a class="blue" href="game.php?sid='.$sid.'&action=make_otv">';
  $f .= 'сварить отвар</a><br/>';
  $f .= '-<a class="blue" href="game.php?sid='.$sid.'&action=cut_grass">';
  $f .= 'измелчить траву</a><br/>';

  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
  $f .= '</p>';
  $f .= gen_footer ();
  exit ($f);
?>