<?php
  // funkcija poluchaet uron igroka 
  // berem uron oruzhija
  function get_dmg ($login)
  {
    //$login = preg_replace ('/[^a-z-0-9_]/i', '', $login);
    $id = is_player ($login);
    $q = do_mysql ("SELECT skills FROM players WHERE id_player = '".$id."';");
    $p = mysql_fetch_assoc ($q);
    $p['skills'] = explode ('|', $p['skills']);

    $q = do_mysql ("SELECT dmg FROM items WHERE belongs = '".$login."' AND is_in = 'wea' AND str > 0;");
    if (!mysql_num_rows($q))
    {
      // kulaki:
      $pl[0][0] = 0;
      $pl[0][1] = 0;
      $pl[1][0] = 0;
      $pl[1][1] = 0;
      $pl[2][0] = $p['skills'][0] * 3 + $p['skills'][1] * 3;
      $pl[2][1] = $p['skills'][0] * 5 + ($p['skills'][1] + 1) * 3;
      $pl[3][0] = 0;
      $pl[3][1] = 0;
      $pl[4][0] = 0;
      $pl[4][1] = 0;
      return $pl;
   }
   else
   {
      $it_dmg = mysql_result ($q, 0);
      $it_dmg = explode ('~', $it_dmg);
      $c = count ($it_dmg);
      for ($i = 0; $i < $c; $i++) $it_dmg[$i] = explode ('-', $it_dmg[$i]);

      $dvu = $dou = 0;
      $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$login."' AND is_in = 'wea';");
      $p['weapon'] = mysql_result ($q, 0);
      if (strpos ($p['weapon'], '.2h.') !== false) $dvu = $p['skills'][40];
      // esli dva oruzhija
      $q = do_mysql ("SELECT dmg FROM items WHERE is_in = 'shi' AND belongs = '".$login."' AND type = 'w' AND str > 0;");
      if (mysql_num_rows ($q) && strpos ($p['weapon'], '.2h.') == false)
      {
        $dou = $p['skills'][41];
        $dmg2 = mysql_result ($q, 0);
        $dmg2 = explode ('~', $dmg2);
        $c2 = count ($dmg2);
        for ($i = 0; $i < $c; $i++)
        {
          $dmg2[$i] = explode ('-', $dmg2[$i]);
          $it_dmg[$i][0] = round ($it_dmg[$i][0] * 0.75 + $dmg2[$i][0] * 0.55);
          $it_dmg[$i][1] = round ($it_dmg[$i][1] * 0.75 + $dmg2[$i][1] * 0.55);
        }
      }

      // vse urony oruzhija polucheny
      // estq 3 formuly
      // esli eto holodnoe:
      $q = do_mysql ("SELECT fullname FROM items WHERE is_in = 'wea' AND belongs = '".$login."';");
      if (!mysql_num_rows ($q)) $weapon = '';
      else $weapon = mysql_result ($q, 0);
      $tp = substr ($weapon, 4, 3);
      if ($tp != 'arb')
      {
        switch ($tp)
        {
          case 'swo': $numb = 7; break;
          case 'axe': $numb = 8; break;
          case 'ham': $numb = 9; break;
          case 'spe': $numb = 10; break;
          case 'bow': $numb = 11; break;
          case 'kni': $numb = 13; break;
          case 'kli': $numb = 14; break;
          case 'tre': $numb = 15; break;
        }
        // hol: sila * udar + navyk * udar + lovka * 2;
        // strel: sila * udar + navyk * udar + lovka * 5;
        // esli u oruzhija estq rezhushij udar
        // lovka dlja raznyh tipov oruzhija
        if ($it_dmg[0][0] || $it_dmg[0][1])
        {
          $pl[0][0] = $p['skills'][0] * 4 + $it_dmg[0][0] + $p['skills'][$numb] * 5 + $p['skills'][1] * 3 + $dvu * 5 + $dou * 5;
          $pl[0][1] = $p['skills'][0] * 8 + $it_dmg[0][1] + $p['skills'][$numb] * 7 + $p['skills'][1] * 4 + $dvu * 7 + $dou * 5;
        }
        else
        {
          $pl[0][0] = 0;
          $pl[0][1] = 0;
        }
        // esli u oruzhija estq koljashijj udar
        if ($it_dmg[1][0] || $it_dmg[1][1])
        {
          $pl[1][0] = $p['skills'][0] * 4 + $it_dmg[1][0] + $p['skills'][$numb] * 5 + $p['skills'][1] * 3 + $dvu * 4 + $dou * 4;
          $pl[1][1] = $p['skills'][0] * 8 + $it_dmg[1][1] + $p['skills'][$numb] * 7 + $p['skills'][1] * 4 + $dvu * 8 + $dou * 8;
        }
        else
        {
          $pl[1][0] = 0;
          $pl[1][1] = 0;
        }
        // esli u oruzhija estq drobjashij udar
        if ($it_dmg[2][0] || $it_dmg[2][1])
        {
          $pl[2][0] = $p['skills'][0] * 4 + $it_dmg[2][0] + $p['skills'][$numb] * 5 + $p['skills'][1] * 3 + $dvu * 4 + $dou * 4;
          $pl[2][1] = $p['skills'][0] * 8 + $it_dmg[2][1] + $p['skills'][$numb] * 7 + $p['skills'][1] * 4 + $dvu * 8 + $dou * 8;
        }
        else
        {
          $pl[2][0] = 0;
          $pl[2][1] = 0;
        }
        // esli u oruzhija estq rubjashij udar
        if ($it_dmg[3][0] || $it_dmg[3][1])
        {
          $pl[3][0] = $p['skills'][0] * 4 + $it_dmg[3][0] + $p['skills'][$numb] * 5 + $p['skills'][1] * 3 + $dvu * 4 + $dou * 4;
          $pl[3][1] = $p['skills'][0] * 8 + $it_dmg[3][1] + $p['skills'][$numb] * 7 + $p['skills'][1] * 4 + $dvu * 8 + $dou * 8;
        }
        else
        {
          $pl[3][0] = 0;
          $pl[3][1] = 0;
        }
        // esli u oruzhija estq magicheskij udar
        if ($it_dmg[4][0] || $it_dmg[4][1])
        {
          $pl[4][0] = $it_dmg[4][0] + $p['skills'][2] * 7;
          $pl[4][1] = $it_dmg[4][1] + $p['skills'][2] * 14;
        }
        else
        {
          $pl[4][0] = 0;
          $pl[4][1] = 0;
        }
        // vozvratim
        return $pl;
      } // konec holodnogo oruzhija
      else
      {
        // arbalet
        $pl[0][0] = $it_dmg[0][0];
        $pl[0][1] = $it_dmg[0][1];
        $pl[1][0] = $it_dmg[1][0] + $p['skills'][1] * 6 + $p['skills'][3] * 2 + $p['skills'][12] * 4;
        $pl[1][1] = $it_dmg[1][1] + $p['skills'][1] * 9 + $p['skills'][3] * 3 + $p['skills'][12] * 7;
        $pl[2][0] = $it_dmg[2][0];
        $pl[2][1] = $it_dmg[2][1];
        $pl[3][0] = $it_dmg[3][0];
        $pl[3][1] = $it_dmg[3][1];
        $pl[4][0] = $it_dmg[4][0];
        $pl[4][1] = $it_dmg[4][1];
        // vozvratim
        return $pl;
      }
    }
  }
?>