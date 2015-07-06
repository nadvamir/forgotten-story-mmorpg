<?php
  // brositq veshq
  function drop_item ($item, $login)
  {
    //$item = preg_replace ('/[^a-z0-9\._]/i', '', $item);
    //$login = mysql_real_escape_string ($login);
    $id = is_player ($login);
    $q = do_mysql ("SELECT name FROM items WHERE belongs = '".$login."' AND is_in <> 'ban' AND fullname = '".$item."';");
    if (!mysql_num_rows ($q)) put_g_error ('у вас нету этой вещи');
    $name = mysql_result ($q, 0);

    // raz vse estq, vykinem v lokaciju.
    $q = do_mysql ("SELECT location FROM players WHERE id_player = '".$id."';");
    $loc = mysql_result ($q, 0);
    include_once ('modules/f_add_item_to_loc.php');
    add_item_to_loc ($loc, $item);

    $q = do_mysql ("SELECT gender, name FROM players WHERE id_player = '".$id."';");
    $p = mysql_fetch_assoc ($q);

    if ($p['gender'] == 'male') $text = $p['name'].' 6poccul';
    else $text = $p['name'].' 6poccula';

    add_journal ($text.' '.$name.'!', 'l.'.$loc);
  }
?>