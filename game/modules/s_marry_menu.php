<?php
  if ($p['marry'])
  {
    $f = '';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=teleport2spouse">телепортироватся</a>';
    exit_msg ('вторая половинка', $f);
  }
  else put_g_error ('холостые вон отсюда!!!');
?>