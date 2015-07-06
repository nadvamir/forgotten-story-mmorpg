<?php
  // funkcii igroka
  function get_pl_info($login, $what_kind)
  {
    ####### put_error, do_mysql,
    //$login = preg_replace ('/[^a-z_0-9\%]/i', '', $login);
    //$what_kind = preg_replace ('/[^a-z]/i', '', $what_kind);
    // beret informaciju igroka
    // $login - eto login igroka (esli ustanovlen '%self%' to infa dlja samogo igroka;
    // $what_kind opredeljaet kakogo tipa nado
    // all -- vsja
    // battle -- harakteristiki boja
    // location -- tolqko lokacija
    // main -- osnavnaja (dlja oformlenija v funkcii main(login, rassa, klass, urovenq, zhiznq, klan, status1, affected)
    // skills -- tolqko navyk
    // stats -- staty
    //------------------------
    global $dbcnx;
    if ($login == '%self%')
    {
      $_GET['sid'] = mysql_real_escape_string ($_GET['sid']);
      $q4l = mysql_query ("SELECT login FROM session WHERE sid = '".$_GET['sid']."';", $dbcnx);
      if (!$q4l)
      {
        put_error ("<p><b>ERROR:</b> in function get_pl_info, unable to get login with supported session id</p>");
      }
      $login = mysql_result ($q4l, 0);
      if (!$login)
      {
        exit ("<p><b>ERROR</b>: login returned empty</p>");
      }
    }
    $id = is_player ($login);
    if ($what_kind == 'all')
    {
      // vsja infa
      $q4a = do_mysql ("SELECT * FROM players WHERE id_player = '".$id."';");
      $p = mysql_fetch_assoc($q4a);
      if (!$p)
      {
        // put_error ("<p>ERROR: cannot get all information with login '".$login."'</p>");
        return 0;
      }
      //----------------------------
      // teperq nuzhno razbitq dannye: 
      $p['stats'] = explode ('|', $p['stats']);
      $p['skills'] = explode ('|', $p['skills']);
      $p['life'] = explode ('|', $p['life']);
      $p['mana'] = explode ('|', $p['mana']);
      $p['clan'] = explode ('|', $p['clan']);
      $p['last'] = explode ('|', $p['last']);
      $p['kombo_l'] = $p['kombo'];
      $p['kombo'] = explode ('|', $p['kombo']);
      $p['magic_l'] = $p['magic'];
      $p['magic'] = explode ('|', $p['magic']);
      $p['bd'] = explode ('|', $p['bd']);

      $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$login."' AND is_in = 'wea';");
      if (!mysql_num_rows ($q)) $p['weapon'] = '';
      else $p['weapon'] = mysql_result ($q, 0);
      $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$login."' AND is_in = 'mbk';");
      if (!mysql_num_rows ($q)) $p['mbook'] = '';
      else $p['mbook'] = mysql_result ($q, 0);

      return $p;
    }
    if ($what_kind == 'location')
    {
      $a = do_mysql ("SELECT location FROM players WHERE id_player = '".$id."';");
      $loc = mysql_result ($a, 0);
      return ($loc);
    }
    if ($what_kind == 'main')
    {
      $a = do_mysql ("SELECT id_player, classof, rase, stats, skills, life, clan, status1, gender, age, regtime, marry, monsterkill, playerkill, kbmonster, kbplayer, name FROM players WHERE id_player = '".$id."';");
      $mi = mysql_fetch_assoc ($a);
      $mi['login'] = $login;
      $mi['life'] = explode ('|', $mi['life']);
      $mi['clan'] = explode ('|', $mi['clan']);
      $mi['stats'] = explode ('|', $mi['stats']);
      $mi['skills'] = explode ('|', $mi['skills']);
      return $mi;
    }
    if ($what_kind == 'skills')
    {
      $a = do_mysql ("SELECT skills FROM players WHERE id_player = '".$id."';");
      $sk = mysql_result ($a, 0);
      $sk = explode ('|', $sk);
      return $sk;
    }
    if ($what_kind == 'stats')
    {
      $a = do_mysql ("SELECT stats FROM players WHERE id_player = '".$id."';");
      $st = mysql_result ($a, 0);
      $st = explode ('|', $st);
      return $st;
    }
  }
?>