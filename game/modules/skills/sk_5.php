<?php
  // skript ispolqzovanija regeneracii:
  $lp = rand(0, $p['skills'][5]) * $p['skills'][0];
  $p['life'][0] += $lp;
  if ($p['life'][0] > $p['life'][1]) $p['life'][0] = $p['life'][1];
  $nlife = $p['life'][0].'|'.$p['life'][1];
  add_journal ('жизнь +'.$lp.'!', $LOGIN);
  // zalechivanie ran -
  $pp = $p['skills'][5] * 10;
  if (rand(0, 100) <= $pp && $p['status1'][2] == 1)
  {
    $p['status1'][2] = 0;
    add_journal ('ваши раны зажили!', $LOGIN);
  }
  do_mysql ("UPDATE players SET life = '".$nlife."', status1 = '".$p['status1']."' WHERE id_player = '".$p['id_player']."';");
?>