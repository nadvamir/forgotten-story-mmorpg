<?php
  // funkcija vozvrashjaet deistvujushie effekty:
  function get_affected ($name)
  {
    //$name = preg_replace ('/[^a-z\._0-9]/i', '', $name);
    // pokachto tolqko chelam:
    $id = is_player ($name);
    if ($id)
    {
      $q = do_mysql ("SELECT affected FROM players WHERE id_player = '".$id."';");
      $a = mysql_result ($q, 0);
    }
    else
    {
      $id = is_npc ($name);
      if (!$id) return 0;
      $q = do_mysql ("SELECT affected FROM npc WHERE id_npc = '".$id."';");
      if (!mysql_num_rows ($q)) return 0;
      $a = mysql_result ($q, 0);
    }

    if (!$a) return 0;
    $a = explode ('|', $a);
    $c = count ($a);
    for ($i = 0; $i < $c; $i++)
    {
       $a[$i] = explode (':', $a[$i]);
       $arr[] = $a[$i][0];
    }
    return $arr;
  }
?>