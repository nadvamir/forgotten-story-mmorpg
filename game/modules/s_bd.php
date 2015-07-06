<?php
  // BYSTRYE DEJSTVIJA:
  if (!isset ($_GET['bd'])) put_g_error ('а где номер то?');
  $bd = preg_replace ('/[^0-9]/', '', $_GET['bd']);
  if ($bd < 4)
  {
    // razlichnaja ataka. 
    $mas = array (0 => 'rez', 1 => 'kol', 2 => 'drob', 3 => 'rub');
    $_GET['type'] = $mas[$bd];
    $action = 'do_dmg';
  }
  else
  {
    $bd -= 4; // dlja dalqnejshego poiska v massive:
    if (!$p['bd'][$bd]) put_g_error ('этот слот не используется!');
    $p['bd'][$bd] = explode ('~', $p['bd'][$bd]);
    if ($p['bd'][$bd][0] == 5)
    {
      // magija iz knigi, 1 - zakl.
      // $p['mbook'] uzhe estq v get_pl_info
      if (!$p['mbook']) put_g_error ('возьмите книгу магии');
      $q = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$p['mbook']."';");
      $mbk = mysql_result ($q, 0);
      $mbk = explode ('~', $mbk);
      if (!is_in ($p['bd'][$bd][1], $mbk)) put_g_error ('в книге магии этого закла нету.');
      $action = 'cast_from_book';
      $_GET['spell'] = $p['bd'][$bd][1];
      $_GET['book'] = $p['mbook'];
    }
    else if ($p['bd'][$bd][0] == 6)
    {
      // magija po pamjati:
      if (!is_in ($p['bd'][$bd][1], $p['magic'])) put_g_error ('вы незнаете этого заклинания.');
      $action = 'cast_from_head';
      $_GET['spell'] = $p['bd'][$bd][1];
    }
    else if ($p['bd'][$bd][0] == 7)
    {
      // kombo:
      if (!is_in ($p['bd'][$bd][1], $p['kombo_l'])) put_g_error ('откуда вы выдрали, что то комбо вам доступно?');
      $action = 'use_kombo';
      $_GET['kombo'] = $p['bd'][$bd][1];
    }
    else if ($p['bd'][$bd][0] == 8)
    {
      // ispolqzovatq svitok ili q veshq.
      // 1 - eto real name, po nemu nado otsleditq snachalo nastojashee imja, a potom use_item
      $q = do_mysql ("SELECT fullname FROM items WHERE realname = '".$p['bd'][$bd][1]."' AND belongs = '".$LOGIN."' AND is_in = 'inv';");
      if (!mysql_num_rows ($q)) put_g_error ('все эгземпляры этой веши у вас закончились');
      $_GET['item'] = mysql_result ($q, 0);
      $action = 'use_item';
    }
    else if ($p['bd'][$bd][0] == 9)
    {
      // ispolqzovatq navyk
      $action = 'use_skill';
      $_GET['skill'] = $p['bd'][$bd][1];
    }
  }
  $WASBD = 1;
?>