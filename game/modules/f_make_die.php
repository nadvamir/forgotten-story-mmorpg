<?php
  // umertvitq :)
  function make_die ($who)
  {
   // $who = preg_replace ('/[^a-z\._0-9]/i', '', $who);
    $id = is_npc ($who);
    $n = 0;
    if ($id)
    {
      $n = 1;
      $q = do_mysql ("SELECT name FROM npc WHERE id_npc = '".$id."';");
      $name = mysql_result ($q, 0);
      $q = do_mysql ("SELECT location FROM npc WHERE id_npc = '".$id."';");
    }
    else 
    {
      $id = is_player ($who);
      if (!$id) return 0;
      $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
      $name = mysql_result ($q, 0);
      $q = do_mysql ("SELECT location FROM players WHERE id_player = '".$id."';");
    }
    
    $loc_who = mysql_result ($q, 0);
    add_journal ($name.' погиб', 'l.'.$loc_who);

    // dlja kazhdogo po raznomu
    include_once ('modules/f_end_battle.php');
    // okonchitq bitvu
    end_battle ($who);
    if (!$n)
    {
      $p = get_pl_info ($who, 'all');
      // sozdatq trup:
      include_once ('modules/f_create_dead_body.php');
      create_dead_body ($who); // takzhe vypadut i veshi v trup
      //===========================================
      //if ($p['rase'] == 1 && $p['qlvl'] < 10) $loc = 'rele|2x11';  // ostavim do luchshih vremen
      //if ($p['rase'] == 2 && $p['qlvl'] < 10) $loc = 'epf1|4x1';
      //if ($p['rase'] == 3 && $p['qlvl'] < 10) $loc = 'nvsh|5x1';
      if ($p['qlvl'] == 0) $loc = 'novc|1x1';
      else $loc = 'rele|2x11';
      if ($p['karma'] < -99) $loc = 'pris|1x1';
      //===========================================
      /* potom ostalqnye */
      // statusy vernem na normalqnyj urovenq
      $p['status1'] = '01000';
      // zhiznq 10:
      if ($p['qlvl'] > 0) $life = '10|'.$p['life'][1];
      else $life = $p['life'][1] .'|'.$p['life'][1];
      do_mysql ("UPDATE players SET status1 = '".$p['status1']."', life = '".$life."' WHERE id_player = '".$id."';");
      include_once ('modules/f_teleport.php');
      teleport ($who, $loc);
    }
    else
    {
      include_once ('modules/f_real_name.php');
      // sozdatq trup:
      include_once ('modules/f_create_dead_body.php');
      create_dead_body ($who); // takzhe vypadut i veshi v trup
      // udalitq nafig
      do_mysql ("DELETE FROM npc WHERE id_npc = '".$id."';");
      $rfn = real_name ($who);
      global $pl_map;
      include 'modules/mapinfo/load_'.$pl_map.'.php';
      //print_r ($npc);
      //echo '<br/>'.$rfn;
      if (!isset ($npc)) return 1;
      if (array_key_exists ($rfn, $npc))
      {
        //echo "exists";
        // $npc podkljuchen v faile s_loadmaps.php
        // znachit nado vernutq
        $time = time();
        $time += 300;
        $nacti = 'npc|'.$rfn.'|'.$time;
        $act = do_mysql ("SELECT actions FROM maps WHERE map = '".$pl_map."';");
        $act = mysql_result ($act, 0);
        //echo '<br/>act = '.$act.'<br/>';
        $subc = substr_count ($act, $rfn);
        $itmp = explode (':', $npc[$rfn]);
        if ($itmp[2] > $subc)
        {
          if (!$act) $act = $nacti;
          else $act .= '~'.$nacti;
          //echo 'act = '.$act.'<br/>';
          do_mysql ("UPDATE maps SET actions = '".$act."' WHERE map = '".$pl_map."';");
        }
      }
    }
  }
?>