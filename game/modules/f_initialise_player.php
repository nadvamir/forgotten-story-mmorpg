<?php
  // funkcija ustanavlivaet parametry igroka po ego navykam
  function initialise_player ()
  {
    global $LOGIN;
    include_once ('modules/f_check_pl_exp.php');
    include_once ('modules/f_upd_affected.php');
    upd_affected ($LOGIN);
    check_pl_exp ($LOGIN);
    global $p;
    $p['life'][1] = $p['skills'][0] * 72 + $p['skills'][1] * 31;
    $q = do_mysql ("SELECT jewel FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'shi' AND type = 'x' AND (jewel <> '' AND jewel <> '0');");
    if (mysql_num_rows ($q))
    {
      $j = mysql_result ($q, 0);
      global $I_J;
      if ($I_J[$j]['hp']) $p['life'][1] = round ($I_J[$j]['hp'] * $p['life'][1]);
    }
    if ($p['life'][0] > $p['life'][1]) $p['life'][0] = $p['life'][1];
    $p['mana'][1] = $p['skills'][2] * 100;
    if ($p['mana'][0] > $p['mana'][1]) $p['mana'][0] = $p['mana'][1];
    $p['carry'] = $p['skills'][0] * 10 + $p['skills'][1] * 5;
    $life = $p['life'][0].'|'.$p['life'][1];
    $mana = $p['mana'][0].'|'.$p['mana'][1];
    $carry = $p['carry'];

    // accounts
    if ($p['account'] && $p['account_to'] < time())
      do_mysql ("UPDATE players SET account = '0', account_to = '0' WHERE id_player = '".$p['id_player']."';");

    if ($p['status1'][0] > 0 && $p['last'][4] < time() - 600) $p['status1'][0] = 0;
    do_mysql ("UPDATE players SET life = '".$life."', mana = '".$mana."', carry = '".$carry."', status1 = '".$p['status1']."' WHERE id_player = '".$p['id_player']."';");
    return 1;
  }
?>