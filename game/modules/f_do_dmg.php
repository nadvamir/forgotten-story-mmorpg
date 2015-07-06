<?php
  // funkcija delaet uron
  // sama podschityvaet ego, i uchityvaet bronju
  // dobovljaet infu v zhurnaly
  // takzhe proverjaet rasstojanie mezhdu igrokami, mozhno li nanesti uron
  function do_dmg ($who, $to, $type, $PAR, $KOMBO = 1)
  {
    include_once ('modules/f_get_dmg.php');
    include_once ('modules/f_get_armor.php');

    ////////////////////////////// NAPADAJUSHIJ /////////////////////
    // esli napadajushij igrok to uron poluchim funkciej, esli npc to vozqmem sami:
    $wid;
    $pi = is_player ($who);
    if ($pi)
    {
      $wid = $pi;
      include_once ('modules/f_get_dmg.php');
      $dmg = get_dmg ($who);

      // lomaem mechq
      include_once ('modules/f_damage_weapons.php');
      damage_weapons ($who);

      // razberemsja s oruzhiem, dobavim effekty i oglushim esli eto drob uron (prodelaet eto funkcija)
      $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$who."' AND is_in = 'wea';");
      if (!mysql_num_rows ($q)) $weapon = '';
      else $weapon = mysql_result ($q, 0);
      if ($weapon)
      {
        include_once ('modules/f_set_w_effects.php');
        set_w_effects ($weapon, $type, $to);
      }
      
      // lokacija igroka
      $q = do_mysql ("SELECT location FROM players WHERE id_player = '".$wid."';");
      $who_loc = mysql_result ($q, 0);
      // letaet li
      $q = do_mysql ("SELECT walking FROM players WHERE id_player = '".$wid."';");
      $who_fly = mysql_result ($q, 0);
      $q = do_mysql ("SELECT clan FROM players WHERE id_player = '".$wid."';");
      $who_clan = mysql_result ($q, 0);
      $who_clan = explode ('|', $who_clan);
    }
    else
    {
      $wid = is_npc ($who);
      $npc = 1;
      if (!$wid) return 0;
      $q = do_mysql ("SELECT dmg FROM npc WHERE id_npc = '".$wid."';");
      if (!mysql_num_rows ($q)) return 0;
      $dmg = mysql_result ($q, 0);
      $dmg = explode ('~', $dmg);
      for ($i = 0; $i < 5; $i++) $dmg[$i] = explode ('-', $dmg[$i]);
      $weapon = '';
      
      // lokacija npc
      $q = do_mysql ("SELECT location FROM npc WHERE id_npc = '".$wid."';");
      $who_loc = mysql_result ($q, 0);
      // effekt
      $q = do_mysql ("SELECT effect FROM npc WHERE id_npc = '".$wid."';");
      $who_effect = mysql_result ($q, 0);
      // letanie
      $q = do_mysql ("SELECT move FROM npc WHERE id_npc = '".$wid."';");
      $who_fly = mysql_result ($q, 0);
      if ($who_fly != 7) $who_fly = 0;
      else $who_fly = 2;
    }

    //////////////////////////// ORONJAJUSHIJSJA ////////////////////
    $ni = is_npc ($to);
    if ($ni)
    {
      $tid = $ni;
      $tonpc = 1;
      $q = do_mysql ("SELECT armor FROM npc WHERE id_npc = '".$tid."';");
      if (!mysql_num_rows ($q)) return 0;
      $armor = mysql_result ($q, 0);
      $armor = explode ('~', $armor);
      // lokacija npc
      $q = do_mysql ("SELECT location FROM npc WHERE id_npc = '".$tid."';");
      $to_loc = mysql_result ($q, 0);
      // letanie
      $q = do_mysql ("SELECT move FROM npc WHERE id_npc = '".$tid."';");
      $to_fly = mysql_result ($q, 0);
      if ($to_fly != 7) $to_fly = 0;
      else $to_fly = 2;
      // golem soklana - 
      $q = do_mysql ("SELECT fullname FROM npc WHERE id_npc = '".$tid."';");
      $to_fn = mysql_result ($q, 0);
      if ( $to_fn == 'n.x.golem' && isset ($who_clan) )
      {
        $qc = do_mysql ("SELECT belongs FROM castle WHERE name = 'telir'");
        $bel = mysql_result ($qc, 0);
        if ($bel == $who_clan[0]) return 1;
      }
    }
    else
    {
      $tid = is_player ($to);
      if (!$tid) return 0;
      $armor = get_armor($to);

      // lomaem bronju
      include_once ('modules/f_damage_armor.php');
      damage_armor ($to, $PAR);

      // lokacija igroka
      $q = do_mysql ("SELECT location FROM players WHERE id_player = '".$tid."';");
      $to_loc = mysql_result ($q, 0);

      // letit li igrok
      $q = do_mysql ("SELECT walking FROM players WHERE id_player = '".$tid."';");
      $to_fly = mysql_result ($q, 0);
    }

    if ($to_fly == 2 && substr ($weapon, 4, 3) != 'bow' && substr ($weapon, 4, 3) != 'arb' && $who_fly != 2)
    {
      // nelzja dostatq
      include_once ('modules/f_comp_reaction.php');
      if (!comp_reaction ($who, $to) || !comp_reaction ($who, $to) || !comp_reaction ($who, $to))
      {
        add_journal ('нелзя так просто достать летящего!', $who);
        return 0;
      }
    }
    
    if (substr ($weapon, 4, 3)  == 'bow' || substr ($weapon, 4, 3)  == 'arb') $RANGE = 1;
    else $RANGE = 0;
    ////////////////////////////// lokacija ////////////////////////////
    if ($who_loc != $to_loc)
    {
      // esli ne na odnoj lokacii
      // ne dalqnostreljajushimi streljatq nelzja
      if (!$RANGE)
      {
        add_journal ('1цель недоступна', $who);
        return 0;
      }
      // dalee berem zapros na okruzhajushie lokacii
      include_once ('modules/f_loc.php');
      $near = loc ($who_loc, 'near');
      // teperq nado proveritq, netu li gde nechajanno takoj lokacii
      $all_ok = 0;
      for ($i = 1; $i < 9; $i++)
      {
        if (!isset($near[$i])) continue;
        if ($near[$i][0] == $to_loc)
          $all_ok = 1;
      }
      if (!$all_ok)
      {
        // nanesti uron nelzja:
        add_journal ('цель недоступна', $who);
        return 0;
      }
      ////////////////////////////////////
      // TUT NPC HODJAT K LUCHNIKAM :D
      ////////////////////////////////////
      if (isset ($tonpc))
      {
        include_once ('modules/f_comp_reaction.php');
        if (comp_reaction ($to, $who)) do_mysql ("UPDATE npc SET location = '".$who_loc."' WHERE id_npc = '".$tid."';");
      }
    }
    
    if ($RANGE)
    {
      // rashoduem odnu strelu
      include_once ('modules/f_decr_abstr_misc.php');
      if (!decr_abstr_misc ('i.m.arr.arr', $who, 1)) { add_journal ('нехватает припасoв!', $who); return 0; }
    }

    ////////////////////////////// podschet urona //////////////////////
    switch ($type)
    {
      case 'rez': $num = 0; break;
      case 'kol': $num = 1; break;
      case 'drob': $num = 2; break;
      case 'rub': $num = 3; break;
      case 'mag': $num = 4; break;
      default: $tmp = 1;
    }
    if (isset ($tmp))
    {
      // vyberem sami nomer:
      do 
      {
        $arr = array ('rez', 'kol', 'drob', 'rub');
        if (!$dmg[0][1] && !$dmg[1][1] && !$dmg[2][1] && !$dmg[3][1] || isset ($npc)) { $arr[4] = 'mag'; }
        $num = array_rand ($arr);
        $type = $arr[$num];
      }
      while (!$dmg[$num][1]);
    }
    $damage = rand ($dmg[$num][0], $dmg[$num][1]);
    include_once ('modules/f_crit.php');
    $crit = crit ($who);
    $damage *= $crit;
    // kombo
    $damage *= $KOMBO;
    if ($crit > 1) $CR = 1;
    else $CR = 0;
    if ($damage == 0) $CR = 0;

    /////////////////////////////
    // magicheskij uron
    if ($dmg[4][1] > 0 && $type != 'mag')
    {
      $mdamage = rand ($dmg[4][0], $dmg[4][1]);
      $marm = $armor[4];
      $mdamage -= $marm;
      if ($mdamage < 0) $mdamage = 0;
    }
    else
      $mdamage = 0;

    //////////////////////// parirovanie //////////////////////
    if ($PAR && is_player ($to) && $type != 'mag')
    {
      $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$to."' AND is_in = 'shi' AND type = 'x';");
      if (mysql_num_rows ($q))
      {
        $shi = mysql_result ($q, 0);
        $q = do_mysql ("SELECT armor FROM items WHERE fullname = '".$shi."';");
        $shi_arm = mysql_result ($q, 0);
        $shi_arm = explode ('~', $shi_arm);
        $sta = round($shi_arm[$num] * 0.9);
        $shi_m = rand ($sta, $shi_arm[$num]);
        $damage -= $shi_m;
      }
    }

    ////////////////////////////
    // bronja
    $arm = $armor[$num];
    $damage -= $arm;
    if ($damage < 0) $damage = 1;
    $damage = round ($damage);
    ////////////////////////////

    //////////////////////////// dalaem uron ////////////////////
    if (is_npc ($to))
    {
      $q = do_mysql ("SELECT life FROM npc WHERE id_npc = '".$tid."';");
    }
    else if (is_player ($to))
    {
      $q = do_mysql ("SELECT life FROM players WHERE id_player = '".$tid."';");
    }
    $life = mysql_result ($q, 0);
    $life = explode ('|', $life);
    if ($damage > $life[0]) $damage = $life[0];
    $life[0] -= $damage;
    if ($mdamage) $life[0] -= $mdamage;
    if ($life[0] < 0) $life[0] = 0;
    $nlife = $life[0].'|'.$life[1];
    
    ///////////////////////EFFEKTY URONA NPC ///////////////
    if (isset ($who_effect) && $who_effect)
    {
      if (rand (0, 100) < 33)
      {
        include_once ('modules/f_set_affected.php');
        set_affected ($to, $who_effect);
      }
    }
    /////////////////////// ITOGI ////////////////////////////

    if ($CR)
    {
      include_once ('modules/f_start_blood.php');
      if (rand (0, 100) < 33) start_blood ($to);
      $cz = '!!!';
    }
    else $cz = '';

    if (substr ($to, 0, 2) == 'n.')
      do_mysql ("UPDATE npc SET life = '".$nlife."' WHERE id_npc = '".$tid."';");
    else
      do_mysql ("UPDATE players SET life = '".$nlife."' WHERE id_player = '".$tid."';");
    //include_once ('modules/f_add_b_journal.php');
    if (substr ($who, 0, 2) == 'n.')
    {
      $q = do_mysql ("SELECT name FROM npc WHERE id_npc = '".$wid."';");
      $name = mysql_result ($q, 0);
    }
    else
    {
      $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$wid."';");
      $name = mysql_result ($q, 0);
    }
    if (substr ($to, 0, 2) == 'n.')
    {
      $q = do_mysql ("SELECT name FROM npc WHERE id_npc = '".$tid."';");
      $name2 = mysql_result ($q, 0);
    }
    else
    {
      $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$tid."';");
      $name2 = mysql_result ($q, 0);
    }
    if ($mdamage) $mt = '< -'.$mdamage.'(M)>';
    else $mt = '';
    if (isset($shi_m)) $st = '< +'.$shi_m.'(X)>';
    else $st = '';
    // tip urona
    include_once ('modules/f_translit.php');
    $type = translit ($type);
    // chem napadali
    include_once ('modules/f_attacked_with.php');
    $attw = attacked_with ($weapon);

    if ($to_loc == $who_loc) add_journal ($name2.' - '.$damage.''.$cz.' [D: '.$arm.']'.$st.''.$mt.' ('.$name.', '.$type.'. '.$attw.')', 'l.'.$to_loc);
    else
    {
      add_journal ($name2.' - '.$damage.''.$cz.' [D: '.$arm.']'.$st.''.$mt.' ('.$name.', '.$type.'. '.$attw.')', 'l.'.$to_loc);
      add_journal ($name2.' - '.$damage.''.$cz.' [D: '.$arm.']'.$st.''.$mt.' ('.$name.', '.$type.'. '.$attw.')', 'l.'.$who_loc);
    }
    /////////////////////// OPYT /////////////////////////////
    include_once ('modules/f_gain_battle_exp.php');
    gain_battle_exp ($who, $to, ($damage + $mdamage));
  }
?>