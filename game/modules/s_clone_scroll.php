<?php
  // klonirovatq svitok
  // nalichie rjadom stola:
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE location = '".$p['location']."' AND realname = 'i.o.sta.arch_table';");
  $ct = mysql_result ($q, 0);
  if (!$ct) put_error ('netu stola rjadom');
  if (!$p['skills'][30]) put_g_error ('у вас нехватает навыков пользоватся столиком!');

  $f = gen_header ('Архимагия');
  $f .= '<div class="y" id="layfa"><b>Столик Архимага:</b></div><p>';

  if (!isset ($_GET['part']))
  {
    // chastq pervaja:  vyberaem svitok:
    $f .= 'выберите свиток (также имейте при себе пустой):<br/>';
    include_once ('modules/f_list_inventory.php');
    $f .= list_inventory ($LOGIN, 'i.s.', 'clone_scroll&part=2');
    $f .= '';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
    $f .= gen_footer ();
    exit ($f);
  }

  if ($_GET['part'] == 2)
  {
    // teperq sobstvenno vse i delaem
    $scroll = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['to']);
    include_once ('modules/f_has_item.php');
    if (!has_item ($scroll, $LOGIN)) put_error ('netu etogo svitka');
    
    // proverim estq li u igroka pustoj svitok:
    include_once ('modules/f_has_count.php');
    include_once ('modules/f_delete_count.php');
    if (!has_count ('i.q.que.scroll', 1, $LOGIN)) put_g_error ('при себе надо иметь пустой свиток для записи');
    // udaljaem - 
    delete_count ('i.q.que.scroll', 1, $LOGIN);
    // berem nazvanie svitka
    include_once ('modules/f_real_name.php');
    $rn = real_name ($scroll);
    // berem cebnu svitka
    $q = do_mysql ("SELECT price FROM items WHERE fullname = '".$scroll."';");
    $price = mysql_result ($q, 0);
    if (rand (0, ($price / 10)) <= $p['skills'][30])
    {
      // sozdaem svitok
      include_once ('modules/f_gain_item.php');
      gain_item ($rn, 1, $LOGIN);
      add_journal ('вы скопировали свиток', $LOGIN);
    }
    else
    {
      add_journal ('вы испортили пустой свиток', $LOGIN);
    }
  }
?>