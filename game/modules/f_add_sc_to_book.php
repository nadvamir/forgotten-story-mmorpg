<?php
  // funkcija dobavljaet magiju v knigu magii:
  function add_sc_to_book ($scroll, $book, $login)
  {
    // v has_item proveritsja
    //$scroll = preg_replace ('/[^a-z0-9_\.]/i', '', $scroll);
    //$book = preg_replace ('/[^a-z0-9_\.]/i', '', $book);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);

    include_once ('modules/f_has_item.php');
    if (!has_item ($scroll, $login)) put_g_error ('у вас нету свитка');
    if (!has_item ($book, $login)) put_g_error ('у вас нету книги');

    // tolqko esli estq navyk:
    $q = do_mysql ("SELECT skills FROM players WHERE login = '".$login."';");
    $skills = mysql_result ($q, 0);
    $skills = explode ('|', $skills);
    if (!$skills[30]) put_g_error ('у вас нету навыка');

    // dobavim:
    $q = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$book."' AND type = 'b';");
    if (!mysql_num_rows ($q)) return 0;
    $mlist = mysql_result ($q, 0);

    $q = do_mysql ("SELECT on_take FROM items WHERE type = 's' AND fullname = '".$scroll."';");
    if (!mysql_num_rows ($q)) return 0;
    $spell = mysql_result ($q, 0);

    if (strpos ($mlist, $spell) !== false) put_g_error ('в этой книге уже есть это заклинание!');
    if ($mlist) $mlist .= '~'.$spell;
    else $mlist = $spell;
    do_mysql ("UPDATE items SET on_take = '".$mlist."' WHERE fullname = '".$book."';");

    // udalim svitok:
    include_once ('modules/f_delete_item.php');
    delete_item ($scroll);
    return 1;
  }
?>