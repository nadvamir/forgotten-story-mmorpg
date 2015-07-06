<?php
  // TELEPORT
  // funkcija ne tolqko dlja igrokov, no i dlja nps
  function teleport ($who, $loc_go)
  {
    # get_pl_info(), do_mysql();, get_npc_info();, loc();, put_error();, delete_from_loc();, add_to_loc();, addjournal();
    require_once 'modules/f_get_pl_info.php';
    require_once 'modules/f_get_npc_info.php';
    require_once 'modules/f_loc.php';
    require_once 'modules/f_add_to_loc.php';
    // proverka dannyh
    //$who = preg_replace ('/[^a-z\._0-9]/i', '', $who);
    //$loc_go = preg_replace ('/[^a-z0-9\|]/i', '', $loc_go);
    global $LOGIN;
    $id;
    $pi = is_player ($who);
    if ($pi)
    {
      $id = $pi;
      $login = $who;
      $lq = do_mysql ("SELECT location FROM players WHERE id_player = '".$id."';");
      $loc = mysql_result ($lq, 0);
      //$loc = get_pl_info ($login, 'location');
      $qg = do_mysql ("SELECT gender FROM players WHERE id_player = '".$id."';");
      $gender = mysql_result ($qg, 0);
      $n = 0;
      // proverka na boj - 
      $q = do_mysql ("SELECT in_battle FROM players WHERE id_player = '".$id."';");
      $inb = mysql_result ($q, 0);
      $qg = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
      $name = mysql_result ($qg, 0);
    }
    else if (substr($who, 0, 2) == 'n.')
    {
      $id = is_npc (substr($who, 2));
      if (!$id) return 0;
      $loc = get_npc_info ($who, 'location');
      $alo = do_mysql("SELECT name FROM npc WHERE id_npc = '".$id."';");
      $login = mysql_result ($alo, 0);
      $name = $login;
      $n = 1;
    }
    // karta na kotoroj stoit
    $map_is = substr ($loc, 0, 4);
    // karta toj loki, na kotoruju poidut
    $map_will = substr ($loc_go, 0, 4);
    // ESLI NA DRUGUJU KARU
    if ($map_is != $map_will)
    {
      // a eshe ustanovim flag show_info, po kotoromu potom opredelim, nado li pokazatq vstupitelqnyj tekst k loakacci
      $show_info = 1;
    }
    else
    {
      // voobshem eto tazhe lokacija
      // vstupitelqnyj tekst ne pisatqi
      $show_info = 0;
    }
    global $NEWMAP;
    $NEWMAP = 1;
    if (!loc ($loc_go, 'locinfo')) return 0;
    // sotrem byvshij inloc
    add_to_loc ($loc_go, $who);
    //////////////////////////////
    // pitomec
    $an = do_mysql ("SELECT name, fullname FROM npc WHERE belongs = '".$login."' AND location = '".$loc."' AND move <> 0;");
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
    // formiruem soobshenie.
    if ($pit)
    {
      $gone = 'исчезли';
      $come = 'появиись';
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
          $gone = 'исчезла';
          $come = 'появилась';
        }
        else
        {
          $gone = 'исчез';
          $come = 'появился';
        }
      }
      else
      {
        if ($gender == 'male')
        {
          $gone = 'исчез';
          $come = 'появился';
        }
        if ($gender == 'female')
        {
          $gone = 'исчезлa';
          $come = 'появилась';
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
    add_journal ('<p>'.$name.''.$pit.' '.$gone.'!</p>', 'l.'.$loc, $need);
    // v novuju
    add_journal ('<p>'.$come.' '.$name.''.$pit.'</p>', 'l.'.$loc_go, $need);

    $p = get_pl_info ($who, 'all');
    $NEWMAP = 1;
    include 'modules/s_loadmaps.php'; // zagruzim kartu
    unset ($p);

    //echo '<br/>show info = '.$show_info.'<br/>';
    //echo 'n = '.$n.'<br/>';
    //echo 'settings 4 = '.$p['settings'][4].'<br/>';
    // takzhe, esli showinfo = 1, perehodjashemu chelu pokazatq info toj karty
    if ($show_info && !$n && $who == $LOGIN)
    {
      global $p;
      do_mysql ("UPDATE gamesys SET life_regen = 0;");
      if ($p['settings'][4] == 1)
      {
        $lg = loc ($loc_go, 'locinfo');
        // kartinki v locpics/(nazvanie karty).jpg
        $map = substr ($loc_go, 0, 4);
        $mapi = gen_header ($lg[1]);
        $mapi .= '<div class="y" id="adg"><b>'.$lg[1].'</div>';
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
        global $sid;
        $mapi .= '<p><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
        $mapi .= gen_footer();
        exit ($mapi);
      }
    }
  }
?>