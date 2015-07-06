<?php
  // funkcija lechit magiei:
  function magic_heal ($spell, $login, $to)
  {
    //$spell = preg_replace ('/[^a-z0-9_]/i', '', $spell);
    //$login = preg_replace ('/[^a-z0-9_]/i', '', $login);
    //$to = preg_replace ('/[^a-z0-9_\.]/i', '', $to);
    $id = is_player ($login);

    $q = do_mysql ("SELECT lplus, classof, blood, fire, poison FROM magic WHERE fullname = '".$spell."';");
    if (!mysql_num_rows ($q)) return 0;
    $d = mysql_fetch_assoc ($q);

    $q = do_mysql ("SELECT name, skills, location, affected FROM players WHERE id_player = '".$id."';");
    if (!mysql_num_rows ($q)) return 0;
    $skills2 = mysql_fetch_assoc ($q);
    $skills = explode ('|', $skills2['skills']);
    if ($d['classof'] == 0)
    {
      $max = -1;
      $sn = 0;
      for ($i = 22; $i < 30; $i++)
        if ($skills[$i] > $max) { $sn = $i; $max = $skills[$sn]; }
    }
    else $sn = 21 + $d['classof']; // nomer navyka

    // effekt:
    if (is_in ('prokljat', $skills2['affected']))
    {
      add_journal ('древнее проклятие мешает заклинанию', 'l.'.$skills2['location']);
      return 0;
    }

    $minlp = ($d['lplus'] + $skills[2] * 4 + $skills[4] * 2 + $skills[30] * 5 + $skills[$sn] * 5) * 2;
    $maxlp = ($d['lplus'] + $skills[2] * 7 + $skills[4] * 2 + $skills[30] * 7 + $skills[$sn] * 7) * 2;

    $lp = rand ($minlp, $maxlp);

    // snjatie krovotechenija:
    if ($d['blood'])
    {
      include_once ('modules/f_end_blood.php');
      end_blood ($to);
    }
    // snjatie jada:
    if ($d['poison'])
    {
      include_once ('modules/f_end_poison.php');
      end_poison ($to);
    }
    // snjatie gorenija:
    if ($d['fire'])
    {
      include_once ('modules/f_end_fire.php');
      end_fire ($to);
    }

    // teperq v zavisimosti ot npc eto ili igrok
    $tid = is_player ($to);
    if ($tid)
    {
      $q = do_mysql ("SELECT life FROM players WHERE id_player = '".$tid."';");
      if (!mysql_num_rows ($q)) return 0;
      $life = mysql_result ($q, 0);

      $life = explode ('|', $life);
      $life[0] += $lp;
      if ($life[0] > $life[1]) $life[0] = $life[1];
      $nlife = $life[0].'|'.$life[1];

      $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$tid."';");
      $name = mysql_result ($q, 0);
      do_mysql ("UPDATE players SET life = '".$nlife."' WHERE id_player = '".$tid."';");
      add_journal ($name.': жизнь +'.$lp, 'l.'.$skills2['location']);
    }
    else
    {
      $tid = is_npc ($to);
      $q = do_mysql ("SELECT name, life, affected FROM npc WHERE id_npc = '".$tid."';");
      if (!mysql_num_rows ($q)) return 0;
      $life2 = mysql_fetch_assoc ($q);

      $life = explode ('|', $life2['life']);
      $life[0] += $lp;
      if ($life[0] > $life[1]) $life[0] = $life[1];
      $nlife = $life[0].'|'.$life[1];
      do_mysql ("UPDATE npc SET life = '".$nlife."' WHERE id_npc = '".$tid."';");
      add_journal ($life2['name'].': жизнь +'.$lp, 'l.'.$skills2['location']);
    }

    return 1;
  }
?>