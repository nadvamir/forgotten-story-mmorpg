<?php
  // rudnaja zhila
  // proverim, estq li udochka v rukah i navyk
  if (substr ($p['weapon'], 0, 25) != 'i.w.ham.bas.1h.molot.lvl1') put_g_error ('возьмите кузнечный молот в руки!');

  $arr['i.w.swo'] = 'modules/items/items_w/items_w_swo.php';
  $arr['i.w.axe'] = 'modules/items/items_w/items_w_axe.php';
  $arr['i.w.ham'] = 'modules/items/items_w/items_w_ham.php';
  $arr['i.w.kli'] = 'modules/items/items_w/items_w_kli.php';
  $arr['i.w.kni'] = 'modules/items/items_w/items_w_kni.php';
  $arr['i.w.spe'] = 'modules/items/items_w/items_w_spe.php';
  $arr['i.a.bo1'] = 'modules/items/items_a/items_a_bo1.php';
  $arr['i.a.hea'] = 'modules/items/items_a/items_a_hea.php';
  $arr['i.a.pon'] = 'modules/items/items_a/items_a_pon.php';
  $arr['i.a.sho'] = 'modules/items/items_a/items_a_sho.php';

  // esli netu nikakogo dejstvija
  $f = '';
  if (isset ($_GET['break'])) endsmith();

  do_mysql ("DELETE FROM smith WHERE puttime < NOW() - INTERVAL '10' MINUTE;");
  $q = do_mysql ("SELECT * FROM smith WHERE id_player = '".$p['id_player']."';");

  if (!mysql_num_rows ($q))
  {
    if (!isset ($_GET['part']))
    {
      // vyberaem chto kovatq
      $f .= '<b>выберите что ковать:</b><br/>';
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=2&what=i.w">оружие</a><br/>';
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=2&what=i.a">броню</a><br/>';
      $f .= '<b>или же </b><a class="blue" href="game.php?sid='.$sid.'&action=repair_it_yourself">починить вещь</a>?';
    }
    else if ($_GET['part'] == 2)
    {
      if ($_GET['what'] == 'i.w')
      {
        $f .= '<b>а конкретнее?</b><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.w.swo">меч</a><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.w.axe">топор</a><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.w.ham">молот</a><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.w.kli">клинок</a><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.w.kni">кинжал</a><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.w.spe">копье</a>';
      }
      else if ($_GET['what'] == 'i.a')
      {
        $f .= '<b>а конкретнее?</b><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.a.bo1">доспех</a><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.a.hea">шлем</a><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.a.pon">поножи</a><br/>';
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=3&what=i.a.sho">наплечники</a>';
      }
    }
    else if ($_GET['part'] == 3)
    {
      if (!array_key_exists ($_GET['what'], $arr)) put_error ('несовпадают индексы');
      unset ($it);
      include $arr[$_GET['what']];
      unset ($items);
      $f .= '<b>какую вешь?</b><br/>';
      $sklim = $p['skills'][34];
      if ($sklim > 12) $sklim = 12 + ($p['skills'][34] - 12) / 2;
      foreach ($it as $key => $val)
        if (say_level ($key) <= $sklim)
        {
          $val = explode ('|', $val);
          $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=4&what='.$key.'">'.$val[0].'</a><br/>';
        }
    }
    else
    {
      // testing if there is enough ore -
      include_once ('modules/f_trade_param.php');
      $rnd = rand (0, 1000);
      if ($rnd < 800-$p['skills'][34]*5 && !$MIN_BET) $pr = '.nor.';
      else if ($rnd < 951-$p['skills'][34]*4) $pr = '.bet.';
      else if ($rnd < 987-$p['skills'][34]*3) $pr = '.rar.';
      else if ($rnd < 997-$p['skills'][34]*2) $pr = '.eli.';
      else if ($rnd < 1000-$p['skills'][34]) $pr = '.epi.';
      else $pr = '.leg.';
      $_GET['what'] = mysql_real_escape_string ($_GET['what']);
      $it = (substr ($_GET['what'], 0, 7)).''.$pr.''.(substr ($_GET['what'], 8));
      $i = trade_param ($it);
      include_once ('modules/f_has_count.php');
      if (!has_count ('i.q.que.ore', $i[11], $LOGIN)) put_g_error ('нехватает руды');
      // deleting ore
      include_once ('modules/f_delete_count.php');
      delete_count ('i.q.que.ore', $i[11], $LOGIN);
      $img = '*************************';
      do_mysql ("INSERT INTO smith VALUES ('".$p['id_player']."', '".$it."', '".$img."', NOW());");
      $f .= 'приготовления к кованию завершены! <br/> <a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'">ковать</a>!';
    }
  }
  else
  {
    // samo kovanie
    $sm = mysql_fetch_assoc ($q);
    if (isset ($_GET['i']))
    {
      // udaritq po opredelennomu mestu
      // shans - esli veshq urovnja navyka - 90%, menqshe - +2 za odin urovenq
      //$pts = 90 + ($p['skills'][34] - say_level ($sm['smith'])) * 2;
	  // bazovyj shans 90%,  +- raznica mezhdu urovnem igroka i veshi na 5;
      $pts = 90 + ($p['stats'][0] - say_level ($sm['smith'])) * 5;
      if (rand (0, 100) <= $pts)
        smith ($_GET['i']);
      else
        endsmith();
    }
    // pokazyvaem kuda bitq
    $f .= '<b>выберите куда ударить:</b><br/>';
    $f .= '<table><tr>';
    for ($i = 0; $i < 25; $i++)
    {
      $f .= '<td><a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&i='.$i.'">'.$sm['smith_img'][$i].'</a></td>';
      if ($i % 5 == 4) $f .= '</tr><tr>';
    }
    $f .= '</tr></table>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&break='.$i.'">бросить это дело</a>';
  }
  exit_msg ('кузнец', $f);

  // function that ends smithing - 
  function endsmith ()
  {
    global $p;
    do_mysql ("DELETE FROM smith WHERE id_player = '".$p['id_player']."';");
    exit_msg ('кузнец', 'вы испортили заготовку ');
  }

  // function smiths item
  function smith ($i)
  {
    global $p;
    global $arr;
    global $sm;
    // setting image
    $imga = substr ($sm['smith'], 0, 7);
    if (!array_key_exists ($imga, $arr)) put_error ('несовпадают индексы');
    $imga = str_replace ('.', '_', $imga);
    $img = file ('modules/ascii_art/blacksmith/'.$imga.'.txt');
    $img = implode ('', $img);
    $img = str_replace ("\n", '', $img);
    $img = str_replace ("\r", '', $img);
    $sm['smith_img'][$i] = $img[$i];
    do_mysql ("UPDATE smith SET smith_img = '".$sm['smith_img']."' WHERE id_player = '".$p['id_player']."';");

    // checking if all identical
    $found = 1;
    for ($i = 0; $i < 25; $i++)
    {
      if ($img[$i] == ' ') continue;
      if ($img[$i] != $sm['smith_img'][$i])
      {
        $found = 0;
        break;
      }
    }

    if ($found)
    {
      // gaining item
      include_once ('modules/f_gain_item.php');
      $it = gain_item ($sm['smith'], 1, $p['login']);
      do_mysql ("DELETE FROM smith WHERE id_player = '".$p['id_player']."';");
      exit_msg ('кузнец', 'изделье завершено! ');
      do_mysql ("UPDATE items SET name = CONCAT(name, ' [".$p['name']."]') WHERE fullname = '".$it."';");
    }
  }
?>