<?php
  // funkcija dlja samovyuchivanija zaklinanija so svitka
  // dolzhen bytq navyk.
  function learn_magic_from_sc ($scroll, $login);
  {
    //$scroll = preg_replace ('/[^a-z0-9_\.]/i', '', $scroll);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);
    $id = is_player ($login);

    // estq li svitok:
    include_once ('modules/f_has_item.php');
    if (!has_item ($scroll, $login)) put_g_error ('у вас нету свитка');

    $q = do_mysql ("SELECT on_take, price FROM items WHERE fullname = '".$scroll."' AND type = 's';");
    if (!mysql_num_rows ($q)) return 0;
    $spell = mysql_fetch_assoc ($q);

    // sluchaem neumeet li on uzhe
    include_once ('modules/f_has_magic.php');
    if (has_magic ($spell['on_take'], $login)) put_g_error ('вы уже умеете это заклинание!');

    // estq li navyk:
    $q = do_mysql ("SELECT skills FROM players WHERE id_player = '".$id."';");
    $skills = mysql_result ($q, 0);
    $skills = explode ('|', $skills);
    if (!$skills[30]) put_g_error ('у вас нету навыка');

    // 1 - 10%:
    $proc = $skills[30] * 10;
    if (rand(0, 100) <= $proc)
    {
      // tolqko v etom sluchae vam udastsja vyuchityq zakl:
      // dobavljaem zakl:
      $q = do_mysql ("SELECT magic FROM players WHERE id_player = '".$id."';");
      $magic = mysql_result ($q, 0);
      if (!$magic) $magic = $spell['on_take'];
      else
        $magic .= '|'.$spell['on_take'];
      // obnovim dannye:
      do_mysql ("UPDATE players SET magic = '".$magic."' WHERE id_player = '".$id."';");
      $q = do_mysql ("SELECT name FROM magic WHERE fullname = '".$spell['on_take']."';");
      $name = mysql_result ($q, 0);
      $f = 'вы выучили заклинание '.$name.'!';
    }
    else $f = 'вам неудалось выучить заклинание!';

    // udalim svitok:
    include_once ('modules/f_delete_item.php');
    delete_item ($scroll);
    $f .= 'вы потеряли свиток!';
    exit_msg ('магия', $f);
  }
?>