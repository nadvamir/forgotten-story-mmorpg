<?php
  // funkcija dlja poluchenija boevyh harakteristik zadannogo igroka
  // spisok massiva v help.txt
  function get_pl_battle_har ($pl)
  {
    //$pl = preg_replace ('/[^a-z0-9_]/i', '', $pl)

    $id = is_player ($pl);
    $p = do_mysql ("SELECT skills FROM players WHERE id_player = '".$id."';");
    $p = mysql_fetch_assoc ($p);
    $p['skills'] = explode ('|', $p['skills']);
    $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$pl."' AND is_in = 'wea';");
    if (!mysql_num_rows ($q)) $p['weapon'] = '';
    else $p['weapon'] = mysql_result ($q, 0);
    $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$pl."' AND is_in = 'shi';");
    if (!mysql_num_rows ($q)) $p['shield'] = '';
    else $p['shield'] = mysql_result ($q, 0);
    $tp = substr ($p['weapon'], 4, 3);
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
      case 'tre': case 'wan': $numb = 15; break;
      default: $numb = 1; break;
    }
    $dvu = $dou = 0;
    if (strpos ($p['weapon'], '.2h.') !== false) $dvu = $p['skills'][40];
    if (substr ($p['shield'], 2, 1) == 'w') $dou = $p['skills'][41];
    $t[0] = $p['skills'][1] * 10 + $p['skills'][$numb] * 10 + $p['skills'][3] * 2 + $dou * 10 + $dvu * 10; # udar
    if ($tp == 'arb') $t[1] = 0;
    $t[1] = $p['skills'][1] * 10 + $p['skills'][$numb] * 10 + $p['skills'][3] * 5 + $dou * 10 + $dvu * 10; # blok
    $t[2] = $p['skills'][1] * 5 + $p['skills'][17] * 5 + $p['skills'][3] * 5; # uklon
    $t[3] = $p['skills'][1] * 10 + $p['skills'][18] * 10 + $p['skills'][3] * 2; # parirovanie
    $t[4] = $p['skills'][2] * 8 + $p['skills'][4] * 3 + $p['skills'][30]; // pri primenenii dobavitq magija na 9 # uron magija
    $t[5] = $p['skills'][2] * 4 + $p['skills'][4] * 2 + $p['skills'][20] * 6 + $p['skills'][30]; // pri primenenii dobavitq magija na 3 # ochki blok magija
    $t[6] = $p['skills'][2] * 8 + $p['skills'][4] * 2 + $p['skills'][21] * 8 + $p['skills'][30]; // pri primenenii dobavitq magija na 3 # soprotivlenie magii
    $t[7] = $p['skills'][2] * 5 + $p['skills'][19] * 5 + $p['skills'][4] + $p['skills'][30] * 3; // pri ispolqzovanii dobavitq magija na 3; # uklon ot magii
    $t[8] = $p['skills'][1] * 3 + $p['skills'][3] * 3 + $p['skills'][17] * 3; # uklon ot strelqby
    $t[9] = $p['skills'][1] * 5 + $p['skills'][3] * 5 + $p['skills'][18] * 5; # parirovanija strelqby

    include_once ('modules/f_get_affected.php');
    $aff = get_affected ($pl);
    if (is_in ('osleplen', $aff))
    {
      for ($i = 0; $i < 10; $i++) $t[$i] = round ($t[$i] / 2);
    }

    return $t;
  }
?>