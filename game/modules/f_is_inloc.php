<?php
  // proverka, estq li celq rjadom:
  function is_inloc ($login, $who)
  { 
    //$login = mysql_real_escape_string ($login);
    //$who = mysql_real_escape_string ($who);

    // lokacija igroka
    $id = is_player ($login);
    if ($id) $q = do_mysql ("SELECT location FROM players WHERE id_player = '".$id."';");
    else $q = do_mysql ("SELECT location FROM npc WHERE id_npc = '".(is_npc ($login))."';");
    if (!mysql_num_rows ($q)) return 0;
    $loc = mysql_result ($q, 0);

    $id = is_player ($who);
    if ($id) $q = do_mysql ("SELECT location FROM players WHERE id_player = '".$id."';");
    else $q = do_mysql ("SELECT location FROM npc WHERE id_npc = '".(is_npc ($who))."';");
    if (!mysql_num_rows ($q)) return 0;
    $loc2 = mysql_result ($q, 0);

    if ($loc == $loc2) return 1;
    return 0;
  }
?>