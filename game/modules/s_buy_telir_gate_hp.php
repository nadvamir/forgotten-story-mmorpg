<?php
  // ukrepitq dveri telita
  if ($p['clan'][0])
  {
    $q = do_mysql ("SELECT belongs FROM castle WHERE name = 'telir';");
    $bel = mysql_result ($q, 0);
    $q = do_mysql ("SELECT doorhp FROM castle WHERE name = 'telir';");
    $doorhp = mysql_result ($q, 0);
    if ($bel != $p['clan'][0]) put_g_error ('Телир не ваш');
    if ($p['clan'][1] < 7) put_g_error ('только глава может принимать такие важные решения');
    $f = '';
    $q = do_mysql ("SELECT money FROM clans WHERE clanname = '".$p['clan'][0]."';");
    $money = mysql_result ($q, 0);
    if (isset ($_GET['sum']))
    {
      // menjaem:
      $sum = preg_replace ('/[^0-9]/', '', $_GET['sum']);
      if ($sum > $money) put_g_error ('нельзя дать больше чем имеешь');
      $money -= $sum;
      $doorhp += $sum * 10;
      do_mysql ("UPDATE clans SET money = '".$money."' WHERE clanname = '".$p['clan'][0]."';");
      do_mysql ("UPDATE castle SET doorhp = '".$doorhp."' WHERE name = 'telir';");
    }

    $f .= 'на счету клана: '.$money.' серебром<br/>';
    $f .= 'ворота могут выдержать удар в '.$doorhp.'<br/>';
    $f .= 'за 1 серебренный можно купить стройматериалов, которые укреплят ворота на 10. Поставщик все установит. <br/>';

    // forma izmenenija
    $f .= '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="buy_telir_gate_hp"/>';
    $f .= 'сумма:<br/><input type="text" name="sum"/><br/>';
    $f .= '<input type="submit" value="купить"/>';
    $f .= '</form>';
    exit_msg ('ворота Телира', $f);
  }
?>