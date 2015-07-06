<?php
  // funkcija chinit ukazanuju veshq
  function repair_item ($item, $login, $self = 0)
  {
    include_once ('modules/f_get_max_str.php');
    $strm = get_max_str ($item);
    if (!$strm) $strm = 1;
    $q = do_mysql ("SELECT str, price FROM items WHERE fullname = '".$item."' AND belongs = '".$login."';");
    if (!mysql_num_rows ($q)) put_error ('нема вещи '.$item);
    $i = mysql_fetch_assoc ($q);
    if (!$self)
    {
      $id = is_player ($login);
      $q = do_mysql ("SELECT money FROM players WHERE id_player = '".$id."'");
      $money = mysql_result ($q, 0);
      if (!$i['str']) $i['str'] = 1;
      $cost = round ($i['price'] * $i['str'] / $strm);
      if ($money < $cost) put_g_error ('нехватает серебра, надо '.$cost);
      $money -= $cost;
      do_mysql ("UPDATE players SET money = '".$money."' WHERE id_player = '".$id."';");
    }
    else
    {
      // chinim samostojatelqno, self navyk
      $cost = $self * 20;
      $i['str'] += $cost;
      if ($i['str'] < $strm) $strm = $i['str'];
    }
    do_mysql ("UPDATE items SET str = '".$strm."' WHERE fullname = '".$item."';");
    return $cost;
  }
?>