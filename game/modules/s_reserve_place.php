<?php
  // uvelichitq mesto pod veshi na prilavke
  // hranitsja v settings (7)
  if (!isset ($_GET['yes']))
  {
    $place = $p['settings'][7] * 2;
    if ($place == 14) put_g_error ('больше нелзя');
    // skolqko zanjato:
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'mar';");
    $c = mysql_result ($q, 0);
    $f .= 'занято '.$c.' из '.$place.' зарезервированных мест<br/>';
    $f .= 'зарезервировать еще 2 места будет стоить ';
    $cost = 10;
    for ($i = 1; $i < $p['settings'][7] + 1; $i++) $cost *= 10;
    $f .= $cost.' серебренных<br/>';
    $f .= '<a class="red" href="game.php?sid='.$sid.'&action=reserve_place&yes=1">увеличить</a>?';
    exit_msg ('увеличить место', $f);
  }
  else
  {
    if ($p['settings'][7] > 6) put_g_error ('больше нелзя');
    $cost = 10;
    for ($i = 1; $i < $p['settings'][7] + 1; $i++) $cost *= 10;
    if ($p['money'] < $cost) put_g_error ('нету денег стольки');
    $p['money'] -= $cost;
    $t = $p['settings'][7];
    $t = $t + 1;
    $p['settings'][7] = $t;
    do_mysql ("UPDATE players SET money = '".$p['money']."', settings = '".$p['settings']."' WHERE id_player = '".$p['id_player']."';");
    exit_msg ('увеличение', 'увеличенно!');
  }
?>