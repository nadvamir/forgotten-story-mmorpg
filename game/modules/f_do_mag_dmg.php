<?php
  // funkcija delaet magicheskij uron:
  function do_mag_dmg ($spell, $login, $to)
  {
    //$spell = preg_replace ('/[^a-z0-9_]/i', '', $spell);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);
    //$to = preg_replace ('/[^a-z0-9_\.]/i', '', $to);

    $q = do_mysql ("SELECT dmgmin, dmgmax, classof, blood, fire, poison FROM magic WHERE fullname = '".$spell."';");
    if (!mysql_num_rows ($q)) return 0;
    $d = mysql_fetch_assoc ($q);

    // proverim, estq li zashita ot etogo zaklinanija
    $tid = is_player ($to);
    $npc = 1;
    if ($tid)
    {
       $npc = 0;
       $q = do_mysql ("SELECT aura FROM players WHERE id_player = '".$tid."';");
       $aura = mysql_result ($q, 0);
       if ($aura == $d['classof']+1 || $aura == 1)
       {
         // zaklinanie poglosheno
         add_journal ('заклинание поглощено', $login);
         return 1;
       }
    }

    $id = is_player ($login);
    $q = do_mysql ("SELECT skills FROM players WHERE id_player = '".$id."';");
    $skills = mysql_result ($q, 0);
    $skills = explode ('|', $skills);
    if ($d['classof'] == 0)
    {
      $max = -1;
      $sn = 0;
      for ($i = 22; $i < 30; $i++)
        if ($skills[$i] > $max) { $sn = $i; $max = $skills[$sn]; }
    }
    else $sn = 21 + $d['classof']; // nomer navyka

    $mindmg = ($d['dmgmin'] + $skills[2] * 4 + $skills[4] * 2 + $skills[30] * 5 + $skills[$sn] * 5) * 2;
    $maxdmg = ($d['dmgmax'] + $skills[2] * 7 + $skills[4] * 2 + $skills[30] * 7 + $skills[$sn] * 7) * 2;

    $dmg = rand ($mindmg, $maxdmg);

    // snjatie krovotechenija:
    if ($d['blood'])
    {
      include_once ('modules/f_start_blood.php');
      start_blood ($to);
    }
    // snjatie jada:
    if ($d['poison'])
    {
      include_once ('modules/f_start_poison.php');
      start_poison ($to);
    }
    // snjatie gorenija:
    if ($d['fire'])
    {
      include_once ('modules/f_start_fire.php');
      start_fire ($to);
    }

    // terq zashishjaemsja:
    include_once ('modules/f_mag_def.php');
    $q = do_mysql ("SELECT location FROM players WHERE id_player = '".$id."';");
    $loc = mysql_result ($q, 0);
    $def = mag_def ($login, $skills[$sn], $loc, $to);

    // teperq po def opredelim dalqneishie dejstvija:
    // esli uklonilsja - urona net:
    if ($def == 3) return 1;
    // esli soprotivilsja ili blokiroval, to skolqkoto procentov urona otnimim:
    if ($def == 2 || $def == 1)
    {
      // navyk na 5 / iz def, ne bolqshe max:
      if ($def == 1) { $sk = 20; $max = 100; }
      else { $sk = 21; $max = 70; }
      $m = $skills[$sk] * 5 / $def;
      $m = round ($m);
      if ($m > $max) $m = $max;
      $m = rand (0, $m);
      $m /= 100;
      $dmg = round ($dmg - $dmg * $m);
    }

    // teperq v zavisimosti ot npc eto ili igrok
    if (!$npc)
    {
      $q = do_mysql ("SELECT life FROM players WHERE id_player = '".$tid."';");
      if (!mysql_num_rows ($q)) return 0;
      $life = mysql_result ($q, 0);

      // bronja:
      include_once ('modules/f_get_armor.php');
      $armor =  get_armor ($to);
      $arm = rand (0, $armor[4]);
      $dmg -= $arm;
      if ($dmg < 0) $dmg = 1;

      $life = explode ('|', $life);
      $life[0] -= $dmg;
      if ($life[0] < 0) $life[0] = 0;
      $nlife = $life[0].'|'.$life[1];
      do_mysql ("UPDATE players SET life = '".$nlife."' WHERE id_player = '".$tid."';");

      add_journal (''.$to.': -'.$dmg.' [MD:'.$arm.'] ('.$login.')', 'l.'.$loc);
    }
    else
    {
      $tid = is_npc ($to);
      $q = do_mysql ("SELECT life FROM npc WHERE id_npc = '".$tid."';");
      if (!mysql_num_rows ($q)) return 0;
      $life = mysql_result ($q, 0);

      // bronja:
      $q = do_mysql ("SELECT name, armor FROM npc WHERE id_npc = '".$tid."';");
      $armor2 = mysql_fetch_assoc ($q);
      $armor = explode ('~', $armor2['armor']);
      $arm = $armor[4];
      $dmg -= $arm;
      if ($dmg < 0) $dmg = 0;

      $life = explode ('|', $life);
      $life[0] -= $dmg;
      if ($life[0] < 0) $life[0] = 0;
      $nlife = $life[0].'|'.$life[1];
      do_mysql ("UPDATE npc SET life = '".$nlife."' WHERE id_npc = '".$tid."';");

      add_journal (''.$armor2['name'].': -'.$dmg.' [MD:'.$arm.'] ('.$login.')', 'l.'.$loc);

      include_once ('modules/f_gain_battle_exp.php');
      gain_battle_exp ($login, $to, $dmg);
    }
	
    return 1;
  }
?>