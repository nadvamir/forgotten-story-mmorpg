<?php
  // stol skornjaka
  $arr['i.a.bel'] = 'modules/items/items_a/items_a_bel.php';
  $arr['i.a.leg'] = 'modules/items/items_a/items_a_leg.php';
  $arr['i.a.bo2'] = 'modules/items/items_a/items_a_bo2.php';
  $arr['i.a.glo'] = 'modules/items/items_a/items_a_glo.php';
  $arr['i.a.bot'] = 'modules/items/items_a/items_a_bot.php';

  // esli netu nikakogo dejstvija
  $f = '';
  do_mysql ("DELETE FROM furrer WHERE puttime < NOW() - INTERVAL '10' MINUTE;");
  $q = do_mysql ("SELECT * FROM furrer WHERE id_player = '".$p['id_player']."';");

  if (!mysql_num_rows ($q))
  {
    // poka chto nechego vybiratq
    /*if (!$_GET['part'])
    {
      // vyberaem chto delatq
      $f .= '<b>выберите что делать:</b><br/>';
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=2&what=i.a">броню</a><br/>';
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.x.shi">щит</a>';
    }
    else if ($_GET['part'] == 2)
    {
      if ($_GET['what'] == 'i.w')
      {
        $f .= '<b>а конкретнее?</b><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.w.arb">арбалет</a><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.w.bow">лук</a><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.w.tre">посох/дубину</a>';
      }
    }*/
    if (!isset ($_GET['part']))
    {
      $f .= '<b>выберите что делать:</b><br/>';
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.a.bel">пояс</a><br/>';
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.a.bo2">рубаху</a><br/>';
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.a.leg">штаны</a><br/>';
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.a.glo">перчатки</a><br/>';
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.a.bot">ботинки</a>';
    }
    else if ($_GET['part'] == 3)
    {
      if (!array_key_exists ($_GET['what'], $arr)) put_error ('несовпадают индексы');
      unset ($it);
      include $arr[$_GET['what']];
      unset ($items);
      $f .= '<b>какую вешь?</b><br/>';
      $sklim = $p['skills'][42];
      if ($sklim > 12) $sklim = 12 + ($p['skills'][42] - 12) / 2;
      foreach ($it as $key => $val)
        if (say_level ($key) <= $sklim)
        {
          $val = explode ('|', $val);
          $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=4&what='.$key.'">'.$val[0].'</a><br/>';
        }
    }
    else if ($_GET['part'] == 4)
    {
      // vyberaem shkuru
      include_once ('modules/f_list_inventory.php');
      $f .= '<b>выберите материал:</b><br/>';
      $f .= list_inventory ($p['login'], 'i.q.hun%fur', 'use_stand&item='.$item.'&part=5&what='.$_GET['what']);
    }
    else
    {
      $rnd = rand (0, 1000);
      if ($rnd < 800-$p['skills'][42]*5 && !$MIN_BET) $pr = '.nor.';
      else if ($rnd < 951-$p['skills'][42]*4) $pr = '.bet.';
      else if ($rnd < 987-$p['skills'][42]*3) $pr = '.rar.';
      else if ($rnd < 997-$p['skills'][42]*2) $pr = '.eli.';
      else if ($rnd < 1000-$p['skills'][42]) $pr = '.epi.';
      else $pr = '.leg.';
      $_GET['what'] = mysql_real_escape_string ($_GET['what']);
      $it = (substr ($_GET['what'], 0, 7)).''.$pr.''.(substr ($_GET['what'], 8));
      
      $id_item = preg_replace ('/[^0-9]/', '', $_GET['id_item']);
      // proverjaem kakuju shkuru vybrali
      $q = do_mysql ("SELECT fullname, name, price FROM items WHERE id_item = '".$id_item."' AND belongs = '".$p['login']."' AND is_in = 'inv' AND realname LIKE 'i.q.hun.%fur%';");
      if (!mysql_num_rows ($q))
          put_g_error ('у вас нету этой шкуры');
      $fur = mysql_fetch_assoc ($q);
      // deleting fur
      include_once ('modules/f_delete_item.php');
      delete_item ($fur['fullname']);
      $img = '*************************';
      do_mysql ("INSERT INTO furrer VALUES ('".$p['id_player']."', '".$it."', '".$img."', NOW(), '".$fur['name']."', '".$fur['price']."');");
      $f .= 'приготовления к обработке завершены! <br/> <a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'">резать</a>!';
    }
  }
  else
  {
    // samo plotnichestvo
    $sm = mysql_fetch_assoc ($q);
    if (isset ($_GET['i']))
    {
      // udaritq po opredelennomu mestu
      // shans - esli veshq urovnja navyka - 90%, menqshe - +2 za odin urovenq
      //$pts = 90 + ($p['skills'][42] - say_level ($sm['furrer'])) * 2;
      // EDIT: bazovyj shans 90%,  +- raznica mezhdu urovnem igroka i veshi na 5;
      $pts = 90 + ($p['stats'][0] - say_level ($sm['furrer'])) * 5;
      if (rand (0, 100) <= $pts)
        furrer ($_GET['i']);
      else
        end_furrer();
    }
    // pokazyvaem kuda bitq
    $f .= '<b>выберите, где резать:</b><br/>';
    $f .= '<table><tr>';
    for ($i = 0; $i < 25; $i++)
    {
      $f .= '<td><a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&i='.$i.'">'.$sm['furrer_img'][$i].'</a></td>';
      if ($i % 5 == 4) $f .= '</tr><tr>';
    }
    $f .= '</tr></table>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&break='.$i.'">бросить это дело</a>';
  }
  exit_msg ('скорняк', $f);

  // function that ends furrering - 
  function end_furrer ()
  {
    global $p;
    do_mysql ("DELETE FROM furrer WHERE id_player = '".$p['id_player']."';");
    exit_msg ('скорняк', 'вы испортили заготовку ');
  }

  // function furrers item
  function furrer ($i)
  {
    global $LOGIN;
    global $p;
    global $arr;
    global $sm;
    // setting image
    $imga = substr ($sm['furrer'], 0, 7);
    if (!array_key_exists ($imga, $arr)) put_error ('несовпадают индексы');
    $imga = str_replace ('.', '_', $imga);
    $img = file ('modules/ascii_art/furrer/'.$imga.'.txt');
    $img = implode ('', $img);
    $img = str_replace ("\n", '', $img);
    $img = str_replace ("\r", '', $img);
    $sm['furrer_img'][$i] = $img[$i];
    do_mysql ("UPDATE furrer SET furrer_img = '".$sm['furrer_img']."' WHERE id_player = '".$p['id_player']."';");

    // checking if all identical
    $found = 1;
    for ($i = 0; $i < 25; $i++)
    {
      if ($img[$i] == ' ') continue;
      if ($img[$i] != $sm['furrer_img'][$i])
      {
        $found = 0;
        break;
      }
    }

    if ($found)
    {
      // gaining item
      include_once ('modules/f_gain_item.php');
      $it = gain_item ($sm['furrer'], 1, $LOGIN);
      // ustanavlivaem modifikacii po shkure
      $q = do_mysql ("SELECT id_item, name, realname, armor, price FROM items WHERE fullname = '".$it."';");
      $it = mysql_fetch_assoc ($q);
      $it['name'] .= ' из '.$sm['material'].' ['.$p['name'].']';
      $it['armor'] = explode ('~', $it['armor']);
      $plus = round ($sm['modifier'] / 10);
      for ($i = 0; $i < 5; $i++)
        $it['armor'][$i] += $plus;
      $it['armor'] = implode ('~', $it['armor']);
      $it['price'] += $sm['modifier'];
      $it['realname'] .= $it['price'];
      do_mysql ("UPDATE items SET name = '".$it['name']."', armor = '".$it['armor']."', price = '".$it['price']."', realname = '".$it['realname']."' WHERE id_item = ".$it['id_item']);
      do_mysql ("DELETE FROM furrer WHERE id_player = '".$p['id_player']."';");
      exit_msg ('скорняк', 'изделье завершено! ');
    }
  }
?>