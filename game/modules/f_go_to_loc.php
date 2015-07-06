<?php
  // poleznaja funkcija po perehodu na druguju loku
  // s primeneniem pochti vseh vyshenapisanyh funkcij. heh.
  // funkcija ne tolqko dlja igrokov, no i dlja nps
  function go_to_loc ($who, $loc_go, $stor, $ok = 0)
  {
    # get_pl_info(), do_mysql();, get_npc_info();, loc();, put_error();, delete_from_loc();, add_to_loc();, addjournal();
    require_once 'modules/f_get_pl_info.php';
    require_once 'modules/f_get_npc_info.php';
    require_once 'modules/f_loc.php';
    require_once 'modules/f_add_to_loc.php';
    // proverka dannyh
   // $who = preg_replace ('/[^a-z\._0-9]/i', '', $who);
    if (!$ok)
    {
      $loc_go = preg_replace ('/[^a-z0-9\|]/', '', $loc_go);
      $stor = preg_replace ('/[^a-z0-9]/i', '', $stor);
    }
    // $stor - eto storona. dlja massiva
    // lokacija
    if (substr($who, 0, 2) == 'p.')
    {
      // login
      $login = substr ($who, 2);
      $who = $login;
      $id = is_player ($login);
      $lq = do_mysql ("SELECT location FROM players WHERE id_player = '".$id."';");
      $loc = mysql_result ($lq, 0);
      $lq = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
      $name = mysql_result ($lq, 0);
      //$loc = get_pl_info ($login, 'location');
      $qg = do_mysql ("SELECT gender FROM players WHERE id_player = '".$id."';");
      $gender = mysql_result ($qg, 0);

      $qg = do_mysql ("SELECT walking FROM players WHERE id_player = '".$id."';");
      $w = mysql_result ($qg, 0);
      if ($w > 0) $CAN_JUMP = 1;

      $qg = do_mysql ("SELECT carry FROM players WHERE id_player = '".$id."';");
      $carry = mysql_result ($qg, 0);
      include_once ('modules/f_get_pl_weight.php');
      if ($carry < get_pl_weight ($login)) put_g_error ('вы перегруженны');
      $n = 0;
      $who = $login;
      // proverka na boj - 
      $q = do_mysql ("SELECT in_battle FROM players WHERE id_player = '".$id."';");
      $inb = mysql_result ($q, 0);

      $type = 'a';
    }
    if (substr($who, 0, 2) == 'n.')
    {
      $loc = get_npc_info ($who, 'location');
      $id = is_npc ($who);
      // adding npc to move log -
      global $NPC_MOVED;
      $NPC_MOVED[$id] = 1;
      $alo = do_mysql("SELECT name FROM npc WHERE id_npc = '".$id."';");
      $login = mysql_result ($alo, 0);
      $name = $login;
      $alo = do_mysql("SELECT type FROM npc WHERE id_npc = '".$id."';");
      $type = mysql_result ($alo, 0);
      $n = 1;
      $inb = 0;
    }
    # vozmozhny dva puti - na druguju kartu ili prosto na druguju lokaciju
    # na druguju kartu ne storony, potomu prosto stor = 'nmap';
    # na druguju lokaciju - togda cherez near
    // ESLI NA DRUGUJU KARU
    $show_info = 0;
    if (substr ($loc, 0, 4) != substr ($loc_go, 0, 4))
    {
      global $NEWMAP;
      $NEWMAP = 1;
      // a eshe ustanovim flag show_info, po kotoromu potom opredelim, nado li pokazatq vstupitelqnyj tekst k loakacci
      $show_info = 1;
      // zlye npc nemogut idti v goroda
      if ($type == 'x')
      {
        $toloc = substr ($loc_go, 0, 4);
        if ($toloc == 'rele' || $toloc == 'elfc' || $toloc == 'verg') return 0;
      }
    }
    $li = '';
    // voobshem eto tazhe lokacija
    include_once ('modules/f_can_u_reach.php');
    $depth = 1;
    if (isset ($_GET['jump']) && isset ($CAN_JUMP)) $depth = 2;
    // esli v okruzhnoj lokacii netu takoj loki v takuju storonu, to idti nelzja
    if (!can_u_reach ($who, $loc_go, $stor, $depth))
    {
      //put_error ('<p>извините, но в указаном направлении такой локации нет</p>');
      return 0;
    }
    if ($depth == 2)
    {
      // get loc v can u reach
      $ll = get_loc ($who, $stor, 1);
      add_journal ($name.' пронесся мимо!', 'l.'.$ll);
    }
    // est9q li loka na kotoruju idut?
    //////////////////////////////
    // pitomec
    $an = do_mysql ("SELECT name, fullname FROM npc WHERE belongs = '".$who."' AND location = '".$loc."' AND move <> 0;");
    $an = mysql_fetch_assoc ($an);
    if ($an['fullname'])
    {
      $pit = ' и '.$an['name'].' ';
      add_to_loc ($loc_go, $an['fullname']);
    }
    else $pit = '';
    if (substr ($who, 0, 2) == 'n.')
    {
      $map = substr ($loc_go, 0, 4);
      do_mysql ("UPDATE npc SET location = '".$loc_go."', map = '".$map."' WHERE id_npc = '".$id."';");
    }
    else
    {
      do_mysql ("UPDATE players SET location = '".$loc_go."' WHERE id_player = '".$id."';");
    }
    $loc2 = 'l.'.$loc;

    // pogonja
    if ($inb && substr ($loc_go, 0, 4) != 'rele' && substr ($loc_go, 0, 4) != 'elfc' && substr ($loc_go, 0, 4) != 'verg')
    {
      $tinb = 0;
      if ($inb == 1) $tinb = 2;
      else $tinb = 1;
      $q = do_mysql ("SELECT fullname FROM npc WHERE location = '".$loc."' AND in_battle = '".$tinb."';");
      while ($nt = mysql_fetch_assoc ($q)) go_to_loc ($nt['fullname'], $loc_go, $stor, 1);
    }

    // formiruem soobshenie.
    $pere = '';
    if (isset($near))
    {
      $pere = $near[$stor][2];
    }
    if ($li)
    {
      $pere = $li[2];
    }
    if ($pit)
    {
      $gone = 'ушли';
      $come = 'пришли';
    }
    else
    {
      if (!isset($gender))
      {
        // dlja npc, esliimja konchaetsja na 'a', to skorej vsego devushka
        $len = strlen ($login);
        $len2 = $len - 1;
        if (substr($login, $len2) == 'а')
        {
          $gone = 'ушла';
          $come = 'пришла';
        }
        else
        {
          $gone = 'ушел';
          $come = 'пришел';
        }
      }
      else
      {
        if ($gender == 'male')
        {
          $gone = 'ушел';
          $come = 'пришел';
        }
        if ($gender == 'female')
        {
          $gone = 'ушла';
          $come = 'пришла';
        }
      }
    }
    // proverim $n, esli 1 to eto npc i nado vsem pisatq, esli net to perehodjashemu ne nado
    if ($n)
    {
      $need = 1;
    }
    else
    {
      $need = 0;
    }
    // v byvshuju lokaciju 
    add_journal ('<b>'.$name.''.$pit.' '.$gone.' '.$pere.'</b>', 'l.'.$loc, $need);
    // v novuju
    add_journal ('<b>'.$come.' '.$name.''.$pit.'</b>', 'l.'.$loc_go, $need);
    //echo '<br/>show info = '.$show_info.'<br/>';
    //echo 'n = '.$n.'<br/>';
    //echo 'settings 4 = '.$p['settings'][4].'<br/>';
    // takzhe, esli showinfo = 1, perehodjashemu chelu pokazatq info toj karty
    if ($show_info && !$n)
    {
      global $p;
      if ($p['settings'][4] == 1)
      {
        $lg = loc ($loc_go, 'locinfo');
        // kartinki v locpics/(nazvanie karty).jpg
        $map = substr ($loc_go, 0, 4);
        //$mapi = gen_header ($lg[1]);
        $mapi = '';
        //$mapi .= '<div class="y" id="adg"><b>'.$lg[1].'</div>';
        if (file_exists ('modules/locpics/'.$map.'.JPEG'))
        {
          $mapi .= '<p><img src="modules/locpics/'.$map.'.JPEG" alt="."/></p>';
        }
        // teperq infa
        // '/mapinfo/'.$map.'.mapi'
        if (file_exists ('modules/mapinfo/'.$map.'.txt'))
        {
          $mapi .= '<p>';
          $mapi .= file_get_contents ('modules/mapinfo/'.$map.'.txt');
          $mapi .= '</p>';
        }
        else
        {
          $mapi .= '<p>нет информации</p>';
        }
        //global $sid;
        //$mapi .= '<p><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
        //$mapi .= gen_footer();
        add_journal ($mapi, $p['login']);
      }
    }
  }
?>