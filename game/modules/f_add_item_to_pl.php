<?php
  // dobavljaet veshq k igroku (s niotkuda)
  function add_item_to_pl ($pl, $item)
  {
    //$item = preg_replace ('/[^a-z\._0-9]/i', '', $item);
    //$pl = preg_replace ('/[^a-z\._0-9]/i', '', $pl);
    $t = substr ($item, 2, 1);
    if ($t == 'o' || $t == 'l') put_error ('ne te veshi, pane!');
    //require_once ("modules/f_get_weight.php");

    // kolichestvo:
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$pl."' AND is_in = 'inv' AND weight > 0;");
    $c = mysql_result ($q, 0);
    global $I_SEP_C;
    if ($c > $I_SEP_C)  put_g_error('в рюгзаке нехватает места');
    // add_journal ('[green]'.$item.' to '.$pl.'[/end]', 'maxx');

    do_mysql ("UPDATE items SET belongs = '".$pl."', location = '0', map = '', is_in = 'inv' WHERE fullname = '".$item."';");
    return 1;
  }
?>