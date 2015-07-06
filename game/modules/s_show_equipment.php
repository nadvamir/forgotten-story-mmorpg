<?php
  // pokazyvaet inventarq
  // i informaciju igroka
  // na vsjakij sluchaj :
  include_once ('modules/f_get_it_name.php'); // nazvanie
  $f = gen_header ('игрок');

  // oruzhie 
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wea';");
  if (mysql_num_rows ($q))
  {
    $w = mysql_fetch_assoc ($q);
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
    $f .= '<div class="y" id="laiyeg"><b>оружие:</b></div><p>';
    $f .= '<a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
    $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=change_weapon">v</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a></p>';
  }

  // na pojase:
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wst';");
  $q2 = do_mysql ("SELECT fullname, name, on_take FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'pot';");
  if (mysql_num_rows ($q) || mysql_num_rows ($q2))
    $f .= '<div class="y" id="laiyeg"><b>на поясе:</b></div><p>';
  if (mysql_num_rows ($q))
  {
    $w = mysql_fetch_assoc ($q);
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'black';
    $f .= '<span class="'.$qua.'">'.$w['name'].'</span> : <a class="blue" href="game.php?sid='.$sid.'&action=change_weapon">^</a> : <a class="blue" href="game.php?sid='.$sid.'&action=put_from_belt">v</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a></p>';
    $wst = 1;
  }
  if (mysql_num_rows ($q2))
  {
    $f .= '<p>';
    while ($pot = mysql_fetch_assoc ($q2))
    {
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_item&item='.$pot['fullname'].'">';
      $f .= $pot['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=take_food_from&food='.$pot['fullname'].'">v</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a><br/>';
    }
    $f .= '</p>';
  }  

  // wit:
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'shi';");
  if (mysql_num_rows ($q))
  {
    $w = mysql_fetch_assoc ($q);
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
    if (substr ($w['fullname'], 2, 1) == 'x')
    {
      $f .= '<div class="y" id="laiyeg"><b>щит:</b></div><p>';
      $f .= '<a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a></p>';
    }
    else
    {
      $f .= '<div class="y" id="laiyeg"><b>второе оружие:</b></div><p>';
      $f .= '<a class="'.$qua.'" href="game.php?sid='.$sid.'&action=take_2w&weapon='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a></p>';
    }
  }

  $f .= '<div class="y" id="laiyeg"><b>броня:</b></div><p>';
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a0';");
  if (mysql_num_rows ($q))
  {
    while ($w = mysql_fetch_assoc ($q))
    {
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= 'шлем: <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a><br/>';
    }
  }
  else $f .= 'шлем: пусто<br/>';
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a1';");
  if (mysql_num_rows ($q))
  {
    while ($w = mysql_fetch_assoc ($q))
    {
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= 'доспех: <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a><br/>';
    }
  }
  else $f .= 'доспех: пусто<br/>';
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a2';");
  if (mysql_num_rows ($q))
  {
    while ($w = mysql_fetch_assoc ($q))
    {
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= 'рубаха: <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a><br/>';
    }
  }
  else $f .= 'рубаха: пусто<br/>';
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a3';");
  if (mysql_num_rows ($q))
  {
    while ($w = mysql_fetch_assoc ($q))
    {
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= 'наплечники: <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a><br/>';
    }
  }
  else $f .= 'наплечники: пусто<br/>';
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a4';");
  if (mysql_num_rows ($q))
  {
    while ($w = mysql_fetch_assoc ($q))
    {
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= 'пeрчaтки: <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a><br/>';
    }
  }
  else $f .= 'перчaтки: пусто<br/>';
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a5';");
  if (mysql_num_rows ($q))
  {
    while ($w = mysql_fetch_assoc ($q))
    {
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= 'пояс: <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a><br/>';
    }
  }
  else $f .= 'пояс: пусто<br/>';
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a6';");
  if (mysql_num_rows ($q))
  {
    while ($w = mysql_fetch_assoc ($q))
    {
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= 'штаны: <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a><br/>';
    }
  }
  else $f .= 'штаны: пусто<br/>';
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a7';");
  if (mysql_num_rows ($q))
  {
    while ($w = mysql_fetch_assoc ($q))
    {
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= 'поножи: <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a><br/>';
    }
  }
  else $f .= 'поножи: пусто<br/>';
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a8';");
  if (mysql_num_rows ($q))
  {
    while ($w = mysql_fetch_assoc ($q))
    {
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= 'ботинки: <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a><br/>';
    }
  }
  else $f .= 'ботинки: пусто<br/>';
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a9';");
  if (mysql_num_rows ($q))
  {
    while ($w = mysql_fetch_assoc ($q))
    {
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= 'амулет: <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a><br/>';
    }
  }
  else $f .= 'амулет: пусто<br/>';
  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a10';");
  if (mysql_num_rows ($q))
  {
    while ($w = mysql_fetch_assoc ($q))
    {
      $qua = substr ($w['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= 'кольцо: <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$w['fullname'].'">';
      $f .= $w['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$w['fullname'].'">?</a><br/>';
    }
  }
  else $f .= 'кольцо: пусто<br/>';
  $f .= '</p>';

  $q = do_mysql ("SELECT fullname, name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'mbk';");
  if (mysql_num_rows ($q))
  {
    $b = mysql_fetch_assoc ($q);
    // kniga magii:
    $f .= '<div class="y" id="laify"><b>книга магии:</b></div><p>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_item&item='.$b['fullname'].'">';
    $f .= $b['name'].'</a> : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$b['fullname'].'">?</a>';
    $f .= ' : <a class="blue" href="game.php?sid='.$sid.'&action=take_mbook_to&book='.$b['fullname'].'">v</a></p>';
  }

  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>