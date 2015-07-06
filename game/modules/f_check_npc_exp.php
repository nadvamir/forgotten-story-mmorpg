<?php
  // proverka opyta
  function check_npc_exp ($npc2)
  {
    $id = is_npc ($npc2);
    if (!$id) return 0;
    $q = do_mysql ("SELECT * FROM  npc WHERE id_npc = '".$id."';");
    $n = mysql_fetch_assoc ($q);

    $exphas = round ((600 * $n['lvl'] * $n['lvl'] + 1000 * $n['lvl']) / 7);
    $expto = 600 * $n['lvl'] * $n['lvl'] + 1000 * $n['lvl'];

    // exphas - do novogo ochka, expto, do novogo urovnja.
    if ($exphas <= $n['exphas'])
    {
      $n['exphas'] -= $exphas;
      $s = array ('str', 'dex', 'int', 'rea', 'other');
      $num = array_rand ($s);
      $n[$s[$num]]++;
      
      add_journal ($n['name'].' получил очко опыта! '.$s[$num].'++!', 'l.'.$n['location']);

      $file_name = str_replace ('.', '_', $n['realname']);
      $dir = substr ($n['realname'], 2, 1);
      if (!file_exists ('modules/npc/'.$dir.'/'.$file_name.'.php')) put_error ('файл нпц не найден '.$fullname);
      include ('modules/npc/'.$dir.'/'.$file_name.'.php');
      $p['skills'][0] = $n['str'];
      $p['skills'][1] = $n['dex'];
      $p['skills'][2] = $n['int'];
      $p['skills'][3] = $n['rea'];
      $p['skills'][4] = $n['other'];
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
        $n['life'] = $life.'|'.$life;
        $n['chanse'] = $t[0].'~'.$t[1].'~'.$t[2].'~'.$t[3].'~'.$t[4].'~'.$t[5].'~'.$t[6].'~'.$t[7].'~'.$t[8].'~'.$t[9];
        $n['exp'] = $n['lvl'] * 20 + $n['str'] * 5;
        $dmgmin = $n['lvl'] * 21 + $p['skills'][0] * 4 + $p['skills'][4] * 5 + $p['skills'][1] * 3;
        $dmgmax = $n['lvl'] * 22 + $p['skills'][0] * 8 + $p['skills'][4] * 7 + $p['skills'][1] * 4;
        // $n['dmg'] = str_replace ('1-1', $dmgmin.'-'.$dmgmax, $n['dmg']);
        $primea = round(($dmgmin + $dmgmax) / 3);
        $seconda = round (($dmgmin + $dmgmax) / 5);
        // $dmgmin = round ($dmgmin * 0.7);
        // $dmgmax = round ($dmgmax * 0.7);
        // $n['dmg'] = str_replace ('2-2', $dmgmin.'-'.$dmgmax, $n['dmg']);
        $n['dmg'] = explode ('~', $npc['dmg']);
        for ($i = 0; $i < 5; $i++)
        {
          if ($n['dmg'][$i] == '1-1') $n['dmg'][$i] = $dmgmin.'-'.$dmgmax;
          if ($n['dmg'][$i] == '2-2') $n['dmg'][$i] = (round ($dmgmin * 0.7)).'-'.(round ($dmgmax * 0.7));
        }
        $n['dmg'] = implode ('~', $n['dmg']);
        $n['armor'] = explode ('~', $npc['armor']);
        for ($i = 0; $i < 5; $i++)
        {
          if ($n['armor'][$i] == 1) $n['armor'][$i] = $primea;
          if ($n['armor'][$i] == 2) $n['armor'][$i] = $seconda;
        }
        $n['armor'] = implode ('~', $n['armor']);
        //echo '<pre>';
        //print_r ($n);
        //print_r ($npc);
      do_mysql ("UPDATE npc SET exphas = '".$n['exphas']."', str = '".$n['str']."', dex = '".$n['dex']."', `int` = '".$n['int']."', rea = '".$n['rea']."', other = '".$n['other']."', sp = sp + 1, dmg = '".$n['dmg']."', armor = '".$n['armor']."', life = '".$n['life']."', chanse = '".$n['chanse']."', exp = '".$n['exp']."' WHERE id_npc = '".$id."';");
      unset ($npc);
    }
    if ($expto <= $n['expto'])
    {
      $n['expto'] -= $expto;
      
        $n['lvl'] += 1;
        $n['str'] += 1;
        $n['dex'] += 1;
        $n['other'] += 1;
        $n['sp'] += 3;

      add_journal ($n['name'].' получил новый уровень! ', 'l.'.$n['location']);
      $file_name = str_replace ('.', '_', $n['realname']);
      $dir = substr ($n['realname'], 2, 1);
      if (!file_exists ('modules/npc/'.$dir.'/'.$file_name.'.php')) put_error ('файл нпц не найден '.$fullname);
      include ('modules/npc/'.$dir.'/'.$file_name.'.php');
      $p['skills'][0] = $n['str'];
      $p['skills'][1] = $n['dex'];
      $p['skills'][2] = $n['int'];
      $p['skills'][3] = $n['rea'];
      $p['skills'][4] = $n['other'];
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
        $n['life'] = $life.'|'.$life;
        $n['chanse'] = $t[0].'~'.$t[1].'~'.$t[2].'~'.$t[3].'~'.$t[4].'~'.$t[5].'~'.$t[6].'~'.$t[7].'~'.$t[8].'~'.$t[9];
        $n['exp'] = $n['lvl'] * 20 + $n['str'] * 5;
        $dmgmin = $n['lvl'] * 21 + $p['skills'][0] * 4 + $p['skills'][4] * 5 + $p['skills'][1] * 3;
        $dmgmax = $n['lvl'] * 22 + $p['skills'][0] * 8 + $p['skills'][4] * 7 + $p['skills'][1] * 4;
        // $n['dmg'] = str_replace ('1-1', $dmgmin.'-'.$dmgmax, $n['dmg']);
        $primea = round(($dmgmin + $dmgmax) / 3);
        $seconda = round (($dmgmin + $dmgmax) / 5);
        // $dmgmin = round ($dmgmin * 0.7);
        // $dmgmax = round ($dmgmax * 0.7);
        // $n['dmg'] = str_replace ('2-2', $dmgmin.'-'.$dmgmax, $n['dmg']);
        $n['dmg'] = explode ('~', $npc['dmg']);
        for ($i = 0; $i < 5; $i++)
        {
          if ($n['dmg'][$i] == '1-1') $n['dmg'][$i] = $dmgmin.'-'.$dmgmax;
          if ($n['dmg'][$i] == '2-2') $n['dmg'][$i] = (round ($dmgmin * 0.7)).'-'.(round ($dmgmax * 0.7));
        }
        $n['dmg'] = implode ('~', $n['dmg']);
        $n['armor'] = explode ('~', $npc['armor']);
        for ($i = 0; $i < 5; $i++)
        {
          if ($n['armor'][$i] == 1) $n['armor'][$i] = $primea;
          if ($n['armor'][$i] == 2) $n['armor'][$i] = $seconda;
        }
        $n['armor'] = implode ('~', $n['armor']);
        //echo '<pre>';
        //print_r ($n);
        //print_r ($npc);
      do_mysql ("UPDATE npc SET life = '".$n['life']."', dmg = '".$n['dmg']."', armor = '".$n['armor']."', exp = '".$n['exp']."', chanse = '".$n['chanse']."', str = '".$n['str']."', dex = '".$n['dex']."', other = '".$n['other']."', expto = '".$n['expto']."', sp = '".$n['sp']."', lvl = '".$n['lvl']."' WHERE id_npc = '".$id."';");

    }

    return 1;
  }
?>