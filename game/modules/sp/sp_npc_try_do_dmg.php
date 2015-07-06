<?php
  // fragment koda gde npc na kotoryh napadaem pytajutsja napastq
  include_once ('modules/f_npc_try_do_dmg.php');
  $q1 = do_mysql ("SELECT id_npc FROM npc WHERE location = '".$p['location']."' AND in_battle = 1;");
  $q1p = do_mysql ("SELECT id_player FROM players WHERE location = '".$p['location']."' AND in_battle = 1;");
  $q2 = do_mysql ("SELECT id_npc FROM npc WHERE location = '".$p['location']."' AND in_battle = 2;");
  $q2p = do_mysql ("SELECT id_player FROM players WHERE location = '".$p['location']."' AND in_battle = 2;");
  if ((!mysql_num_rows ($q1) && !mysql_num_rows ($q1p)) || (!mysql_num_rows ($q2) && !mysql_num_rows ($q2p)) ) do_mysql ("UPDATE npc SET in_battle = '0' WHERE location = '".$p['location']."';");

  include_once ('modules/f_comp_reaction.php');
  $q = do_mysql ("SELECT id_npc, fullname, in_battle FROM npc WHERE location = '".$p['location']."' AND in_battle <> '0' AND in_battle <> '';");
  while ($n = mysql_fetch_assoc ($q))
  {
    // dlja kazhdogo berem ego in_battle i napadaem na sluchajnogo
    $aff = get_affected ($n['fullname']);
    if (is_in ('oglushen', $aff)) continue;
    if (is_in ('zamerz', $aff)) continue;
    if (is_in ('okamenel', $aff)) continue;
    if (is_in ('odubel', $aff)) continue;
    $tob = 0;
    if ($n['in_battle'] == 1) $tob = 2;
    else $tob = 1;
    $inb = array();
    $c = 0;
    $q2 = do_mysql ("SELECT login FROM players WHERE location = '".$p['location']."' AND in_battle = '".$tob."' AND active <> '0';");
    $c = mysql_num_rows ($q2);
    while ($inb[] = mysql_fetch_assoc ($q2))
    {
    }
    $q2 = do_mysql ("SELECT fullname FROM npc WHERE location = '".$p['location']."' AND in_battle = '".$tob."';");
    $c += mysql_num_rows ($q2);
    while ($inb[] = mysql_fetch_assoc ($q2))
    {
    }
    
    while (1)
    {
      if ($c == 0) break;
      $num = array_rand ($inb);
      if (isset ($inb[$num]['login'])) 
      {
        // esli npc tolqko chto prishel - ne atakuem, 
        if (isset ($NPC_MOVED[$n['id_npc']]))
          if (!comp_reaction ($n['fullname'], $inb[$num]['login']))
            break;

        $a = npc_try_do_dmg ($n['fullname'], $inb[$num]['login']);
        break;
      }
      else if (isset ($inb[$num]['fullname'])) 
      {
        if (isset ($NPC_MOVED[$n['id_npc']]))
          if (!comp_reaction ($n['fullname'], $inb[$num]['fullname']))
            break;
        $a = npc_try_do_dmg ($n['fullname'], $inb[$num]['fullname']);
        break;
      }
    }
  }
  $p = get_pl_info ($LOGIN, 'all');
?>