<?php
  // proverka reakcii (bystree u napadajushego ili net 
  function comp_reaction ($off, $pass)
  {
    //$off = preg_replace ('/[^a-z0-9_\.]/i', '', $off);
    //$pass = preg_replace ('/[^a-z0-9_\.]/i', '', $pass);
    include_once ('modules/f_get_affected.php');
    $aff = get_affected ($off);
    if (is_in ('oglushen', $aff)) return 0;
    if (is_in ('zamerz', $aff)) return 0;
    if (is_in ('okamenel', $aff)) return 0;
    if (is_in ('odubel', $aff)) return 0;
    if (is_in ('paralizovan', $aff)) return 0;
    $aff = get_affected ($pass);
    if (is_in ('oglushen', $aff)) return 1;
    if (is_in ('zamerz', $aff)) return 1;
    if (is_in ('okamenel', $aff)) return 1;
    if (is_in ('odubel', $aff)) return 1;
    if (is_in ('paralizovan', $aff)) return 1;
    $id = is_npc ($off);
    if ($id)
    {
      $q = do_mysql ("SELECT dex FROM npc WHERE id_npc = '".$id."';");
      if (!mysql_num_rows ($q)) return 0;
      $rea_off = mysql_result ($q, 0);
    }
    else
    {
      $id = is_player ($off);
      $q = do_mysql ("SELECT skills FROM players WHERE id_player = '".$id."';");
      if (!mysql_num_rows ($q)) return 0;
      $off_s = mysql_result ($q, 0);
      $off_s = explode ('|', $off_s);
      $rea_off = $off_s[1];
    }

    $id = is_npc ($pass);
    if (is_npc ($pass))
    {
      $q = do_mysql ("SELECT rea FROM npc WHERE id_npc = '".$id."';");
      if (!mysql_num_rows ($q)) return 0;
      $rea_pass = mysql_result ($q, 0);
    }
    else
    {
      $id = is_player ($pass);
      $q = do_mysql ("SELECT skills FROM players WHERE id_player = '".$id."';");
      if (!mysql_num_rows ($q)) return 0;
      $pass_s = mysql_result ($q, 0);
      $pass_s = explode ('|', $pass_s);
      $rea_pass = $pass_s[3];
    }

    $ch = $rea_off * 100 / ($rea_off + $rea_pass);
    if (rand (0, 100) <= $ch) return 1;
    else return 0;
  }
?>
    