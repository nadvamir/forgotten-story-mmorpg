<?php
  // funkcija proverki ne rano li atakovatq
  // vozvratit 1 esli nerano ili 0 esli rano
  function check_last_attack ($pl, $re = 0)
  {
    //$pl = preg_replace ('/[^a-z0-9_\.]/i', '', $pl);
    $now = time();
    $id = is_player ($pl);
    if (!$id)
    {
      $id = is_npc ($pl);
      // npc
      $q = do_mysql ("SELECT lastattack, attack_speed FROM npc WHERE id_npc = '".$id."' AND lastattack < ".$now." - attack_speed;");
      if (!mysql_num_rows ($q)) return 0;
      $np = mysql_fetch_assoc ($q);
      $time = $np['attack_speed'];
      $last = array();
      $last[1] = $np['lastattack'];
    }
    else
    {
      $q = do_mysql ("SELECT last FROM players WHERE id_player = '".$id."';");
      $a = mysql_fetch_assoc ($q);
      $last = $a['last'];
      $last = explode ('|', $last);
      // ves oruzhija
      $q = do_mysql ("SELECT weight FROM items WHERE belongs = '".$pl."' AND is_in = 'wea';");
      if (mysql_num_rows($q))
      {
        $wgh = mysql_result ($q, 0);
        $q = do_mysql ("SELECT skills FROm players WHERE id_player = '".$id."';");
        $skills = mysql_result ($q, 0);
        $skills = explode ('|', $skills);
        $min = round ($skills[0] / 15);
        $time = $wgh - $min;
        if ($time < 3) $time = 3;
      }
      else $time = 2;
    }
    if ($re) $time = 0;

    // teperq effektami eto vremja - uvelichim ili umenqqshim:
    include_once ('modules/f_get_affected.php');
    // effecty:
    $aff = get_affected ($pl);
    if (is_in ('oglushen', $aff)) $time += 10;
    if (is_in ('odubel', $aff)) $time += 10;
    if (is_in ('zamerz', $aff)) $time += 10;
    if (is_in ('okamenel', $aff)) $time += 10;
    if (is_in ('paralizovan', $aff)) $time += 30;
    if (is_in ('ispugan', $aff)) $time += 10000;

    // esli eto otvetka, ostavim lishq vremja effekta

    if (is_in ('zamedlen', $aff)) $time *= 2;
    if ($last[1] <= $now - $time) return 1;
    return 0;
  }
?>