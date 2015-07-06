<?php
  // koster
  // proverim, gorit li koster
  $q = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$item."';");
  $fire = mysql_result ($q, 0);
  if ($fire == 'off')
  {
    // popytaemsja razzhechq
    include_once ('modules/f_has_count.php');
    if (!has_count ('i.q.que.vetka', 5, $LOGIN)) put_g_error ('нехватает дерева чтобы разжечь костер');
    include_once ('modules/f_delete_count.php');
    delete_count ('i.q.que.vetka', 5, $LOGIN);
    do_mysql ("UPDATE items SET on_take = 'on', on_use = '".(time () + 600)."' WHERE fullname = '".$item."';");
    exit_msg ('кострище', 'вы разожгли костер!<br/><a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'">продолжить</a>');
  }
  // vyberaem opcii
  $f = '';
  if (!isset ($_GET['part']))
  {
    $f .= '<b>выберите что вы хотите делать:</b><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=1&sa=fry">поджарить</a> (нужна ветка)<br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&part=1&sa=takeugolq">взять уголь</a><br/>';
    exit_msg ('кострище', $f);
  }
  else
  {
    if ($_GET['sa'] == 'fry')
    {
      include_once ('modules/f_has_count.php');
      if (!has_count ('i.q.que.vetka', 1, $LOGIN)) put_g_error ('нужна одна ветка, на которой будете жарить (типо шампура). ветка многоразовая :)');
      if ($_GET['part'] == 1)
      {
        // vyberaem chto zharitq. a zharitq mozhno lishq syroe i rybu. dazhe nevazhno chto, prosto berem vse chto nachinaetsha raw ili fish s inventarja, i raw zamenjaem na fry, a fish na fry_fish:
        include_once ('modules/f_list_inventory.php');
        $f .= '<b>выберите что приготовить:</b><br/>';
        $f .= list_inventory ($LOGIN, 'i.f.foo.raw_', 'use_stand&item='.$item.'&part=2&sa=fry');
        $f .= list_inventory ($LOGIN, 'i.f.foo.fish_', 'use_stand&item='.$item.'&part=2&sa=fry');
        $f .= '&#171;<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'">назад</a>';
        exit_msg ('кострище', $f);
      }
      else
      {
        $to = mysql_real_escape_string (strip_tags ($_GET['to']));
        if (substr ($to, 0, 12) != 'i.f.foo.raw_' && substr ($to, 0, 12) != 'i.f.foo.fish')
          put_g_error ('Жарить можно сырую рыбу и мясо. ты та что суешь?');
        // v ostalqnyh sluchajah zharim
        // berem ves veshi - 
        include_once ('modules/f_get_weight.php');
        $wgh = get_weight ($to);
        // udaljaem syrqe
        include_once ('modules/f_delete_item.php');
        delete_item ($to);
        // smotrim che eto takoe bylo - 
        include_once ('modules/f_real_name.php');
        $to = real_name ($to);
        // dalee, berem shans prigotovitq
        // on raven 100 - ves * 10 + navyk * 10.
        // esli ves > 30, on raven navyku prigotovlenija
        // esli navyk 0, shans 0
        $chanse = 0;
        if ($wgh < 30) $chanse = 100 - $wgh * 10 + $p['skills'][37] * 10;
        else $chanse = $p['skills'][37];
        if (!$p['skills'][37]) $chanse = 0;
        // proverjaem vyshlo li prigotovitq - 
        if (rand (0, 100) <= $chanse)
        {
          $to = str_replace ('raw_', 'fry_', $to);
          $to = str_replace ('fish', 'fry_fish', $to);
          include_once ('modules/f_gain_item.php');
          gain_item ($to, 1, $LOGIN);
        }
        else
        {
          add_journal ('еда обуглилась...', $LOGIN);
        }
      }
    }
    else if ($_GET['sa'] == 'takeugolq')
    {
      include_once ('modules/f_gain_item.php');
      gain_item ('i.q.que.alch.ugolq', 1, $LOGIN);
    }
  }
?>