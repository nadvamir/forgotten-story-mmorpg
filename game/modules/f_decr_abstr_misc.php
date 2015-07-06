<?php
  // funkcija umenqshaet konkretnye reagenty ili strely
  // u igrokov
  // kogda ukazany tolqko ih prototipy
  function decr_abstr_misc ($prot, $who, $count, $other = 0)
  {
    //$prot = preg_replace ('/[^a-z0-9_\.]/i', '', $prot);
    $count = preg_replace ('/[^0-9]/', '', $count);
    //$who = preg_replace ('/[^a-z0-9_]/i', '', $who);
    if (!is_player ($who)) return 0;
    if ($count < 1) return 0;

    $q = do_mysql ("SELECT on_take FROM items WHERE belongs = '".$who."' AND is_in = 'inv' AND realname = '".$prot."' AND type = 'm';");
    if (!mysql_num_rows ($q)) return 0;
    $ci = mysql_result ($q, 0);
    if ($ci < $count) return 0;
    $ci -= $count;
    if ($ci) do_mysql ("UPDATE items SET on_take = '".$ci."' WHERE  belongs = '".$who."' AND is_in = 'inv' AND realname = '".$prot."';");
    else
    {
      include_once ('modules/f_delete_item.php');
      $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$who."' AND is_in = 'inv' AND realname = '".$prot."' AND type = 'm';");
      $item = mysql_result ($q, 0);
      delete_item ($item);
    }
    return 1;
  }
?>