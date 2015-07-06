<?php
  // polozhitq v market veshq iz inventarja
  // veshq
  if (!isset ($_GET['to']))
  {
    // vybratq ee:
    include_once ('modules/f_list_inventory.php');
    $f = list_inventory ($LOGIN, 'i', 'put_to_market');
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=market">назад</a>';
    exit_msg ('выберите вещь', $f);
  }
  $item = preg_replace ('/[^a-z-0-9\._]/i', '', $_GET['to']);
  $q = do_mysql ("SELECT name, price, on_take FROM items WHERE fullname = '".$item."' AND is_in = 'inv' AND belongs = '".$LOGIN."';");
  if (!mysql_num_rows ($q)) put_g_error ('у вас нету этой вещи');
  $it = mysql_fetch_assoc ($q);

  if (!isset ($_GET['pprice']))
  {
    // ukazatq cenu nado:
    $f = $it['name'].': цена '.$it['price'].'<br/>';
    $f .= 'укажите продажную цену. Учитывайте, что если продаете например 100 стрел, указывайте цену ста стрел вместе взятых.<br/>';
    $f .= '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="put_to_market"/>';
    $f .= '<input type="hidden" name="to" value="'.$item.'"/>';
    $f .= '<input type="text" name="pprice" /><br/>';
    $f .= '<input type="submit" value="выставить!" />';
    $f .= '</form>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=put_to_market">назад</a>';
    exit_msg ('цена', $f);
  }
  $pprice = preg_replace ('/[^0-9]/', '', $_GET['pprice']);
  if (!$pprice) put_error ('вы продовать или дарить собрались?');

  // hvataet li mesta:
  $free = $p['settings'][7] * 2;
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'mar';");
  $c = mysql_result ($q, 0);
  if ($c >= $free) put_g_error ('нехватает места. зарезервируйте на прилавке его себе еще чуток.');

  // a teperq lozhim:
  $q = do_mysql ("UPDATE items SET is_in = 'mar', pprice = '".$pprice."' WHERE fullname = '".$item."';");

  $f = '<a class="blue" href="game.php?sid='.$sid.'&action=market">к прилавкам</a>';
  exit_msg ('выставленно', $f);
?>