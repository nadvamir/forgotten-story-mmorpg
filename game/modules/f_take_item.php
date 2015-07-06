<?php
  // podnjatq s zemli pod soboj
  function take_item ($item, $login)
  {
    //$item = preg_replace ('/[^a-z0-9\._]/i', '', $item);
    //$login = mysql_real_escape_string ($login);

    $id = is_player ($login);
    $q = do_mysql ("SELECT name, gender, location, carry, skills FROM players WHERE id_player = '".$id."';");
    if (!mysql_num_rows ($q)) return 0;
    $p = mysql_fetch_assoc ($q);
    $p['skills'] = explode ('|', $p['skills']);

    $q = do_mysql ("SELECT name FROM items WHERE location = '".$p['location']."' AND fullname = '".$item."';");
    if (!mysql_num_rows ($q)) put_g_error ('нету такой вещи!');
    $name = mysql_result ($q, 0);

    include_once ('modules/f_add_item_to_pl.php');
    add_item_to_pl ($login, $item);

    // teperq esli che odenem:
    $q = do_mysql ("SELECT on_take, name FROM items WHERE fullname = '".$item."';");
    $iti = mysql_fetch_assoc ($q);
    $cl = substr ($item, 2, 1);
    $itinf = explode ('~', $iti['on_take']);
    $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$login."' AND is_in = 'wea';");
    if (!mysql_num_rows ($q)) $weapon = '';
    else $weapon = mysql_result ($q, 0);
    $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$login."' AND is_in = 'shi';");
    if (!mysql_num_rows ($q)) $shield = '';
    else $shield = mysql_result ($q, 0);
    if ($cl == 'w' && strpos ($item, '.2h.') === false || $cl == 'w' && !$shield && $p['skills'][40] > 0)
    {
      // odenem oruzhie
      if (!$weapon)
      {
        // tip
        $tp = substr ($item, 4, 3);
        switch ($tp)
        {
          case 'swo': $numb = 7; break;
          case 'axe': $numb = 8; break;
          case 'ham': $numb = 9; break;
          case 'spe': $numb = 10; break;
          case 'bow': $numb = 11; break;
          case 'arb': $numb = 12; break;
          case 'kni': $numb = 13; break;
          case 'kli': $numb = 14; break;
          case 'tre': $numb = 15; break;
        }
        if ($p['skills'][0] >= $itinf[0] && $p['skills'][1] >= $itinf[1] && $p['skills'][2] >= $itinf[2] && $p['skills'][3] >= $itinf[3] && isset($numb) && $p['skills'][$numb] >= $itinf[4])
        {
          do_mysql ("UPDATE items SET is_in = 'wea' WHERE fullname = '".$item."';");
        }
      }
    }
    elseif ($cl == 'x')
    {
      // vzjatq shit
      // esli netu odetogo wita
      if (!$shield && strpos ($weapon, '.2h.') === false)
      {
        if ($p['skills'][0] >= $itinf[0] && $p['skills'][1] >= $itinf[1] && $p['skills'][2] >= $itinf[2] && $p['skills'][3] >= $itinf[3])
        {
          do_mysql ("UPDATE items SET is_in = 'shi' WHERE fullname = '".$item."';");
        }
      }
    }
    elseif ($cl == 'a')
    {
      // odetq bronju)
      if ($p['skills'][0] >= $itinf[0] && $p['skills'][1] >= $itinf[1] && $p['skills'][2] && $itinf[2] && $p['skills'][3] >= $itinf[3])
      {
        // tip
        $tp = substr ($item, 4, 3);
        switch ($tp)
        {
          case 'hea': $numb = 0; break;
          case 'bo1': $numb = 1; break;
          case 'bo2': $numb = 2; break;
          case 'sho': $numb = 3; break;
          case 'glo': $numb = 4; break;
          case 'bel': $numb = 5; break;
          case 'leg': $numb = 6; break;
          case 'pon': $numb = 7; break;
          case 'bot': $numb = 8; break;
          case 'amu': $numb = 9; break;
          case 'rin': $numb = 10; break;
        }
        // esli netu odetogo togo tipa broni
        $q = do_mysql ("SELECT price FROM items WHERE belongs = '".$login."' AND is_in = 'a".$numb."';");
        if (!mysql_num_rows ($q))
        {
          do_mysql ("UPDATE items SET is_in = 'a".$numb."' WHERE fullname = '".$item."';");
          /////////////////////////////
          // esli odelisq kolqca i amulety, izmenim harakteristiku
          if ($numb == 9 || $numb == 10)
          {
            $jew = do_mysql ("SELECT on_use FROM items WHERE fullname = '".$item."';");
            $jew = mysql_result ($jew, 0);
            $jew = explode ('~', $jew);
            $p['skills'][0] += $jew[0];
            $p['skills'][1] += $jew[1];
            $p['skills'][2] += $jew[2];
            $p['skills'][3] += $jew[3];
            $sk = implode ('|', $p['skills']);
            do_mysql ("UPDATE players SET skills = '".$sk."' WHERE login = '".$login."';");
          }
        }
      }
    }
    if ($p['gender'] == 'male') $text = $p['name'].' поднял';
    else $text = $p['name'].' поднялa';

    add_journal ($text.' '.$iti['name'].'!', 'l.'.$p['location']);
  }
?>