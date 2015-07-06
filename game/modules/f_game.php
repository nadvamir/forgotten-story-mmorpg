﻿<?php
  // funkcii igry
  //-----------------------------
  function set_smq ($smq, $val)
  {
    global $p;
    $p['smq'][$smq] = $val;
    do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$p['login']."';");
  }
  // function that tells level of the item
  function say_level ($itm)
  {
    return (substr ($itm, strpos ($itm, 'lvl') + 3));
  }
  function is_in ($element, $place)
  {
    if (is_array ($place))
      if (in_array ($element, $place)) return 1;
      else return 0;
    else
      if (strpos ($place, $element) !== false) return 1;
    return 0;
  }
  function exit_msg ($title, $body)
  {
    global $sid;
    global $AFF;
    $title = strip_tags (mysql_real_escape_string (trim ($title)));
    $body = str_replace ('<script', '', (str_replace ('<?', '', (trim ($body)))));
    $f = gen_header ($title);
    $f .= '<div class="y" id="msg"><b>'.$title.':</b></div><div class="n" id="aetyea">';
    $f .= $body;
    $f .= '<br/><a class="blue" href="game.php?sid='.$sid.'">в игру</a></div>';
    $f .= gen_footer();
    exit ($f);
  }
$IDN = array();
  function is_npc ($fullname)
  {
    $fullname = mysql_real_escape_string ($fullname);
    global $IDN;
    if (!isset ($IDN[$fullname]))
    {
      $q = do_mysql ("SELECT id_npc FROM npc WHERE fullname = '".$fullname."';");
      if (!mysql_num_rows ($q)) return 0;
      else $id = mysql_result ($q, 0);
      $IDN[$fullname] = $id;
      return $id;
    }
	// proverjaem, zhiv li eshe
	if (mysql_num_rows ( do_mysql ("SELECT id_npc FROM npc WHERE id_npc = ".$IDN[$fullname]) ))
      return $IDN[$fullname];
    return 0;
  }
