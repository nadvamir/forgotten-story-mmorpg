<?php
  // funkcija napastq
  // dlja igrokov - i dlja npc.
  function attack ($who, $to)
  {
    // prosto vnosit imena. esli nelzja dostatq, v funkcii nanesti uron bitva okonchitsja
    $id = is_player ($who);
    if ($id)
    {
      if ($who == $to) put_g_error ('суицид кармически наказуем');
      // berem spisok - imja, kto v boju uzhe:
      $whp = 1;
      $q = do_mysql ("SELECT id_player, login, name, gender, location, in_battle, status1, last, clan FROM players WHERE id_player = '".$id."';");
      $att = mysql_fetch_assoc ($q);
      $att['last'] = explode ('|', $att['last']);
      // takzhe, vozqmem informaciju o prizvanyh i priruchenyh.
      $q = do_mysql ("SELECT id_npc, fullname, name, in_battle FROM npc WHERE belongs = '".$who."';");
      if (mysql_num_rows ($q)) $whobel = mysql_fetch_assoc ($q);
    }
    else
    {
      $id = is_npc ($who);
      if (!$id2) return 0;
      $whp = 0;
      // osnovnaja informacija monstra - 
      $q = do_mysql ("SELECT id_npc, fullname, name, location, in_battle FROM npc WHERE id_npc = '".$id."';");
      $att = mysql_fetch_assoc ($q);
      // pokachto nebudem schitatq partii monstrov
    }

    // teperq na togo na kogo napadaet soberem informaciju
    $id2 = is_player ($to);
    if ($id2)
    {
      $tp = 1;
      // berem spisok - imja, kto v boju uzhe:
      $q = do_mysql ("SELECT id_player, login, name, in_battle, location, status1, clan, active FROM players WHERE id_player = '".$id2."';");
      $def = mysql_fetch_assoc ($q);
      if (!$def['active']) return 0;
      // takzhe, vozqmem informaciju o prizvanyh i priruchenyh.
      $q = do_mysql ("SELECT id_npc, fullname, name, in_battle FROM npc WHERE belongs = '".$to."';");
      if (mysql_num_rows ($q)) $tobel = mysql_fetch_assoc ($q);
    }
    else
    {
      $id2 = is_npc ($to);
      if (!$id2) return 0;
      $tp = 0;
      // osnovnaja informacija monstra - 
      $q = do_mysql ("SELECT id_npc, fullname, name, in_battle, type, location, belongs FROM npc WHERE id_npc = '".$id2."';");
      $def = mysql_fetch_assoc ($q);
      // napadatq na torgovcev i npc nelzja - tolqko na monstrov i zhivotnyh
      if ($def['type'] == 's' || $def['type'] == 't') put_g_error ('ну что тебе это существо плохого сделала то, а?');
      // esli na svoegozhe napadaem, to bolqshe ne svoj zhe -
      if ($def['belongs'] == $who)
      {
        $def['belongs'] = '0';
        do_mysql ("UPDATE npc SET belongs = '0' WHERE id_npc = '".$id2."';");
      }
      // pokachto nebudem schitatq partii monstrov
    }

    // esli uzhe v boju, to nichego ne budem delatq
    if ($att['in_battle'] > 0 && $def['in_battle'] > 0 && $att['in_battle'] != $def['in_battle'])
      return 1;
    if ($att['in_battle'] > 0 && $att['in_battle'] == $def['in_battle']) put_g_error ('он на вашей стороне!');
    if (!$att['in_battle'])
    {
      if (!$def['in_battle'])
      {
        $att['in_battle'] = 1;
        $def['in_battle'] = 2;
      }
      else if ($def['in_battle'] == 1) $att['in_battle'] = 2;
      else $att['in_battle'] = 1;
    }
    else
    {
      if ($att['in_battle'] == 1) $def['in_battle'] = 2;
      else $def['in_battle'] = 1;
    }

    // zony, svobodnye ot ataki:
    $toloc = $def['location'];
    if (substr ($toloc, 0, 4) == 'rele' || substr ($toloc, 0, 4) == 'elfc' || substr ($toloc, 0, 4) == 'verg') put_g_error ('на этой локации атаковать нелзя');

    if ($whp) do_mysql ("UPDATE players SET in_battle = '".$att['in_battle']."' WHERE id_player = '".$att['id_player']."';");
    else do_mysql ("UPDATE npc SET in_battle = '".$att['in_battle']."' WHERE id_npc = '".$att['id_npc']."';");
    if ($tp) do_mysql ("UPDATE players SET in_battle = '".$def['in_battle']."' WHERE id_player = '".$def['id_player']."';");
    else do_mysql ("UPDATE npc SET in_battle = '".$def['in_battle']."' WHERE id_npc = '".$def['id_npc']."';");

    // teperq pitomcy
    if (isset ($whobel))
    {
      $whobel['in_battle'] = $att['in_battle'];
      do_mysql ("UPDATE npc SET in_battle = '".$whobel['in_battle']."' WHERE id_npc = '".$whobel['id_npc']."';");
    }
    if (isset ($tobel))
    {
      $tobel['in_battle'] = $def['in_battle'];
      do_mysql ("UPDATE npc SET in_battle = '".$tobel['in_battle']."' WHERE id_npc = '".$tobel['id_npc']."';");
    }

    // dela s karmoj svjazanye
    if (isset ($def['login']) && isset ($att['login']) && $def['status1'][0] != 1 && $def['status1'][0] != 2 && substr ($def['location'], 0, 4) != 'pris' && substr ($def['location'], 0, 3) != 'are')
    {
      // proverim togda vojnu klanovuju - 
      $att['clan'] = explode ('|', $att['clan']);
      $def['clan'] = explode ('|', $def['clan']);
      $q = do_mysql ("SELECT politics FROM clans WHERE clanname = '".$att['clan'][0]."';");
      if (!mysql_num_rows ($q)) $pol = '';
      $pol = mysql_result ($q, 0);
      $pol = explode ('|', $pol); // 0 - war
      if (!is_in ($def['clan'][0], $pol[0]))
      {

        $att['status1'][0] = 1;
        $att['last'][4] = time();
        $att['last'] = implode ('|', $att['last']);
        do_mysql ("UPDATE players SET last = '".$att['last']."', status1 = '".$att['status1']."' WHERE id_player = '".$att['id_player']."';");
      }
    }
    
    if (isset ($att['login']) && $att['gender'] == 'female') $attacked = 'напалa';
    else $attacked = 'напал';
    add_journal ($att['name'].' '.$attacked.' на '.$def['name'].'!', 'l.'.$att['location']);
    return 1;
  }
?>