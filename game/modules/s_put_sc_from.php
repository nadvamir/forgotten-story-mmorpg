<?php
  // vytashitq svitok iz knigi:
  // nalichie rjadom stola:
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE location = '".$p['location']."' AND realname = 'i.o.sta.arch_table';");
  $ct = mysql_result ($q, 0);
  if (!$ct) put_error ('netu stola rjadom');
  if (!$p['skills'][30]) put_g_error ('у вас нехватает навыков пользоватся столиком!');

  $f = gen_header ('Архимагия');
  $f .= '<div class="y" id="layfa"><b>Столик Архимага:</b></div><p>';

  if (!isset ($_GET['part']))
  {
    // chastq pervaja:  vyberaem knigu:
    $f .= 'выберите книгу:<br/>';
    include_once ('modules/f_list_inventory.php');
    $f .= list_inventory ($LOGIN, 'i.b.', 'put_sc_from&part=2');
    $f .= '';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
    $f .= gen_footer ();
    exit ($f);
  }

  if ($_GET['part'] == 2)
  {
    // vyborka zakla iz knigi:
    $book = mysql_real_escape_string ($_GET['to']);

    $f .= 'выберите заклинание:<br/>';

    $q = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$book."';");
    if (!mysql_num_rows ($q)) put_error ('netu etoj knigi');
    $spells = mysql_result ($q, 0);
    $spells = explode ('~', $spells);

    $c = count ($spells);
    for ($i = 0; $i < $c; $i++)
    {
      if (!$spells[$i]) continue;
      $q = do_mysql ("SELECT name FROM magic WHERE fullname = '".$spells[$i]."';");
      if (!mysql_num_rows ($q)) put_error ('netu takogo zakla');
      $name = mysql_result ($q, 0);
      $f .= '-<a class="blue" href="game.php?sid='.$sid.'&action=put_sc_from&spell='.$spells[$i].'&book='.$book.'&part=3">';
      $f .= $name.'</a><br/>';
    }

    $f .= '<hr/>';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
    $f .= gen_footer ();
    exit ($f);
  }

  if ($_GET['part'] == 3)
  {
    // teperq sobstvenno vse i delaem
    $spell = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['spell']);
    $book = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['book']);
    if (!$spell || !$book) put_error ('netu dannyh');

    include_once ('modules/f_rem_sc_from_book.php');
    rem_sc_from_book ($spell, $book, $LOGIN);
    exit_msg ('архимагия', 'Bы выташили свиток из книги!');
  }
?>