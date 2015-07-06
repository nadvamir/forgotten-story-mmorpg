<?php
  // sozdatq svitok - 
  // nalichie rjadom stola:
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE location = '".$p['location']."' AND realname = 'i.o.sta.arch_table';");
  $ct = mysql_result ($q, 0);
  if (!$ct) put_error ('netu stola rjadom');
  if (!$p['skills'][30]) put_g_error ('у вас нехватает навыков пользоватся столиком!');

  $f = gen_header ('Архимагия');
  $f .= '<div class="y" id="layfa"><b>Столик Архимага:</b></div><p>';

  if (!isset ($_GET['part']))
  {
    // chastq pervaja:  vyberaem magiju
    $f .= 'выберите магию:<br/>';
    if (!$p['magic_l']) put_g_error ('вы неумете магии');
    $c = count ($p['magic']);
    for ($i = 0; $i < $c; $i++)
    {
      $q = do_mysql ("SELECT name FROM magic WHERE fullname = '".$p['magic'][$i]."';");
      if (!mysql_num_rows ($q))
        continue;
      $name = mysql_result ($q, 0);
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=create_scroll&part=2&spell='.$p['magic'][$i].'">'.$name.'</a><br/>';
    }
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
    $f .= gen_footer ();
    exit ($f);
  }


  if ($_GET['part'] == 2)
  {
    // teperq sobstvenno vse i delaem
    $spell = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['spell']);
    if (!is_in ($spell, $p['magic'])) put_error ('заклинание не найдено');
    // nu a esli najdeno, delaem proverku na kastovanie, esli udachna - sozdaem svitok :)
    include_once ('modules/f_check_cast.php');
    include_once ('modules/f_has_count.php');
    include_once ('modules/f_delete_count.php');
    if (!has_count ('i.q.que.scroll', 1, $LOGIN)) put_g_error ('при себе надо иметь пустой свиток для записи');
    delete_count ('i.q.que.scroll', 1, $LOGIN);
    if (check_cast ($spell, $LOGIN))
    {
      include_once ('modules/f_gain_item.php');
      $q = do_mysql ("SELECT type FROM magic WHERE fullname = '".$spell."';");
      $type = mysql_result ($q, 0);
      gain_item ('i.s.'.$type.'.'.$spell, 1, $LOGIN);
      add_journal ('вы создали свиток', $LOGIN);
    }
    else add_journal ('магия рассеилась', $LOGIN);
  }
?>