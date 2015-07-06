<?php
  for ($i = 0; $i < $cc; $i++)
  {
    $q = do_mysql ("SELECT id_item FROM items WHERE belongs = '".$INL_D[$i]['fullname']."' LIMIT 1;");
    if (mysql_num_rows ($q))
    {
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=take_dead&dead='.$INL_D[$i]['fullname'].'">';
      $f .= $INL_D[$i]['name'].'</a>';
    }
    else
      $f .= $INL_D[$i]['name'];
    if ($INL_D[$i]['hunt']) $f .= ' <a class="blue" href="game.php?sid='.$sid.'&action=osvezh&dead='.$INL_D[$i]['fullname'].'">></a>';
    $f .= '<br/>';
  }
?>