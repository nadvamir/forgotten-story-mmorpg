<?php
  // fail samoj ataki
  $who = $LOGIN;
  $to = preg_replace ('/[^a-z0-9_\.-]/i', '', $_GET['to']);
  if (isset ($_GET['type'])) $type = preg_replace ('/[^a-z]/', '', $_GET['type']);
  else $type = 'NONE';
  
  include_once ('modules/f_check_dead.php');
  
  // napadaem:
  include_once ('modules/f_attack.php');
  attack ($who, $to);
  
  // proverjaem uspeshnostq ataki:
  include_once ('modules/f_is_attack_successful.php');
  $result = is_attack_successful ($who, $to);
  if ($result)
  {
    // vse, delaem uron
    include_once ('modules/f_do_dmg.php');
    if ($result > 1) $PAR = 0;
    else $PAR = 1;

    do_dmg ($who, $to, $type, $PAR);
  }
  else include 'modules/s_main.php';
  ///////////////////////////////////////////////////////////////////////////////////
  // podvodim itogi
  // zhiv li
  include_once ('modules/f_check_dead.php');
  if (check_dead($to))
  {
    // uvelichenie reitinga pobed:
    // snimem karmu
    $id = is_player ($to);
    if ($id)
    {
      do_mysql ("UPDATE players SET playerkill = playerkill + 1 WHERE id_player = '".$p['id_player']."';");
      // dela s karmoj svjazanye
      $q = do_mysql ("SELECT status1, karma, location, clan FROM players WHERE id_player = '".$id."';");
      $def = mysql_fetch_assoc ($q);
      if ($def['status1'][0] != 1 && $def['status1'][0] != 2 && substr ($def['location'], 0, 4) != 'pris' && substr ($def['location'], 0, 3) != 'are')
      {
        // proverim togda vojnu klanovuju - 
        $att['clan'] = $p['clan'];
        $def['clan'] = explode ('|', $def['clan']);
        $q = do_mysql ("SELECT politics FROM clans WHERE clanname = '".$att['clan'][0]."';");
        if (!mysql_num_rows ($q)) $pol = '';
        $pol = mysql_result ($q, 0);
        $pol = explode ('|', $pol); // 0 - war
        if (!is_in ($def['clan'][0], $pol[0]))
        {
          if ($p['karma'] > 0) $p['karma'] = -10;
          else $p['karma'] -= 10;
          $p['status1'][0] = 1;
          do_mysql ("UPDATE players SET karma = '".$p['karma']."', status1 = '".$p['status1']."' WHERE id_player = '".$p['id_player']."';");
        } 
      }
    }
    else
    {
      do_mysql ("UPDATE players SET monsterkill = monsterkill + 1 WHERE id_player = '".$p['id_player']."';");
    }

    include_once ('modules/f_make_die.php');
    make_die ($to);
    include 'modules/s_main.php';
  }
  ///////////////////////////////////////////////////////////////////////////////////
  // otvetka, esli reakcija pozvolit
  include_once ('modules/f_comp_reaction.php');
  if (comp_reaction ($to, $who) == 1)
  {
    // proverjaem uspeshnostq ataki:
    include_once ('modules/f_is_attack_successful.php');
    $result = is_attack_successful ($to, $who, 1);
    if ($result)
    {
      // vse, delaem uron
      include_once ('modules/f_do_dmg.php');
      if ($result > 1) $PAR = 0;
      else $PAR = 1;

      do_dmg ($to, $who, 'NONE', $PAR);
    }
    //////////////////////////////////////////////////////////////////////////////
    // podvodim itogi
    if (check_dead($who))
    {
      $id = is_player ($to);
      if ($id)
      {
        do_mysql ("UPDATE players SET playerkill = playerkill + 1 WHERE id_player = '".$id."';");
        // dela s karmoj svjazanye
        $q = do_mysql ("SELECT status1, karma, location, clan FROM players WHERE id_player = '".$id."';");
        $att = mysql_fetch_assoc ($q);
        if ($p['status1'][0] != 1 && $p['status1'][0] != 2 && substr ($p['location'], 0, 4) != 'pris' && substr ($p['location'], 0, 3) != 'are')
        {
          // proverim togda vojnu klanovuju - 
          $att['clan'] = explode ('|', $att['clan']);
          $q = do_mysql ("SELECT politics FROM clans WHERE clanname = '".$att['clan'][0]."';");
          if (!mysql_num_rows ($q)) $pol = '';
          $pol = mysql_result ($q, 0);
          $pol = explode ('|', $pol); // 0 - war
          if (!is_in ($p['clan'][0], $pol[0]))
          {
            if ($att['karma'] > 0) $att['karma'] = -10;
            else $att['karma'] -= 10;
            $att['status1'][0] = 1;
            do_mysql ("UPDATE players SET karma = '".$att['karma']."', status1 = '".$att['status1']."' WHERE id_player = '".$id."';");
          } 
        }
      }
      else
      {
        $id = is_npc ($to);
        do_mysql ("UPDATE npc SET playerkill = playerkill + 1 WHERE id_npc = '".$id."';");
      }
      include_once ('modules/f_make_die.php');
      make_die ($who);
    }
  }
?>