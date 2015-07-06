<?php
  // ispolqzovatq tjuremnyj kamenq
  $q = do_mysql ("SELECT id_item FROM items WHERE fullname = '".$item."';");
  $id_item = mysql_result ($q, 0);
  if ($id_item % 3 == 0) $ch = 15;
  elseif ($id_item % 2 == 0) $ch = 10;
  else $ch = 5;
  if (substr($p['weapon'], 0, 11) == 'i.w.axe.kir') $ch *= 2;
  if (rand (0, 100) <= $ch)
  {
    // poluchaem zoloto;
      include_once ('modules/f_gain_item.php');
      gain_item ('i.q.que.goldpiece', 1, $LOGIN);
  }
  else
  {
    // poluchaem granit;
    exit_msg ('камнеломня', 'Вы отломали куcок камня!');
  }
?>