<?php
  // izmenitq sajt klana:
  if ($p['clan'][0])
  {
    $f = '';
    $q = do_mysql ("SELECT money FROM clans WHERE clanname = '".$p['clan'][0]."';");
    $money = mysql_result ($q, 0);
    if (isset ($_GET['sum']))
    {
      // menjaem:
      $sum = preg_replace ('/[^0-9]/', '', $_GET['sum']);
      if ($sum > $p['money']) put_g_error ('нельзя положить больше чем имеешь');
      $money += $sum;
      $p['money'] -= $sum;
      do_mysql ("UPDATE clans SET money = '".$money."' WHERE clanname = '".$p['clan'][0]."';");
      do_mysql ("UPDATE players SET money = '".$p['money']."' WHERE id_player = '".$p['id_player']."';");
      $q = do_mysql ("SELECT login FROM players WHERE clan LIKE '".$p['clan'][0]."%';");
      $to = '';
      while ($tmp = mysql_fetch_assoc ($q)) $to .= $tmp['login'].'|';
      add_journal ('[green][clan]'.$p['name'].' вложил в казну '.$sum.' серебра![/end]', $to);
    }

    $f .= 'на счету клана: '.$money.' серебром<br/>';
    $f .= 'у вас же: '.$p['money'].'<br/>';

    // forma izmenenija
    $f .= '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="clan_donate"/>';
    $f .= 'сумма:<br/><input type="text" name="sum"/><br/>';
    $f .= '<input type="submit" value="вложить"/>';
    $f .= '</form>';
    exit_msg ('казна', $f);
  }
?>