$IDP = array();
  function is_player ($login)
  {
    $login = mysql_real_escape_string ($login);
    global $IDP;
    if (!isset ($IDP[$login]))
    {
      $q = do_mysql ("SELECT id_player FROM players WHERE login = '".$login."';");
      if (!mysql_num_rows ($q)) return 0;
      else $id = mysql_result ($q, 0);
      $IDP[$login] = $id;
      return $id;
    }
    return $IDP[$login];
  }
  // ustanavlivaju moskovskoe vremja:
  date_default_timezone_set ('Europe/Moscow');
  function get_month ()
  {
    return date ("n");
  }
  function get_hour ()
  {
    $h = date ("G"); 
    return $h;
  }
  function get_msk_time ()
  {
    $t = get_hour();
    $t .= ':';
    $t .= date ('i:s');
    return ($t);
  }
  //---------------------------------------------
  function string_drop ($str, $drop)
  {
    // chtoby obezopasitq ot gljukov, snachala poprobuem udalitq explodom cherez massiv:
    if ($str == $drop) return '';
    else
    {
      if (strpos ($drop, '~') === false && strpos ($str, '~') !== false)
      {
        // razobqem s pomoshqju ~
        $str = explode ('~', $str);
        $sep = '~';
      }
      else if (strpos ($drop, '|') === false && strpos ($str, '|') !== false)
      {
        // razobqem s pomoshqju |
        $str = explode ('|', $str);
        $sep = '|';
      }
      else
      {
        //reshim vse standartno:
        $str = str_replace ('|'.$drop, '', $str);
        $str = str_replace ($drop.'|', '', $str);
        $str = str_replace ($drop, '', $str);
        $str = str_replace ('||', '|', $str);
        if (substr ($str, 0, 1) == '|') $str = substr ($str, 1);
        return $str;
      }
      // esli rabota prodolzhaetsja, stroka kakimto obrazom razbita
      // kolichestvo elementov:
      $c = count ($str);
      for ($i = 0; $i < $c; $i++)
      {
        // udalim
        if ($str[$i] == $drop) unset ($str[$i]);
      }
      // zanovo soedinim:
      $str = implode ($sep, $str);
      if (substr ($str, 0, 1) == $sep) $str = substr ($str, 1);
      return $str;
    }
  }
  //-------------------------------------------------
  function gen_header($title)
  {
    global $sid;
    global $p;
    $locmap = substr ($p['location'], 0, 4);
    global $COLOR;
    // sozdaet zagolovok
    include_once ('modules/f_gen_colour.php');
    $colour = gen_colour();
    $cch = 0; // if color changed, text black
    //-----------
    // spec sluchai -
    /*if (isset ($COLOR[$locmap]))
    {
      $colour[3] = $COLOR[$locmap][3];
      $colour[4] = $COLOR[$locmap][4];
      $colour[5] = $COLOR[$locmap][5];
      $cch = 1;
    }
    if (isset ($COLOR[$p['location']]))
    {
      $colour[3] = $COLOR[$p['location']][3];
      $colour[4] = $COLOR[$p['location']][4];
      $colour[5] = $COLOR[$p['location']][5];
      $cch = 1;
    } */
    
    $header = '<?xml version="1.0" encoding="UTF-8"?>';
    $header .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">';
    $header .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">';
$header = '<html>';
    $header .= '<head><title>'.$title.'</title>';
    $header .= "<meta http-equiv='Content-Type' content='application/xhtml+xml; charset=utf-8' />";
    $header .= '<meta http-equiv="cache-control" content="no-cache" />';
    $header .= '<meta http-equiv="pragma" content="no-cache" />';
    $header  .= '<meta name="copyright" content="&copy; 2008 Maksim Solovjov" />';
    //if ($_GET['action'] != 'forum' && $_GET['action'] != 'speak_npc' && $_GET['action'] != 'wmsg' && $_GET['action'] != 'wls') $header .= "<meta http-equiv='refresh' content='180;url=game.php?sid=".$sid."'>";

    /*if (is_array ($p['life']))
    {
      // fireplace changes color - 
      $q = do_mysql ("SELECT on_drop FROM items WHERE location = '".$p['location']."' AND on_take = 'on';");
      if (mysql_num_rows ($q))
      {
        $colour[3] = mysql_result ($q, 0);
        $colour[4] = '#FFFFFF';
        $colour[5] = '#FFFFFF';
        $cch = 1;
      }
    }
    if ($cch)
    {
      $colour[6] = '#000000'; // osnovnoj tekst
      $colour[7] = '#0000aa'; // sinie ssylki
      $colour[8] = '#ff0000'; // krasnye ssylki
    }*/
    //--
    $header .= '<style type="text/css">';
    $header .= 'body{text-align:center; font-size:small;}';
    $header .= 'a{text-decoration:none}';
    $header .= 'a.black{color:#000000}';
    $header .= 'a.red{color:'.$colour[8].'; font-weight:bold}';
    $header .= 'a.orange {color:#fac800}';
    $header .= 'a.blue{color:'.$colour[7].'}';
    $header .= 'a.green{color:#00ff00}';
    $header .= 'a.bas{color:'.$colour[7].'}';
    $header .= 'a.nor{color:'.$colour[7].'}';
    $header .= 'a.fur{color:#8B4513}';
    $header .= 'a.tun{color:#CDAA7D}';
    $header .= 'a.bet{color:#00BFFF}';
    $header .= 'a.rar{color:#9A32CD}';
    $header .= 'a.eli{color:#66CD00}';
    $header .= 'a.epi{color:#CD0000}';
    $header .= 'a.leg{color:#EEC900; font-weight:bold}';
    $header .= 'a.hamelion{color:'.$colour[3].'}';
    $header .= 'a.blagouhanie{color:#F33C6B}';
    $header .= 'span.bas{color:'.$colour[6].'}';
    $header .= 'span.nor{color:'.$colour[6].'}';
    $header .= 'span.fur{color:#8B4513}';
    $header .= 'span.tun{color:#CDAA7D}';
    $header .= 'span.bet{color:#00BFFF}';
    $header .= 'span.rar{color:#9A32CD}';
    $header .= 'span.eli{color:#66CD00}';
    $header .= 'span.epi{color:#CD0000}';
    $header .= 'span.leg{color:#EEC900; font-weight:bold}';
    $header .= 'span.black{color:'.$colour[6].'}';
    $header .= 'span.red {color:#ff0000}'; // krovotechenie
    $header .= 'span.gray {color:#B3B3B3}'; 
    $header .= 'span.green {color:#00ff00}'; // otravlen
    $header .= 'span.blue {color:'.$colour[7].'}'; // holodno
    $header .= 'span.yellow {color:#ffff00}'; // zharko
    $header .= 'span.orange {color:#fac800}'; // gorit
    $header .= 'span.mine {color:#009900}'; // moj tekst v soobshenijah
    $header .= 'input{background-color:#ffffff;}';

    $agent = $_SERVER['HTTP_USER_AGENT'];
    $wdt = '';
    //if (strpos ($agent, 'MSIE') || strpos ($agent, 'Opera') || strpos ($agent, 'Firefox')) $wdt = ' width: 240px;';
    $header .= 'table{color:'.$colour[6].'}';
    $header .= 'div.y{text-align:left;'.$wdt.' background-color:'.$colour[0].'; margin: 0px; padding:0px 1px 0px 3px; border-left:1px solid '.$colour[1].'; border-top:1px solid '.$colour[1].'; border-right:2px solid '.$colour[2].'; border-bottom:2px solid '.$colour[2].'}';
	//$header .= '.y { background-color:'.$colour[0].'; border: 2px outset '.$colour[0].'; }';
    $header .= 'div.p{text-align:left;'.$wdt.' border: 1px dotted '.$colour[2].'}';   
    $header .= 'div.n{text-align:left; color:'.$colour[6].';'.$wdt.' background-color:'.$colour[3].'; margin: 0px; padding:1px 1px 1px 3px; border-left:1px solid '.$colour[4].'; border-top:1px solid '.$colour[4].'; border-right:2px solid '.$colour[5].'; border-bottom:2px solid '.$colour[5].'}';
    $header .= 'div.c{text-align:center}';
    $header .= 'div.t{font-size:smaller; margin-left:2%; margin-right:2%}';
    $header .= 'p{text-align:left; color:'.$colour[6].'; '.$wdt.' background-color:'.$colour[3].'; margin: 0px; padding:1px 1px 1px 3px; border-left:1px solid '.$colour[4].'; border-top:1px solid '.$colour[4].'; border-right:2px solid '.$colour[5].'; border-bottom:2px solid '.$colour[5].'}';
    $header .= 'form {margin:0; padding:0;}';
    //$header .= '#minimap_table td {width: 0.5em; height: 0.5em; overflow:hidden;}';
    $header .= '</style>';
    //--
    $header .= '</head><body>';
    if (is_array ($p['life']))
    {
    $f = '';
    $set = substr ($p['settings'], 0, 1);
    if ($set == 1)
    {
      if ($p['life'][0] * 4 < $p['life'][1])
      {
        $redl1 = '<span class="red">';
        $redl2 = '</span>';
      }
      else
      {
        $redl1 = '';
        $redl2 = '';
      }
      $f .= '<div class="y" id="sadas">';
      $f .= 'HP: '.$redl1.''.$p['life'][0].'|'.$p['life'][1].''.$redl2.' MP: '.$p['mana'][0].'|'.$p['mana'][1].'</div>';
    }
    if ($set == 0)
    {
      // zhiznq mana 
      // esli zhizni malo, to po krasnomu ee
      if ($p['life'][0] * 4 < $p['life'][1])
      {
        $redl1 = '<span class="red">';
        $redl2 = '</span>';
      }
      else
      {
        $redl1 = '';
        $redl2 = '';
      }
      $f .= '<div class="y" id="sadas">';
      $f .= 'HP: '.$redl1.''.$p['life'][0].''.$redl2.' | MP: '.$p['mana'][0].'</div>';
    }
    $header .= $f;
    }

    $a = do_mysql ("SELECT journal FROM players WHERE id_player = '".$p['id_player']."';");
    $journal = mysql_result ($a, 0);
    if ($journal)
    {
      $header .= '<div class="y" id="udak"><b>События</b>:</div><p>';
      $header .= $journal.'</p>';
      do_mysql ("UPDATE players SET journal = '' WHERE id_player = '".$p['id_player']."';");
      $p['journal'] = '';
    }
    /*global $JOURNAL;
    global $LOGIN;
    if (isset ($JOURNAL) && $JOURNAL)
    {
      $header .= '';
      $header .= $JOURNAL;
      do_mysql ("UPDATE players SET journal = '' WHERE id_player = '".$p['id_player']."';");
      $p['journal'] = '';
      unset ($JOURNAL);
      $header .= '';
    }*/
    //$header = '<html><head></head><body>';
    return $header;
  }
  //-------------------------------------
  function put_error ($error)
  {
    ######### gen_header(); ###############
    // vyvedet nadpisq ob oshibke
    $f = gen_header('ошибка!');
    echo $f;
    // ssylk na vhod
    $s = '<p><a href="index.php">на главную</a></p>';
    //!!!!!!!!! esli vrublena test mode to otobrazitsja polnyj text
    $testmode = 1; // !!! kak protestirueshq, zakomentiruj
    if ($testmode)
    {
      $error = strip_tags(addslashes($error));
      exit ('<p>'.$error.'</p>'.$s);
    }
    if (!$testmode)
    {
      global $dbcnx;
      mysql_close ($dbcnx);
      exit ('<p>Произола ошибка. Дальнейшая обработка страници невозможна. Админuстрация приносит свои извинения :(</p>'.$s);
    }
  }
  //-------------------------------------
  function put_g_error ($error)
  {
    ######### gen_header(); ###############
    // vyvedet nadpisq ob oshibke (igrovuju, otobazhatq mozhno)
    global $sid;
    $f = gen_header('ошибка!');
    echo $f;
    echo '<div class="y" id="asf5"><b>ошибка:</b></div>';
    // ssylk na vhod
    $s = '<p><a href="game.php?sid='.$sid.'">далее</a></p>';
    $s .= gen_footer();
    {
      $error = htmlspecialchars(addslashes($error));
      $error .= $s;
      exit ('<p>'.$error.'</p>');
    }
  }
  //----
  function do_mysql ($query)
  {
    ######### put_error(); ###############
    global $dbcnx;
    $a = mysql_query ($query, $dbcnx);
    if (!$a)
    {
      put_error ('error in mysql, the query was '.$query);
    }
    return $a;
  }
  //--------------------------------
  function add_journal ($what, $who, $auth = 1)
  {
    ######### do_mysql(); ############
    $what = mysql_real_escape_string( strip_tags ($what, '<img><b><br/><i><span>'));
    $who = preg_replace ('/[^a-z0-9\|\._]/i', '', $who);
    $what = str_replace ('[green]', '<span style="color:#129812">', $what);
    $what = str_replace ('[orange]', '<span style="color:#AA2412">', $what);
    $what = str_replace ('[/end]', '</span>', $what);
    // dobavljaet soobshenie v zhurnal
    // $who == '%all%' -- vsem igrokam igry
    // $who == 'l.' -- vsej lokacii
    // else - konkretnomu igroku (login)
    global $dbcnx;
    if ($who == '%all%')
    {
      // dobavitq vsem
      $q = do_mysql ("SELECT id_player, login, journal FROM players;");
      while ($j = mysql_fetch_assoc ($q))
      {
        if ($auth == 0)
        {
          // avtoru ne pisatq
          global $LOGIN;
          if ($j['login'] == $LOGIN)
            continue;
        }
        $j['journal'] .= $what.'<br/>';
        do_mysql ("UPDATE players SET journal = '".$j['journal']."' WHERE id_player = '".$j['id_player']."';");
      }
    }
    else if (substr ($who, 0, 2) == 'l.')
    {
      // dobavitq vsem v loku
      $loc = substr ($who, 2);
      $q = do_mysql ("SELECT id_player, login, journal FROM players WHERE location = '".$loc."' AND active = 1;");
      while ($j = mysql_fetch_assoc ($q))
      {
        if ($auth == 0)
        {
          // avtoru ne pisatq
          global $LOGIN;
          if ($j['login'] == $LOGIN)
            continue;
        }
        // tolqko esli zhurnal vkljuchen
        $qjs = do_mysql ("SELECT settings FROM players WHERE id_player = '".$j['id_player']."';");
        $js = mysql_result ($qjs, 0);
        if ($js[3] == 0) continue;
        $j['journal'] .= $what.'<br/>';
        do_mysql ("UPDATE players SET journal = '".$j['journal']."' WHERE id_player = '".$j['id_player']."' AND active = '1';");
      }
    }
    else
    {
      // dobavitq konkretno chelam
      // delaem masiv
      $who = explode ("|", $who);
      $c = count ($who);
      for ($i = 0; $i < $c; $i++)
      {
        if (!$who[$i])
        {
          // zamechal, chto inogda v masivah sostavljaemyh implode'om 
          // i razbityh explodom element 0 byvaet pustoj.
          // potomu esli takoj popadetsja ego propustim
          continue;
        }
        // tolqko esli zhurnal vkljuchen
        $id = is_player ($who[$i]);
        $qjs = do_mysql ("SELECT settings FROM players WHERE id_player = '".$id."';");
		if (!mysql_num_rows ($qjs)) continue;
        $js = mysql_result ($qjs, 0);
        if ($js[3] == 0) continue;
        $q = do_mysql ("SELECT journal FROM players WHERE id_player = '".$id."';");
        if (mysql_num_rows ($q))
        {
          $j = mysql_result ($q, 0);
          $j .= $what.'<br/>';
          do_mysql ("UPDATE players SET journal = '".$j."' WHERE id_player = '".$id."';");
        }
      }
    }
  }
  //----
  function check1 ($string)
  {
    ########### funkcij net #############
    // proverit $string
    $string = mysql_real_escape_string( htmlspecialchars ( addslashes ( trim ( str_replace ('|', '', $string)))));
    return $string;
  }
  //----
  function gen_footer ()
  {
    $f2 = '';
    // profilirovanie scenarija:
    global $TIME_START;
    $stop_time = gettime ();
    $diff_time = substr (($stop_time - $TIME_START), 0, 6);
    $f2 .= '<p><small>'.$diff_time.'сек.</small></p>';
    $f2 .= '<div class="y" id="ladh654">&#169;_himura_</div>';
    $f2 .= '</body></html>';

    // pqjanstvo
    global $AFF;
    if (is_in ('pqjan', $AFF))
    {
      global $f;
      $c = strlen ($f);
      $sym = array ('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
      //for ($i = 0; $i < $c; $i++)
      //  if ($f[$i] >= 'А' && $f[$i] <= 'Я' || $f[$i] >= 'а' && $f[$i] <= 'я') $f[$i] = $sym[((int)$f[$i] % 10)];

      $temp = $f;
      $temp = str_replace('Э', '0', $temp);
      $temp = str_replace('Ю', '1', $temp);
      $temp = str_replace('Я', '2', $temp);
      $temp = str_replace('Ж', '3', $temp);
      $temp = str_replace('Ч', '4', $temp);
      $temp = str_replace('Ш', '5', $temp);
      $temp = str_replace('Ц', '6', $temp);
      $temp = str_replace('э', '7', $temp);
      $temp = str_replace('ю', '8', $temp);
      $temp = str_replace('Я', '9', $temp);
      $temp = str_replace('ж', '0', $temp);
      $temp = str_replace('ч', '1', $temp);
      $temp = str_replace('ш', '2', $temp);
      $temp = str_replace('щ', '3', $temp);
      $temp = str_replace('б', '4', $temp);
      $temp = str_replace('в', '5', $temp);
      $temp = str_replace('г', '6', $temp);
      $temp = str_replace('д', '7', $temp);
      $temp = str_replace('з', '8', $temp);
      $temp = str_replace('й', '9', $temp);
      $temp = str_replace('л', '0', $temp);
      $temp = str_replace('м', '1', $temp);
      $temp = str_replace('н', '2', $temp);
      $temp = str_replace('п', '3', $temp);
      $temp = str_replace('р', '4', $temp);
      $temp = str_replace('т', '5', $temp);
      $temp = str_replace('ф', '6', $temp);
      $temp = str_replace('ц', '7', $temp);
      $temp = str_replace('ъ', '8', $temp);
      $temp = str_replace('у', '9', $temp);
      $temp = str_replace('ь', '0', $temp);
      $temp = str_replace('Б', '1', $temp);
      $temp = str_replace('В', '2', $temp);
      $temp = str_replace('Г', '3', $temp);
      $temp = str_replace('Д', '4', $temp);
      $temp = str_replace('З', '5', $temp);
      $temp = str_replace('И', '6', $temp);
      $temp = str_replace('Й', '7', $temp);
      $temp = str_replace('Л', '8', $temp);
      $temp = str_replace('П', '9', $temp);
      $temp = str_replace('Р', '0', $temp);
      $temp = str_replace('Ф', '1', $temp);
      $temp = str_replace('Ц', '2', $temp);
      $temp = str_replace('Ъ', '3', $temp);
      $temp = str_replace('Ы', '4', $temp);
      $temp = str_replace('Ь', '5', $temp);
      $temp = str_replace('у', '6', $temp);
      $temp = str_replace('и', '7', $temp);
      $temp = str_replace('с', '8', $temp);
      $temp = str_replace('х', '9', $temp);
      $temp = str_replace('У', '0', $temp);
      $temp = str_replace('С', '1', $temp);
      $temp = str_replace('Х', '2', $temp);
      $temp = str_replace('Н', '3', $temp);
      $f = $temp;
    }

    global $dbcnx;
    mysql_close($dbcnx);
    return $f2;
  }
?>