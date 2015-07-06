<?php
  // forma sozdanija foruma
  if ($p['admin'] > 1)
  {
    $f = gen_header ('новая новость');
    $f .= '<div class="y" id="cfpor"><b>создать новость:</b></div><div class="n" id="gsd">';
    $f .= '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="add_new2"/>';
    $f .= 'новость: <br/> <textarea name="name" rows="5" cols="32"></textarea><br/>';
    $f .= '<input type="submit" value="создать"/></form>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></div>';
    $f .= gen_footer();
    exit ($f);
  }
?>