<?php
  // funkcija pytaetsja udaritq
  // atakuet npc, napadaet na kogo ugodno
  function npc_try_do_dmg ($off, $pass)
  {
    //$off = preg_replace ('/[^a-z0-9_\.]/i', '', $off);
    //$pass = preg_replace ('/[^a-z0-9_\.]/i', '', $pass);
    if (!$off || !$pass) return 0;
    $id = is_npc ($off);
    if (!$id) return 0;
    include_once ('modules/f_check_dead.php');
    
    // proverjaem uspeshnostq ataki:
    include_once ('modules/f_is_attack_successful.php');
    $result = is_attack_successful ($off, $pass);
    if ($result)
    {
      // vse, delaem uron
      include_once ('modules/f_do_dmg.php');
      if ($result > 1) $PAR = 0;
      else $PAR = 1;

      do_dmg ($off, $pass, 'NONE', $PAR);
    }
    else return 0;

    ///////////////////////////////////////////////////////////////////////////////////
    // podvodim itogi
    // zhiv li
    include_once ('modules/f_check_dead.php');
    if (check_dead($pass))
    {
      // esli komu-to prinadlezhit, to obnovitq i ego reiting
      $q = do_mysql ("SELECT belongs FROM npc WHERE id_npc = '".$id."';");
      $bel = mysql_result ($q, 0);
      if ($bel)
      {
        $id = is_player ($pass);
        if ($id)
          do_mysql ("UPDATE players SET playerkill = playerkill + 1 WHERE login = '".$bel."';");
        else
          do_mysql ("UPDATE players SET monsterkill = monsterkill + 1 WHERE login = '".$bel."';");
      }
      // uvelichenie reitinga pobed:
      if (is_player ($pass))
      {
        do_mysql ("UPDATE npc SET playerkill = playerkill + 1 WHERE id_npc = '".$id."';");
      }
      else
      {
        do_mysql ("UPDATE npc SET monsterkill = monsterkill + 1 WHERE id_npc = '".$id."';");
      }
      include_once ('modules/f_make_die.php');
      make_die ($pass);
      return 1;
    }
    ///////////////////////////////////////////////////////////////////////////////////
    // otvetka, esli reakcija pozvolit
    include_once ('modules/f_comp_reaction.php');
    if (comp_reaction ($pass, $off) == 1)
    {
       
      // proverjaem uspeshnostq ataki:
      include_once ('modules/f_is_attack_successful.php');
      $result = is_attack_successful ($pass, $off, 1);
      if ($result)
      {
        // vse, delaem uron
        include_once ('modules/f_do_dmg.php');
        if ($result > 1) $PAR = 0;
        else $PAR = 1;

        do_dmg ($pass, $off, 'NONE', $PAR);
      }
      else return 0;
      ///////////////////////////////////////////////////////////////////////////////////
      // podvodim itogi
      // zhiv li
      include_once ('modules/f_check_dead.php');
      if (check_dead($off))
      {
        // uvelichenie reitinga pobed:
        $id = is_player ($pass);
        if ($id)
        {
          do_mysql ("UPDATE players SET monsterkill = monsterkill + 1 WHERE id_player = '".$id."';");
        }
        else
        {
          $id = is_npc ($pass);
          do_mysql ("UPDATE npc SET monsterkill = monsterkill + 1 WHERE id_npc = '".$id."';");
          // esli komu-nibudq prinadlezhit, obnovim egoo reiting
          $q = do_mydql ("SELECT belongs FROM npc WHERE id_npc = '".$id."';");
          $bel = mysql_result ($q, 0);
          if ($bel)
            do_mysql ("UPDATE players SET monsterkill = monsterkill + 1 WHERE login = '".$bel."';");
        }
        include_once ('modules/f_make_die.php');
        make_die ($off);
        return 1;
      }
    }
    return 1;
  }
?>