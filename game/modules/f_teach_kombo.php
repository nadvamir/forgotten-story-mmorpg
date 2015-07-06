<?php
  // funkcija dlja npc obxuchitq kombo;
  function teach_kombo ($teacher, $student, $kombo, $price)
  {
    //$teacher = preg_replace ('/[^a-z0-9_\.]/i', '', $teacher);
    //$student = preg_replace ('/[^a-z0-9_]/i', '', $student);
    //$kombo = preg_replace ('/[^a-z0-9_]/i', '', $kombo);
    $price = preg_replace ('/[^0-9]/', '', $price);
    $id = is_player ($student);
    $nid = is_npc ($teacher);

    $q = do_mysql ("SELECT location, money, kombo FROM players WHERE id_player = '".$id."';");
    $p = mysql_fetch_assoc ($q);
    $q = do_mysql ("SELECT location FROM npc WHERE id_npc = '".$nid."';");
    $loc = mysql_result ($q, 0);
    if ($p['location'] != $loc) return 0;
    if ($p['money'] < $price) exit_msg ('комбо', 'у вас нехватает денег, надо '.$price.' серебра!');
    $kb = explode ('|', $p['kombo']);
    $c = count ($kb);
    $has = 0;
    for ($i = 0; $i < $c; $i++)
    {
      $kb[$i] = explode (':', $kb[$i]);
      if ($kb[$i][0] == $kombo) $has = 1;
    }
    if ($has) exit_msg ('комбо', 'вы уже yмеете этот прием!');

    $p['money'] -= $price;
    if (!$p['kombo']) $p['kombo'] = $kombo.':1:0';
    else $p['kombo'] .= '|'.$kombo.':1:0';
    do_mysql ("UPDATE players SET money = '".$p['money']."', kombo = '".$p['kombo']."' WHERE id_player = '".$id."';");
    exit_msg ('комбо', 'вы выучили новый прием!');
  }
?>