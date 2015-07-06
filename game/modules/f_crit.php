<?php
  // funkcija vozvrashjaet umnozhatelq na uron
  // toestq esli poluchilsja shans kritanutq, vozvrashjaet 2, esli net - 1;
  function crit ($login)
  {
    //$login = preg_replace ('/[^a-z-0-9_\.]/i', '', $login);
    $id = is_player ($login);
    if (!$id)
    {
      include_once ('modules/f_get_npc_info.php');
      $life = get_npc_info ($login, 'life');
      $life = explode ('|', $life);
      $cr = round (100 - $life[0] / $life[1] * 100);
      if (rand (0, 100) <= $cr) return 2;
      else return 1;
    }
    $p = do_mysql ("SELECT life, skills FROM players WHERE id_player = '".$id."';");
    $p = mysql_fetch_assoc ($p);
    $p['skills'] =  explode ('|', $p['skills']);
    $p['life'] = explode ('|', $p['life']);
    $cr = round (100 - $p['life'][0] / $p['life'][1] * 100 + $p['skills'][0]);
    include_once ('modules/f_get_affected.php');
    $aff = get_affected ($login);
    if (is_in ('ispugan', $aff)) return 1;
    if (rand (0, 100) <= $cr) return 2;
    else return 1;
  }
?>