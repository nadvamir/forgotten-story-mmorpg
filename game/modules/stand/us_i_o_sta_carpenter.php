<?php
  // stol plotnika
  $arr['i.w.arb'] = 'modules/items/items_w/items_w_arb.php';
  $arr['i.w.bow'] = 'modules/items/items_w/items_w_bow.php';
  $arr['i.w.tre'] = 'modules/items/items_w/items_w_tre.php';
  $arr['i.x.shi'] = 'modules/items/items_x/items_x_shi.php';

  // esli netu nikakogo dejstvija
  $f = '';
  do_mysql ("DELETE FROM carpenter WHERE puttime < NOW() - INTERVAL '10' MINUTE;");
  $q = do_mysql ("SELECT * FROM carpenter WHERE id_player = '".$p['id_player']."';");

  if (!mysql_num_rows ($q))
  {
    if (!isset ($_GET['part']))
    {
      // vyberaem chto delatq
      $f .= '<b>выберите что делать:</b><br/>';
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=2&what=i.w">оружие</a><br/>';
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
    }
    else if ($_GET['part'] == 3)
    {
      if (!array_key_exists ($_GET['what'], $arr)) put_error ('несовпадают индексы');
      unset ($it);
      include $arr[$_GET['what']];
      unset ($items);
      $f .= '<b>какую вешь?</b><br/>';
      $sklim = $p['skills'][36];
      if ($sklim > 12) $sklim = 12 + ($p['skills'][36] - 12) / 2;
      foreach ($it as $key => $val)
        if (say_level ($key) <= $sklim)
        {
          $val = explode ('|', $val);
          $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=4&what='.$key.'">'.$val[0].'</a><br/>';
        }
    }
    else
    {
      // testing if there is enough wood -
      include_once ('modules/f_trade_param.php');
      $rnd = rand (0, 1000);
      if ($rnd < 800-$p['skills'][36]*5 && !$MIN_BET) $pr = '.nor.';
      else if ($rnd < 951-$p['skills'][36]*4) $pr = '.bet.';
      else if ($rnd < 987-$p['skills'][36]*3) $pr = '.rar.';
      else if ($rnd < 997-$p['skills'][36]*2) $pr = '.eli.';
      else if ($rnd < 1000-$p['skills'][36]) $pr = '.epi.';
      else $pr = '.leg.';
      $_GET['what'] = mysql_real_escape_string ($_GET['what']);
      $it = (substr ($_GET['what'], 0, 7)).''.$pr.''.(substr ($_GET['what'], 8));
      $i = trade_param ($it);
      include_once ('modules/f_has_count.php');
      if (!has_count ('i.q.que.vetka', $i[11], $LOGIN)) put_g_error ('нехватает дерева');
      // deleting ore
      include_once ('modules/f_delete_count.php');
      delete_count ('i.q.que.vetka', $i[11], $LOGIN);
      $img = '*************************';
      do_mysql ("INSERT INTO carpenter VALUES ('".$p['id_player']."', '".$it."', '".$img."', NOW());");
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
      //$pts = 90 + ($p['skills'][36] - say_level ($sm['carpenter'])) * 2;
	  // bazovyj shans 90%,  +- raznica mezhdu urovnem igroka i veshi na 5;
      $pts = 90 + ($p['stats'][0] - say_level ($sm['carpenter'])) * 5;
      if (rand (0, 100) <= $pts)
        carpenter ($_GET['i']);
      else
        end_carpenter();
    }
    // pokazyvaem kuda bitq
    $f .= '<b>выберите куда ударить:</b><br/>';
    $f .= '<table><tr>';
    for ($i = 0; $i < 25; $i++)
    {
      $f .= '<td><a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&i='.$i.'">'.$sm['carpenter_img'][$i].'</a></td>';
      if ($i % 5 == 4) $f .= '</tr><tr>';
    }
    $f .= '</tr></table>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&break='.$i.'">бросить это дело</a>';
  }
  exit_msg ('плотник', $f);

  // function that ends carpentering - 
  function end_carpenter ()
  {
    global $p;
    do_mysql ("DELETE FROM carpenter WHERE id_player = '".$p['id_player']."';");
    exit_msg ('плотник', 'вы испортили заготовку ');
  }

  // function carpenters item
  function carpenter ($i)
  {
    global $LOGIN;
    global $p;
    global $arr;
    global $sm;
    // setting image
    $imga = substr ($sm['carpenter'], 0, 7);
    if (!array_key_exists ($imga, $arr)) put_error ('несовпадают индексы');
    $imga = str_replace ('.', '_', $imga);
    $img = file ('modules/ascii_art/carpenter/'.$imga.'.txt');
    $img = implode ('', $img);
    $img = str_replace ("\n", '', $img);
    $img = str_replace ("\r", '', $img);
    $sm['carpenter_img'][$i] = $img[$i];
    do_mysql ("UPDATE carpenter SET carpenter_img = '".$sm['carpenter_img']."' WHERE id_player = '".$p['id_player']."';");

    // checking if all identical
    $found = 1;
    for ($i = 0; $i < 25; $i++)
    {
      if ($img[$i] == ' ') continue;
      if ($img[$i] != $sm['carpenter_img'][$i])
      {
        $found = 0;
        break;
      }
    }

    if ($found)
    {
      // gaining item
      include_once ('modules/f_gain_item.php');
      $it = gain_item ($sm['carpenter'], 1, $LOGIN);
      do_mysql ("DELETE FROM carpenter WHERE id_player = '".$p['id_player']."';");
      do_mysql ("UPDATE items SET name = CONCAT(name, ' [".$p['name']."]') WHERE fullname = '".$it."';");
      exit_msg ('плотник', 'изделье завершено! ');
    }
  }
?>