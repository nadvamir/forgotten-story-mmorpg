<?php
  // npc uchit zaklinaniju so svitka:
  function teach_magic_from_sc ($scroll, $npc, $login)
  {
    //$scroll = preg_replace ('/[^a-z0-9_\.]/i', '', $scroll);
    //$npc = preg_replace ('/[^a-z0-9_\.]/i', '', $npc);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);

    $nid = is_npc ($npc);
    $id = is_player ($login);
    // v odnoj li lokacii
    $q = do_mysql ("SELECT location FROM npc WHERE id_npc = '".$nid."';");
    if (!mysql_num_rows($q)) return 0;
    $loc1 = mysql_result ($q, 0);

    $q = do_mysql ("SELECT location FROM players WHERE id_player = '".$id."';");
    if (!mysql_num_rows($q)) return 0;
    $loc2 = mysql_result ($q, 0);

    if ($loc1 != $loc2) return 0;

    include_once ('modules/f_has_item.php');
    if (!has_item ($scroll, $login)) put_g_error ('у вас нету свитка!');

    $q = do_mysql ("SELECT on_take, price FROM items WHERE fullname = '".$scroll."' AND type = 's';");
    if (!mysql_num_rows ($q)) return 0;
    $spell = mysql_fetch_assoc ($q);

    // neumeet li on uzhe
    include_once ('modules/f_has_magic.php');
    if (has_magic ($spell['on_take'], $login)) put_g_error ('вы уже умеете это заклинание!');

    // cenu vyschitaem:
    $q = do_mysql ("SELECT money FROM players WHERE id_player = '".$id."';");
    $money = mysql_result ($q, 0);
    $cost = $spell['price'] * 10;
    if ($money < $cost) put_g_error ('нехватает серебра, нужно '.$cost.' серебреных!');
    $money -= $cost;

    // dobavljaem zakl:
    $q = do_mysql ("SELECT magic FROM players WHERE id_player = '".$id."';");
    $magic = mysql_result ($q, 0);
    if (!$magic) $magic = $spell['on_take'];
    else
      $magic .= '|'.$spell['on_take'];

    // obnovim dannye:
    do_mysql ("UPDATE players SET magic = '".$magic."', money = '".$money."' WHERE id_player = '".$id."';");

    // udaljaem svitok
    include_once ('modules/f_delete_item.php');
    delete_item ($scroll);

    $q = do_mysql ("SELECT name FROM magic WHERE fullname = '".$spell['on_take']."';");
    $name = mysql_result ($q, 0);
    exit_msg ('магия', 'вы выучили заклинание '.$name.' за '.$cost.' серебреных!');
  }
?>