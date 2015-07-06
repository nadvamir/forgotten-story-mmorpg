<?php
  // funkcija poluchaet lokaciju v dali po tomu napravl;enija, ili 0, esli netu takoj
  function get_loc ($who, $stor, $depth = 1)
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
    $near = loc ($loc, 'near');
    $lc = $near[$stor][0];
    if (!$lc) return 0;
    if ($depth == 2)
    {
      unset ($near);
      $near = loc ($lc, 'near');
    }
    if (!isset ($near[$stor][0])) return 0;
    return $near[$stor][0];
  }
?>