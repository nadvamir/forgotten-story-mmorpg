<?php
  // vozvrashjaet 1, esli gdenitq imeet etu veshq
  // vozvrashjaet 0, esli takoj ne nashlosq
  function has_item ($item, $login)
  {
    # do_mysq
    //$login = preg_replace ('/[^a-z_0-9]/i', '', $login);
    //$item = preg_replace ('/[^a-z0-9\._]/i', '', $item);
    $q = do_mysql ("SELECT price FROM items WHERE fullname = '".$item."' AND belongs = '".$login."' AND is_in <> 'ban';");
    if (!mysql_num_rows ($q)) return 0;
    else return 1;
  }
?>