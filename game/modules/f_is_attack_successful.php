<?php
  // fajl kotoryj sravnivaet shansy nanesti uron, i vozvrashjaet odno iz vozmozhnyh variaantov
  // 0 - libo uklon libo ataka ne udalasq, 1 parirovanie, 2 polnocennyj udar
  // takzhe esli uklonilisq ili tam parirovali, to eto zapisyvaetsja v zhurnal
  function is_attack_successful ($who, $to, $re = 0)
  {
    // re oznachaet chto udar otvetnyj.
    // a esli udar otvetnyj, mozhno ne smotretq mozhet li on atakovatq, i ne fiksirovatq
    // etoj funkciej budem sravnivatq shansy
    include_once ('modules/f_get_chanses.php');
    // proverjaem effekty
    // esli odin iz paralizujushih, to vsegda kto-to proigraet/vyjgraet
    include_once ('modules/f_get_affected.php');
    $aff = get_affected ($who);
    if (is_in ('oglushen', $aff)) return 0;
    if (is_in ('zamerz', $aff)) return 0;
    if (is_in ('okamenel', $aff)) return 0;
    if (is_in ('odubel', $aff)) return 0;
    if (is_in ('paralizovan', $aff)) return 0;
    $aff = get_affected ($to);
    if (is_in ('oglushen', $aff)) return 1;
    if (is_in ('zamerz', $aff)) return 1;
    if (is_in ('okamenel', $aff)) return 1;
    if (is_in ('odubel', $aff)) return 1;
    if (is_in ('paralizovan', $aff)) return 1;
    
    
    $wid;
    $who_ranged = 0;
    $pi = is_player ($who);
    if ($pi)
    {
      $wid = $pi;
      // berem informaciju igroka
      // shansy nanesti udar
      include_once ('modules/f_get_pl_battle_har.php');
      $who_har = get_pl_battle_har ($who);
      // kakoe oruzhie. toestq rasschityvatq li po sisteme dalqnego boja ili blizhnego
      // esli who_ranged == 1,, to togda schitajutsja formuly luchnikov
      $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$who."' AND is_in = 'wea'");
      if (!mysql_num_rows ($q)) $who_ranged = 0;
      else $who_ranged = mysql_result ($q, 0);
      if (substr ($who_ranged, 4, 3) == 'bow' || substr ($who_ranged, 4, 3) == 'arb') $who_ranged = 1;
      else $who_ranged = 0;
      // zhiznq igroka dlja shansov (massiv)
      $q = do_mysql ("SELECT life FROM players WHERE id_player = '".$wid."';");
      $who_life = mysql_result ($q, 0);
      $who_life = explode ('|', $who_life);
      // proverka onlajn:
      do_mysql ("SELECT active FROM players WHERE id_player = '".$wid."';");
      $active = mysql_result ($q, 0);
      if (!$active)
      {
        include_once ('modules/f_end_battle.php');
        end_battle ($who);
      }
    }
    else
    {
      $wid = is_npc ($who);
      if (!$wid) return -1;
      // informacija npc :
      include_once ('modules/f_get_npc_battle_har.php');
      $who_har = get_npc_battle_har ($who);
      // napadatq s dali nemozhet npc      
      // zhiznq npc dlja shansov (massiv)
      $q = do_mysql ("SELECT life FROM npc WHERE id_npc = '".$wid."';");
      $who_life = mysql_result ($q, 0);
      $who_life = explode ('|', $who_life);
    }
    
    // proverka vremeni ataki
    include_once ('modules/f_check_last_attack.php');
    if (!check_last_attack ($who, $re)) return -1; // esli ataka ne vovremja (s uchetom otvetki)
    //  obnovim posledniju ataku, takzhe s uchetom otvetki
    if (!$re)
    {
      // ne proverjaem estq li patrony, lenq, proverim v do_dmg
      include_once ('modules/f_upd_last_attack.php');
      upd_last_attack ($who);
    }
    else
    {
      $aff = get_affected ($to);
      if (is_in ('ispugan', $aff)) return 0; // pri ispuge otvetka nevozmozhna
    }

    // harakteristika zawiwajusjago
    $tid;
    $pi = is_player ($to);
    if ($pi)
    {
      $tid = $pi;
      // berem informaciju igroka
      // shansy nanesti udar
      include_once ('modules/f_get_pl_battle_har.php');
      $to_har = get_pl_battle_har ($to);
      // estq li shit (1, 0)
      $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$to."' AND is_in = 'shi' AND type = 'x'");
      $to_shield = mysql_result ($q, 0);
      // zhiznq igroka dlja shansov (massiv)
      $q = do_mysql ("SELECT life FROM players WHERE id_player = '".$tid."';");
      $to_life = mysql_result ($q, 0);
      $to_life = explode ('|', $to_life);
      // proverka onlajn:
      do_mysql ("SELECT active FROM players WHERE id_player = '".$tid."';");
      $active = mysql_result ($q, 0);
      if (!$active)
      {
        include_once ('modules/f_end_battle.php');
        end_battle ($to);
      }
    }
    else
    {
      $tid = is_npc ($to);
      if (!$tid) return -1;
      // informacija npc :
      include_once ('modules/f_get_npc_battle_har.php');
      $to_har = get_npc_battle_har ($to);
      // napadatq s dali nemozhet npc      
      // zhiznq npc dlja shansov (massiv)
      $q = do_mysql ("SELECT life FROM npc WHERE id_npc = '".$tid."';");
      $to_life = mysql_result ($q, 0);
      $to_life = explode ('|', $to_life);
    }
    
    // proschityvaem shansy - 
    $ch = get_chanses ($who_har, $who_life, $to_har, $to_life);
    // sluchajnoe chislo
    $rnd = rand (0, 100);
    if ($rnd <= $ch[1][1])
    {
      // udar blokirovan:
      if ($who_ranged)
      {
        include_once ('modules/f_promah.php');
        promah ($who);
      }
      else
      {
        include_once ('modules/f_block.php');
        block ($to);
      }
      $NO = 1;
    }
    else
    {
      $ntdl = rand (0, 1);
      if ($ntdl == 0)
      {
        if ($who_ranged)
        {
          if (rand (0, 100) <= $ch[1][8])
          {
            // uklonimsja
            include_once ('modules/f_uklon.php');
            uklon ($to);
            $NO = 1;
          }
        }
        else
        {
          if (rand (0, 100) <= $ch[1][2])
          {
            // uklonimsja
            include_once ('modules/f_uklon.php');
            uklon ($to);
            $NO = 1;
          }
        }
      }
      else
      {
        if ($who_ranged)
        {
          if (rand (0, 100) <= $ch[1][3])
          {
            // pariruem
            return 1;
          }
        }
        else
        {
          if (rand (0, 100) <= $ch[1][9])
          {
            // pariruem
            return 1;
          }
        }
      }
    }
    
    
    if (isset ($NO))
    {
      // esli streljaem, nado rashodovatq strely, esli promahnulisq ili uklon. inache rashoduem v do_dmg
      if ($who_ranged)
      {
        // rashoduem odnu strelu
        include_once ('modules/f_decr_abstr_misc.php');
        if (!decr_abstr_misc ('i.m.arr.arr', $who, 1)) add_journal ('нехватает припасoв!', $who);
      }
      return 0;
    }
    //esli vse horosho, vozvrashjaem 2:
    return 2;
  }
?>