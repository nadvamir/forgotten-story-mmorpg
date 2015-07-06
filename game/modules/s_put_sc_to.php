<?php
  // vstavitq svitok v knigu
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
    $f .= 'выберите свиток:<br/>';
    include_once ('modules/f_list_inventory.php');
    $f .= list_inventory ($LOGIN, 'i.s.', 'put_sc_to&part=2');
    $f .= '';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
    $f .= gen_footer ();
    exit ($f);
  }

  if ($_GET['part'] == 2)
  {
    // vyborka knigi:
    $scroll = $_GET['to']; // proverim potom vse srazu
    $f .= 'выберите книгу:<br/>';
    include_once ('modules/f_list_inventory.php');
    $f .= list_inventory ($LOGIN, 'i.b.', 'put_sc_to&part=3&scroll='.$scroll);
    $f .= '';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
    $f .= gen_footer ();
    exit ($f);
  }

  if ($_GET['part'] == 3)
  {
    // teperq sobstvenno vse i delaem
    $scroll = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['scroll']);
    $book = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['to']);
    if (!$scroll || !$book) put_error ('netu dannyh');

    include_once ('modules/f_add_sc_to_book.php');
    add_sc_to_book ($scroll, $book, $LOGIN);
    exit_msg ('архимагия', 'Bы добавили свиток в книгу!');
  }
?>