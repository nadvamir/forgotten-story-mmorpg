<?php
  // podatq zajavku v klan:
  if ($p['admin'] > 0)
  {
    $f = '<pre>';
    if (file_exists ('modules/posts/newmagic.txt')) $f .= file_get_contents ('modules/posts/newmagic.txt');
    if (file_exists ('modules/posts/newscrolls.txt')) $f .= file_get_contents ('modules/posts/newscrolls.txt');
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=moder">модераторская</a>';
    exit_msg ('новая магия', $f);
  }
?>