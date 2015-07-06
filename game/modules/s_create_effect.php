<?php
  // nanesem effekt na oruzhie
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
    $f .= 'выберите свиток с эффектом:<br/>';
    include_once ('modules/f_list_inventory.php');
    $f .= list_inventory ($LOGIN, 'i.s.', 'create_effect&part=2');
    $f .= '';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
    $f .= gen_footer ();
    exit ($f);
  }

  if ($_GET['part'] == 2)
  {
    // vyborka oruzhija:
    $scroll = $_GET['to']; // proverim potom vse srazu
    $f .= 'выберите оружие:<br/>';
    include_once ('modules/f_list_inventory.php');
    $f .= list_inventory ($LOGIN, 'i.w.', 'create_effect&part=3&scroll='.$scroll);
    $f .= '';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
    $f .= gen_footer ();
    exit ($f);
  }

  if ($_GET['part'] == 3)
  {
    // teperq sobstvenno vse i delaem
    $scroll = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['scroll']);
    $weapon = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['to']);
    if (!$weapon || !$scroll) put_error ('netu dannyh');

    // proverjaem nalichie 
    include_once ('modules/f_has_item.php');
    if (!has_item ($scroll, $LOGIN)) put_error ('netu etogo svitka');
    if (!has_item ($weapon, $LOGIN)) put_error ('netu etogo oruzhija');
    // berem nazvanija magii - 
    $q = do_mysql ("SELECT on_take  FROM items WHERE fullname = '".$scroll."';");
    $spell = mysql_result ($q, 0);
    // berem effect
    $q = do_mysql ("SELECT effect FROM magic WHERE fullname = '".$spell."';");
    $eff = mysql_result ($q, 0);
    if (!$eff) put_g_error ('этот свиток без эффекта');
    // dalee udaljaem svitok
    include_once ('modules/f_delete_item.php'); 
    delete_item ($scroll, $LOGIN);
    // kazhdyj +1 k navyku daet 10%
    include_once ('modules/f_check_cast.php');
    if (check_cast ($spell, $LOGIN))
    {
      // obnovljaem u oruzhija effekt
      do_mysql ("UPDATE items SET on_drop = '".$eff."' WHERE fullname = '".$weapon."';");
      add_journal ('эффект наложен!', $LOGIN);
    }
    else add_journal ('магия расеилась!', $LOGIN);
  }
?>