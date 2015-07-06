<?php
  // chastq skripta, kastovanie boevogo zakla:
  // napadaem zaodno proverjaem celq rjadom li
  include_once ('modules/f_mag_decl_attack.php');
  // $to dolzhen bytq uzhe gdeto dan
  if (!mag_decl_attack ($LOGIN, $to)) put_g_error ('рядом такого нет!');

  // nanosim uron:
  include_once ('modules/f_do_mag_dmg.php');
  // spell tozhe dolzhen bytq dan
  do_mag_dmg ($spell, $LOGIN, $to);

  // nanosim effekty:
  include_once ('modules/f_mag_add_effects.php');
  mag_add_effects ($spell, $to);

  // nakonec proverka,zhiv li:
  include_once ('modules/f_check_dead.php');
  if (check_dead($to))
  {
    // uvelichenie reitinga pobed:
    $lvl = $p['stats'][0];
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
  }
  // use)
?>