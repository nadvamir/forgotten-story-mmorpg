<?php
  // funkcija dobalvljaet soobshenija v zhurnal vo vremja bitvy:
  function add_b_journal ($what)
  {
    return 1;
    global $p;
    global $LOGIN;
    $what = strip_tags ( mysql_real_escape_string ( trim ( $what)));
    // dlja togo, chtob i avtoru dobavili, (sohranen takoj in_battle nebudet)
    $c = count ($p['in_battle']);
    for ($i = 0; $i < $c; $i++)
    {
      if (!$p['in_battle'][$i]) continue;
      if (substr ($p['in_battle'][$i], 0, 2) == 'n.') continue;
      // ostaetsja igrok, emu dobavim
      $q = do_mysql ("SELECT journal FROM players WHERE login = '".$p['in_battle'][$i]."';");
      $j = mysql_result ($q, 0);
      $j .= '<br/>'.$what;
      do_mysql ("UPDATE players SET journal = '".$j."' WHERE login = '".$p['in_battle'][$i]."';");
    }
    $q = do_mysql ("SELECT journal FROM players WHERE id_player = '".$p['id_player']."' AND in_battle > 0;");
    $j = mysql_fetch_assoc ($q);
    if ($j['journal'])
    {
      $j['journal'] .= $what.'<br/>';
      do_mysql ("UPDATE players SET journal = '".$j['journal']."' WHERE id_player = '".$p['id_player']."';");
    }
  }
?>