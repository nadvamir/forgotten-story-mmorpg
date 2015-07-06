<?php
  // fragment koda gde npc napadaet na igroka
  // $inloc ukazan v game.php
  $q = do_mysql ("SELECT id_npc, fullname, realname FROM npc WHERE location = '".$p['location']."' AND type = 'x' AND (belongs = '0' OR belongs = '') AND location NOT LIKE 'rele%' AND location NOT LIKE 'elfc%' AND location NOT LIKE 'verg%' AND realname <> 'n.x.golem';");
  while ($n = mysql_fetch_assoc ($q))
  {
      $aff = get_affected ($n['fullname']);
      if (is_in ('oglushen', $aff)) continue;
      if (is_in ('zamerz', $aff)) continue;
      if (is_in ('okamenel', $aff)) continue;
      if (is_in ('odubel', $aff)) continue;
    do_mysql ("UPDATE npc SET in_battle = '1' WHERE id_npc = '".$n['id_npc']."';");
    do_mysql ("UPDATE players SET in_battle = '2' WHERE location = '".$p['location']."' AND (in_battle = '0' OR in_battle = '') AND active = '1';");
    do_mysql ("UPDATE npc SET in_battle = '2' WHERE location = '".$p['location']."' AND (in_battle = '0' OR in_battle = '') AND (type = 'x' OR type = 'a');");
  }

  $q = do_mysql ("SELECT id_npc, fullname FROM npc WHERE realname = 'n.x.golem';");
  while ($n = mysql_fetch_assoc ($q))
  {
      $aff = get_affected ($n['fullname']);
      if (is_in ('oglushen', $aff)) continue;
      if (is_in ('zamerz', $aff)) continue;
      if (is_in ('okamenel', $aff)) continue;
      if (is_in ('odubel', $aff)) continue;
    $qc = do_mysql ("SELECT belongs FROM castle WHERE name = 'telir'");
    $bel = mysql_result ($qc, 0);
    if ($bel == $p['clan'][0]) continue;
    do_mysql ("UPDATE npc SET in_battle = '1' WHERE id_npc = '".$n['id_npc']."';");
    do_mysql ("UPDATE players SET in_battle = '2' WHERE location = '".$p['location']."' AND (in_battle = '0' OR in_battle = '') AND active = '1';");
    do_mysql ("UPDATE npc SET in_battle = '2' WHERE location = '".$p['location']."' AND (in_battle = '0' OR in_battle = '') AND (type = 'x' OR type = 'a');");
  }
  $p = get_pl_info ($LOGIN, 'all');
?>