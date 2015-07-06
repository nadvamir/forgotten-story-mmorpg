<?php
  // funkcija proverki skolqko melkih veshej estq:
  // -1 za malo, 0 netu, 1 ok;
  function has_misc_count ($item, $count, $login)
  {
    //$item = preg_replace ('/[^a-z0-9_\.]/i', '', $item);
    $count = preg_replace ('/[^0-9]/', '', $count);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);
    //if (!is_player ($login)) return 0;

    $c = 0;
    $q = do_mysql ("SELECT on_take FROM items WHERE belongs = '".$login."' AND is_in = 'inv' AND realname = '".$item."';");
    if (!mysql_num_rows ($q)) return 0;
    $c = mysql_result ($q, 0);
    if ($c < $count) return -1;
    return 1;
  }
?>