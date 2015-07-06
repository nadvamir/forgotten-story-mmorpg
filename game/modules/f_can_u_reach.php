<?php
  // funkcija proverjaet dosigaemostq
  function can_u_reach ($who, $loc_go, $stor, $depth = 1)
  {
    // lokacija
    $id = is_player ($who);
    if ($id)
    {
      $lq = do_mysql ("SELECT location FROM players WHERE id_player = '".$id."';");
      $loc = mysql_result ($lq, 0);
    }
    else
    {
      include_once ('modules/f_get_npc_info.php');
      $loc = get_npc_info ($who, 'location');
    }

    require_once 'modules/f_get_loc.php';
    $near = get_loc ($who, $stor, $depth);
    if (!$near || $near != $loc_go) return 0;
    return 1;
  }
?>