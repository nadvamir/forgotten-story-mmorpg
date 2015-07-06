<?php
  // stolik archimaga:
  $f = gen_header ('Архимагия');
  $f .= '<div class="y" id="lqitr"><b>Столик Архимага:</b></div><p>';
  if (!$p['skills'][30]) put_g_error ('Вы неумеете пользоватся столиком!');
  $f .= '-<a class="blue" href="game.php?sid='.$sid.'&action=put_sc_to">';
  $f .= 'добавить в книгу свиток</a><br/>';
  $f .= '-<a class="blue" href="game.php?sid='.$sid.'&action=put_sc_from">';
  $f .= 'вытащить свиток из книги</a><br/>';
  $f .= '-<a class="blue" href="game.php?sid='.$sid.'&action=clone_scroll">';
  $f .= 'переписать свиток</a><br/>';
  $f .= '-<a class="blue" href="game.php?sid='.$sid.'&action=create_scroll">';
  $f .= 'создать свиток</a><br/>';
  $f .= '-<a class="blue" href="game.php?sid='.$sid.'&action=create_effect">';
  $f .= 'наложить эффект</a><br/>';

  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
  $f .= '</p>';
  $f .= gen_footer ();
  exit ($f);
?>