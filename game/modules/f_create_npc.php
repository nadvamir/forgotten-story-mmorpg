<?php
  // funkcija sozdaet npc
  // daet emu unikalqnoe imja
  // sozdaet v ukazanom regione
  function create_npc ($fullname, $region, $location = 0)
  {
    //$fullname = preg_replace ('/[^a-z\._0-9]/i', '', $fullname);
    //$region = preg_replace ('/[^a-z0-9_]/i', '', $region);
    //$location = preg_replace ('/[^a-z0-9_\|]/i', '', $location);
    // zagruzim fail npc
    $file_name = str_replace ('.', '_', $fullname);
    $dir = substr ($fullname, 2, 1);
    if (!file_exists ('modules/npc/'.$dir.'/'.$file_name.'.php')) put_error ('файл нпц не найден '.$fullname);
    include ('modules/npc/'.$dir.'/'.$file_name.'.php');
    // teperq imeem vazhnejshie dannye. mnogie postavim 0, nekotorye pridetsja pridumatq
    //////////////////////////////////
    // dlja prostyh npc klassa a i x izmenim drop2
    if ($npc['type'] == 'a' || $npc['type'] == 'x')
    {
      if (!isset ($NO))
      {
        $mult = 6;
        //$mult += round ($npc['lvl'] / 10);
        $pts = $npc['lvl'] * $mult + $npc['str'] * 3;
        $npc['pts'] = $pts;
        $base = $npc['lvl'];
        if ($base == 0) $base = 1;
        $pts -= $base * 4;
        // intellekt kachatq stoit lishq magam, drugim ochki raspredelim inache
        $npc['dmg'] = explode ('~', $npc['dmg']);
        if ($npc['dmg'][4] != '0-0')
        {
        $p['skills'][0] = rand (0, $pts);
        $p['skills'][1] = rand (0, ($pts - $p['skills'][0]));
        $p['skills'][2] = rand (0, ($pts - $p['skills'][0] - $p['skills'][1]));
        $p['skills'][3] = rand (0, ($pts - $p['skills'][0] - $p['skills'][1] - $p['skills'][2]));
        $p['skills'][0] += $base;
        $p['skills'][1] += $base;
        $p['skills'][2] += $base;
        $p['skills'][3] += $base;
        $p['skills'][4] = $base;
        }
        else
        {
        $p['skills'][0] = rand (0, $pts);
        $p['skills'][1] = rand (0, ($pts - $p['skills'][0]));
        $p['skills'][2] = 0;
        $p['skills'][3] = rand (0, ($pts - $p['skills'][0] - $p['skills'][1] - $p['skills'][2]));
        $p['skills'][0] += $base;
        $p['skills'][1] += $base;
        $p['skills'][2] += $base;
        $p['skills'][3] += $base;
        $p['skills'][4] = $base;
        }

        $npc['skills'] = $p['skills'];
        $t[0] = $p['skills'][1] * 10 + $p['skills'][4] * 10 + $p['skills'][3] * 2; # udar
        $t[1] = $p['skills'][1] * 10 + $p['skills'][4] * 10 + $p['skills'][3] * 5; # blok
        $t[2] = $p['skills'][1] * 5 + $p['skills'][4] * 5 + $p['skills'][3] * 5; # uklon
        $t[3] = $p['skills'][1] * 10 + $p['skills'][4] * 10 + $p['skills'][3] * 2; # parirovanie
        $t[4] = $p['skills'][2] * 8 + $p['skills'][4] * 3; // pri primenenii dobavitq magija na 9 # uron magija
        $t[5] = $p['skills'][2] * 4 + $p['skills'][4] * 2 + $p['skills'][4] * 6; // pri primenenii dobavitq magija na 3 # ochki blok magija
        $t[6] = $p['skills'][2] * 8 + $p['skills'][4] * 2 + $p['skills'][4] * 8; // pri primenenii dobavitq magija na 3 # soprotivlenie magii
        $t[7] = $p['skills'][2] * 5 + $p['skills'][4] * 5 + $p['skills'][4] + $p['skills'][4] * 3; // pri ispolqzovanii dobavitq magija na 3; # uklon ot magii
        $t[8] = $p['skills'][1] * 3 + $p['skills'][4] * 3 + $p['skills'][4] * 3; # uklon ot strelqby
        $t[9] = $p['skills'][1] * 5 + $p['skills'][3] * 5 + $p['skills'][4] * 5;
        $life = $p['skills'][0] * 71 + $p['skills'][1] * 32;
        $npc['life'] = $life.'|'.$life;
        $npc['chanse'] = $t[0].'~'.$t[1].'~'.$t[2].'~'.$t[3].'~'.$t[4].'~'.$t[5].'~'.$t[6].'~'.$t[7].'~'.$t[8].'~'.$t[9];
        $npc['exp'] = $npc['lvl'] * 20 + $npc['str'] * 5;
        $dmg1 = round ((21+32*$npc['lvl']) * 1 * (99) * 100/10000);
        $dmg2 = round ((21+33*$npc['lvl']) * 1 * (101) * 100/10000);
        $dmgmin = $dmg1 + $p['skills'][0] * 4 + $p['skills'][4] * 5 + $p['skills'][1] * 3;
        $dmgmax = $dmg2 + $p['skills'][0] * 8 + $p['skills'][4] * 7 + $p['skills'][1] * 4;
        // $npc['dmg'] = str_replace ('1-1', $dmgmin.'-'.$dmgmax, $npc['dmg']);
        $primea = round(($dmgmin + $dmgmax) / 3);
        $seconda = round (($dmgmin + $dmgmax) / 5);
        // $dmgmin = round ($dmgmin * 0.7);
        // $dmgmax = round ($dmgmax * 0.7);
        // $npc['dmg'] = str_replace ('2-2', $dmgmin.'-'.$dmgmax, $npc['dmg']);
        for ($i = 0; $i < 5; $i++)
        {
          if ($npc['dmg'][$i] == '1-1') $npc['dmg'][$i] = $dmgmin.'-'.$dmgmax;
          if ($npc['dmg'][$i] == '2-2') $npc['dmg'][$i] = (round ($dmgmin * 0.7)).'-'.(round ($dmgmax * 0.7));
        }
        $npc['dmg'] = implode ('~', $npc['dmg']);
        $npc['armor'] = explode ('~', $npc['armor']);
        for ($i = 0; $i < 5; $i++)
        {
          if ($npc['armor'][$i] == 1) $npc['armor'][$i] = $primea;
          if ($npc['armor'][$i] == 2) $npc['armor'][$i] = $seconda;
        }
        $npc['armor'] = implode ('~', $npc['armor']);
        $lvl = $npc['lvl'];
        $plus = 3;
        $plus += $npc['str'] * 3;
        $expto = round ((600 * $lvl * $lvl + 1000 * $lvl) / 7 * $plus);
      }
      if ($npc['drop2'])
      {
        //echo $npc['drop2'];
        // chtoto estq
        $sth = explode ('~', $npc['drop2']);
        $num = array_rand ($sth);
        $sth[$num] = explode (':', $sth[$num]);
        if (rand (0, 100) <= $sth[$num][1]) $npc['drop2'] = $sth[$num][0];
        else $npc['drop2'] = '';
      }
      if (!$npc['drop2'])
      {
        // sluchajnyj drop:
        if (rand (0, 100) <= 50)
        {
          // znachit kidaem to chtyo poluchitsja:
          $rnd = rand (0, 100);
          if ($rnd < 19)
          {
            // sluchajnoe oruzhie:
            $types = array ('arb', 'axe', 'bow', 'ham', 'kli', 'kni', 'spe', 'swo', 'tre');
            $arnd = array_rand ($types);
            include ('sp/sp_rand_weapon.php');
          }
            else if ($rnd < 47)
          {
            // sluchajnaja bronja
            $types = array ('amu', 'bel', 'bo1', 'bo2', 'bot', 'glo', 'hea', 'leg', 'pon', 'rin', 'sho');
            $arnd = array_rand ($types);
            include ('sp/sp_rand_armor.php');
          }
          else if ($rnd < 48)
          {
            // kvestavaja veshq:
            include ('sp/sp_rand_quest_item.php');
          }
          else if ($rnd < 59)
          {
            // wit
            include ('sp/sp_rand_shield.php');
          }
          else if ($rnd < 79)
          {
            // eda
            include ('sp/sp_rand_food.php');
          }
          else if ($rnd < 89)
          {
            // svitok:
            include ('sp/sp_rand_scroll.php');
          }
          else
          {
            // reagenty
            include ('sp/sp_rand_rea.php');
          }
        }
      }
    }
    if (!isset ($expto))
    {
      $expto = 0;
      $lvl = 1;
      $npc['pts'] = 0;
      $npc['skills'] = array(10, 10, 10, 10, 10);
    }
    ///////////////////////////////////
    // LOKACIJA:
    // esli lokacija pod nulevym elementom imeetsja, my tolqko dobavim k inloc
    if (!$location)
    {
      include_once ('modules/f_gen_rnd_loc.php');
      $loc = gen_rnd_loc ($region);
      // sozdaem zapros, i ustanavlivaem flag NC = 1, chtob srazu posle npc sozdatq lokaciju
      // na vsjakij sluchjaj, chtob npc bez loki ne ostavitq ili naoborot
      $q2cl = "INSERT INTO locations Values ('".$loc[0]."', '".$region."', '');";
      $location = $loc[0];  // dlja togo, chtob potom ukazatq pravilqno
    }
    $map = substr ($location, 0, 4);
    // esli ne ukazana, pridetsja sozdatq
    // s lokacijami razobralisq
    // teperq kidaem v bazu npc
    // zapros na kolichestvo pohozhih
    $time = time(); // vremja sejchjas
    if (!isset ($npc['hidden'])) $npc['hidden'] = 0;
    if (!isset ($npc['attack_speed'])) $npc['attack_speed'] = 4;
    if (!isset ($npc['effect'])) $npc['effect'] = '';
    do_mysql ("INSERT INTO npc VALUES (0, '".$npc['name']."', '".$npc['fullname'].".n', '".$npc['type']."', '".$npc['life']."', '".$location."', '".$time."', '', '".$npc['move']."', '0', '', '".$npc['dmg']."', '".$npc['armor']."', '".$npc['exp']."', '".$npc['chanse']."', '".$npc['drop2']."', '".$npc['hunt']."', '".$map."', '0', '".$time."', '".$npc['attack_speed']."', '', '".$npc['fullname']."', '".$npc['hidden']."', '".$npc['skills'][0]."', '".$npc['skills'][1]."', '".$npc['skills'][2]."', '".$npc['skills'][3]."', '".$npc['skills'][4]."', '0', '".$expto."', '".$npc['pts']."', '".$lvl."', '0', '0', '".$npc['effect']."');");
    //////////
//die ($npc['drop2']);
    // fullname
    $qfn = do_mysql ("SELECT id_npc FROM npc WHERE fullname = '".$npc['fullname'].".n';");
    $fn = mysql_result ($qfn, 0);
    $npc['fullname'] .= '.'.$fn;
    do_mysql ("UPDATE npc SET fullname = '".$npc['fullname']."' WHERE id_npc = '".$fn."';");
    return $npc['fullname'];
  }
?>