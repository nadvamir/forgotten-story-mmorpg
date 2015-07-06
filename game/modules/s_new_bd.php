<?php
  // sozdatq novoe bd
  $num = preg_replace ('/[^0-9]/', '', $_GET['num']);
  if (!$num) $num = 0;
  if ($num > 9) $num = 9;
  if ($p['bd'][$num]) put_g_error ('слот занят');
  if (!isset($_GET['part']))
  {
    // vybratq chto dobavitq:
    $f = '<a class="blue" href="game.php?sid='.$sid.'&action=new_bd&part=1&bd=5&num='.$num.'">кастовать магию из книги магии</a><br/>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=new_bd&part=1&bd=6&num='.$num.'">кастовать магию по памяти</a><br/>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=new_bd&part=1&bd=7&num='.$num.'">использовать прием</a><br/>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=new_bd&part=1&bd=8&num='.$num.'">использовать свиток или особенную вешь</a><br/>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=new_bd&part=1&bd=9&num='.$num.'">использовать навык</a><br/>';
    $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=show_bd">бд</a><br/>';
    $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a>';
    exit_msg ('новое бд:', $f);
  }
  else if ($_GET['part'] == 1)
  {
    // teperq smotrja chto...
    if ($_GET['bd'] == 5)
    {
      $f = '';
      // vyvodim spisok magij knigi magii.
      if (!$p['mbook']) put_g_error ('вы неимеете книги');
      $q = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$p['mbook']."';");
      $mbk = mysql_result ($q, 0);
      $mbk = explode ('~', $mbk);
      $c = count ($mbk);
      for ($i = 0; $i < $c; $i++)
      {
        $q = do_mysql ("SELECT name FROM magic WHERE fullname = '".$mbk[$i]."';");
        $name = mysql_result ($q, 0);
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=new_bd&part=2&bd=5&num='.$num.'&spell='.$mbk[$i].'">'.$name.'</a><br/>';
      }
      $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=show_bd">бд</a><br/>';
      $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a>';
      exit_msg ('новое бд: книга магии', $f);
    }
    else if ($_GET['bd'] == 6)
    {
      $f = '';
      // vyvodim spisok magij
      if (!$p['magic_l']) put_g_error ('вы неумете магии');
      $c = count ($p['magic']);
      for ($i = 0; $i < $c; $i++)
      {
        $q = do_mysql ("SELECT name FROM magic WHERE fullname = '".$p['magic'][$i]."';");
        $name = mysql_result ($q, 0);
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=new_bd&part=2&bd=6&num='.$num.'&spell='.$p['magic'][$i].'">'.$name.'</a><br/>';
      }
      $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=show_bd">бд</a><br/>';
      $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a>';
      exit_msg ('новое бд: магия', $f);
    }
    else if ($_GET['bd'] == 7)
    {
      $f = '';
      // vyvodim spisok priemov
      if (!$p['kombo_l']) put_g_error ('вы неумете приемов');
      $c = count ($p['kombo']);
      include 'modules/sp/sp_kombonames.php';
      for ($i = 0; $i < $c; $i++)
      {
        $p['kombo'][$i] = explode (':', $p['kombo'][$i]);
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=new_bd&part=2&bd=7&num='.$num.'&kombo='.$p['kombo'][$i][0].'">'.$kn[$p['kombo'][$i][0]].'</a><br/>';
      }
      $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=show_bd">бд</a><br/>';
      $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a>';
      exit_msg ('новое бд: прием', $f);
    }
    else if ($_GET['bd'] == 8)
    {
      $f = '';
      include_once ('modules/f_list_inventory.php');
      $f .= list_inventory ($LOGIN, 'i.s.', 'new_bd&part=2&bd=8&num='.$num);
      //$f .= list_inventory ($LOGIN, 'i.f.dri', 'new_bd&part=2&bd=8&num='.$num);
      $f .= list_inventory ($LOGIN, 'i.q.que.', 'new_bd&part=2&bd=8&num='.$num);
      $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=show_bd">бд</a><br/>';
      $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a>';
      exit_msg ('новое бд: вещи', $f);
    }
    else if ($_GET['bd'] == 9)
    {
      $f = '';
      // vyvodim spisok navykov
      $c = count ($p['skills']);
      include 'modules/sp/sp_skillnames.php';

      for ($i = 4; $i < $c; $i++)
      {
        if (!$p['skills'][$i]) continue;
        if (file_exists ('modules/skills/sk_'.$i.'.php')) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=new_bd&part=2&bd=9&num='.$num.'&skill='.$i.'">'.$skn[$i].'</a><br/>';

      }
      $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=show_bd">бд</a><br/>';
      $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a>';
      exit_msg ('новое бд: навык', $f);
    }
  }
  else if ($_GET['part'] == 2)
  {
    if ($_GET['bd'] == 5)
    {
      $spell = preg_replace ('/[^a-z0-9_]/i', '', $_GET['spell']);
      $q = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$p['mbook']."';");
      $mbk = mysql_result ($q, 0);
      $mbk = explode ('~', $mbk);
      if (!is_in ($spell, $mbk)) put_error ('заклинание не найдено');
      $p['bd'][$num] = '5~'.$spell;
    }
    else if ($_GET['bd'] == 6)
    {
      $spell = preg_replace ('/[^a-z0-9_]/i', '', $_GET['spell']);
      if (!is_in ($spell, $p['magic'])) put_error ('заклинание не найдено');
      $p['bd'][$num] = '6~'.$spell;
    }
    else if ($_GET['bd'] == 7)
    {
      $kombo = preg_replace ('/[^a-z0-9_]/i', '', $_GET['kombo']);
      if (!is_in ($kombo, $p['kombo_l'])) put_error ('kombo не найдено');
      $p['bd'][$num] = '7~'.$kombo;
    }
    else if ($_GET['bd'] == 8)
    {
      $item = preg_replace ('/[^a-z0-9_\.\|]/i', '', $_GET['to']);
      $q = do_mysql ("SELECT realname FROM items WHERE fullname = '".$item."' AND belongs = '".$LOGIN."';");
      if (!mysql_num_rows ($q)) put_error ('вещь не найдена');
      $item = mysql_result ($q, 0);
      $p['bd'][$num] = '8~'.$item;
    }
    else if ($_GET['bd'] == 9)
    {
      $skill = preg_replace ('/[^0-9_]/i', '', $_GET['skill']);
      if (!$p['skills'][$skill]) put_error ('вы неумеете сего навыка');
      $p['bd'][$num] = '9~'.$skill;
    }
    $nbd = implode ('|', $p['bd']);
    do_mysql ("UPDATE players SET bd = '".$nbd."' WHERE id_player = '".$p['id_player']."';");
    $f = '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=show_bd">бд</a><br/>';
    $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">инвентарь</a>';
    exit_msg ('созданно!', $f);
  }
?>