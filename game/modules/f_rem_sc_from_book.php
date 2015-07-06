<?php
  // vytashitq svitok s knigi:
  function rem_sc_from_book ($spell, $book, $login)
  {
    // v has_item proveritsja
    //$spell = preg_replace ('/[^a-z0-9_\.]/i', '', $spell);
    //$book = preg_replace ('/[^a-z0-9_\.]/i', '', $book);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);

    include_once ('modules/f_has_item.php');
    if (!has_item ($book, $login)) put_g_error ('у вас нету книги');

    // zapros na magiju chto v knige:
    $q = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$book."' AND type = 'b';");
    if (!mysql_num_rows ($q)) return 0;
    $magic = mysql_result ($q, 0);
    if (strpos ($magic, $spell) === false) put_g_error ('в этой книге нету этого заклинания!');

    // esli prodolzhaetsja skript, znachit magija estq, izvlekem ee (snachala udalim, togda bagov skryvatq nebvudut:)
    $magic = string_drop ($magic, $spell);
    // terq sozdadim:
    //include_once ('modules/f_create_item.php');
    $q = do_mysql ("SELECT type FROM magic WHERE fullname = '".$spell."';");
    if (!mysql_num_rows ($q)) put_error ('netu takogo zaklinanija');
    $tp = mysql_result ($q, 0);
    //#####$scroll = create_item ('i.s.'.$tp.'.'.$spell);
    include_once ('modules/f_gain_item.php');
    gain_item ('i.s.'.$tp.'.'.$spell, 1, $login);

    // obnovim knigu i vse:
    do_mysql ("UPDATE items SET on_take = '".$magic."' WHERE fullname = '".$book."';");
    return 1;
  }
?>