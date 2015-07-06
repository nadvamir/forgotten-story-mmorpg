<?php
  // ispolqzovatq manu po zaklu:
  // esli vse ok vozvratit 1, esli nehvatilo many 0
  function use_mana ($spell, $login)
  {
    //$spell = preg_replace ('/[^a-z0-9_]/i', '', $spell);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);

    $q = do_mysql ("SELECT mana FROM magic WHERE fullname = '".$spell."';");
    if (!mysql_num_rows ($q)) return 0;
    $minus = mysql_result ($q, 0);

    $id = is_player ($login);
    $q = do_mysql ("SELECT mana FROM players WHERE id_player = '".$id."';");
    if (!mysql_num_rows ($q)) return 0;
    $mana = mysql_result ($q, 0);
    $mana = explode ('|', $mana);

    $mana[0] -= $minus;
    if ($mana[0] < 0) return 0; // many nehvatilo.

    $nmana = $mana[0].'|'.$mana[1];
    do_mysql ("UPDATE players SET mana = '".$nmana."' WHERE id_player = '".$id."';");
    return 1;
  }
?>