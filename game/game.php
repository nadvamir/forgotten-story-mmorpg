<?php
  // GLAVNYJ FAJL IGRY
  // SEGODNJA 04-07-2007
  //--------------------
  ///////////////////////////
  //ob_start( 'ob_gzhandler' );
  error_reporting (E_ALL);
  // perepisyvaem proverku oshibok, chtoby vsegda pokazyvalo
  function myErrorHandler($errno, $errstr, $errfile, $errline)
  {
    switch ($errno) {
    case E_USER_ERROR:
      echo "<br/><b>FATAL ERROR</b> [$errno] $errstr<br /><br/>";
      echo "  Fatal error on line $errline in file $errfile";
      echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />";
      echo "Aborting...<br />";
      exit(1);
    break;

    case E_USER_WARNING:
      echo "<br/><b>WARNING</b> [$errno] $errstr<br />";
      echo "  Error on line $errline in file $errfile<br />";
      break;

    case E_USER_NOTICE:
      echo "<br/><b>NOTICE</b> [$errno] $errstr<br />";
      echo "  Error on line $errline in file $errfile<br />";
        break;

    default:
      echo "<br />Unknown error type: [$errno] $errstr<br />";
      echo "  Error on line $errline in file $errfile<br />";
      break;
    }

    /* Don't execute PHP internal error handler */
    //return true;
	// pustq zapishet v logi, esli takie imejutsja
  }
  // set to the user defined error handler
  $old_error_handler = set_error_handler("myErrorHandler");

  function make_seed()
  {
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
  }
  srand(make_seed());
  //--------------------------
  function gettime ()
  {
    $part_time = explode (' ', microtime());
    $real_time = $part_time[1] . substr ($part_time[0], 1);
    return $real_time;
  }
  $TIME_START = gettime ();
  $TEST_TIME;
  $TTALL = 0;;
  function stime ()
  {
    global $TEST_TIME;
    $TEST_TIME = gettime();
  }
  function etime ($txt = '')
  {
    global $TEST_TIME;
    $stop_time = gettime ();
    $diff_time = substr (($stop_time - $TEST_TIME), 0, 8);
    global $TTALL;
    if ($diff_time < 1) $TTALL += $diff_time;
    echo $txt.': '.$diff_time.'   ('.($TTALL).')<br/>';
  }

  if (isset ($_GET['action']))
    $action = $_GET['action'];
  else
    $action = '';

//stime();
  ///////////////////////////////
  $sid = preg_replace ('/[^a-z0-9:_]/', '', $_GET['sid']);
  if (!isset ($_GET['action'])) $_GET['action'] = '';
  $NO_CONTINUE = 0;
  // podgruzim nachalnye moduli:
  // podkljuchenija k baze dannyh:
  require_once ('modules/config.php');
  $sid = mysql_real_escape_string ($sid);
  //require_once ('modules/f_defend.php');
  //defend();
  // funkcii igry
  require_once ('modules/f_game.php');
  // teperq nado aurorizirovatq, obnovtq sid
  require_once ('modules/autorize.php');
  // tak kak avtorizacija navernjaka uspeshna, dostaem vsja infu igroka
  $p = get_pl_info ($LOGIN, 'all');

  ///////////////////////////////////////
  // konstanty
  include_once ('modules/constants.php');

  ///////////////////////////////////
  // obnovlenie togdato...
  if (isset ($_GET['action']))
    $action = $_GET['action'];
  else
    $action = '';
  $tm = 1;
  $time = time();

  include 'modules/s_sys_pl_temperature.php';

  if (($action == 'attack' || $action == 'do_dmg' || substr ($action, 0, 3) == 'use' || substr ($action, 0, 4) == 'take' || substr ($action, 0, 4) == 'drop' || substr ($action, 0, 4) == 'cast' || substr ($action, 0, 4) == 'cast' || $action == 'go_to_loc') || $time - $p['last'][0] == 0) $tm += $T;
  if ($time - $p['last'][0] < $tm)
  {
    // formiruem blokirujusheju stranicu, no na nej pomestim ssylku prodolzhitq dejstvie:
    $str = $_SERVER['QUERY_STRING'];
    // iz $str nado vyreatq sid
    // nam pomozhet strpos
    $pos = strpos ($str, '&');
    // esli netu &, to eto ssylka na glavnuju, my ee i tak napishem
    if ($pos)
    {
      $str1 = substr ($str, ($pos + 1));
      $str2 = 'sid='.$sid.'&'.$str1;
    }
    else $str2 = 'sid='.$sid;

    $f = gen_header ('Забытая История');
    $f .= '<div class="y" id="udak"><b>Пауза</b>:</div>';
    $f .= '<p>';
    $f .= 'Вы движетесь слишком быстро. Неспешите так! Ваше состояние не позволяет вам так двигатся!<br/>';

    include_once ('modules/f_get_affected.php');
    $pl_eff = get_affected ($LOGIN);
    if ($pl_eff)
    {
      $f .= 'Эффекты:<br/>-';
      include_once ('modules/f_translit.php');
      $pl_eff = implode ('|', $pl_eff);
      $pl_eff = translit ($pl_eff);
      $pl_eff = str_replace ('|', '<br/>-', $pl_eff);
      $f .= $pl_eff;
    }

    $f .= '<a class="blue" href="game.php?'.$str2.'">далее</a> | ';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
    $f .= gen_footer ();
    exit ($f);
  }

  // proverka otkryta li igra
  if (file_exists ('modules/posts/closed.txt'))
  {
    
    $fr = file ('modules/posts/closed.txt');
    if ($p['admin'] < $fr[0])
    {
      die ('the game data is updating, so the game is closed');
    }
  }

  // lokacii
  include_once ('modules/f_loc.php');

  // vkljuchaem lokacii... chtob izbezhatq dvadcati vkljuchenij
  $loc = substr ($p['location'], 0, 4);
  $p['map'] = $loc;
  $pl_map = $loc;
//etime('start');
//stime();

  make_namespace ($loc);
//etime ('namespace');
//stime();

  // nu a teperq mozhno nachatq delatq stranicu
  //-------------------------------
  //-------------------------------
  // udalim starye teleporty:
  do_mysql ("DELETE FROM items WHERE realname LIKE 'i.o.sta.portal%' AND on_drop < '".$time."';");
//etime ('teleport');
//stime();
  ////////////////////////////////////////
  // perehod samoe pervoe
  ///////////////////////////////////////
  if ($p['admin'] == -2) $action = 'forum';
  if ($action == 'go_to_loc') include 'modules/s_go_to_loc.php'; // perehod na druguju lokaciju
//etime('go to loc');
//stime();
  include_once ('modules/s_loadmaps.php'); // razberemsja so vsemi kartami veshjami i etc
//etime('loadmaps');
//stime();
  include_once ('modules/f_initialise_player.php');
  initialise_player();
//etime('init');
//stime();
  ///////////////////////////////////////
  include_once ('modules/s_syswatch.php'); // sistemnaja slezhka
//etime('syswatch');
//stime();
  ////////////////////////////////////////
  // voopervyh, proizvolqnoe napadenie npc na igroka: (esli jeto ogresivnyj npc
  $q = do_mysql ("SELECT COUNT(*) FROM npc WHERE type = 'x' AND location = '".$p['location']."';");
  $cagr = mysql_result ($q, 0);
  if ($cagr) include 'modules/sp/sp_npc_attack.php';
  $q = do_mysql ("SELECT COUNT(*) FROM npc WHERE in_battle <> '' AND location = '".$p['location']."';");
  if (mysql_num_rows ($q)) include 'modules/sp/sp_npc_try_do_dmg.php';
  ///////////////////////////////////////
  // teperq esli igrok boju smenim rezhim chata na rezhim lokacii
  if ($p['in_battle'] && $p['settings'][1] == 0)
  {
    $p['settings'][1] = 1;
    do_mysql ("UPDATE players SET settings = '".$p['settings']."' WHERE id_player = '".$p['id_player']."';");
  }
//etime('npcblock');
  ///////////////////////////////////////
  // pri koekakih dejstvijah zhurnal meshaet, stavim flag
  if ($p['admin'] == -2) $action = 'forum';
//stime();
  do_mysql ("DELETE FROM fonline WHERE login = '".$LOGIN."';");
//etime('fo');
  if (!$action) include 'modules/s_main.php'; // glavnaja igry
  if ($action == 'attack') $action = 'do_dmg';
  if ($action == 'showskills') $action = 'show_skills';
  if ($action == 'mod_settings') $action = 'change_settings';
  ////////////////////////////////////////////////////////////
  // dejstvija samogo vysokogo prioriteta:
  if ($action == 'bd') include 'modules/s_bd.php'; // Bystrye dejstvija. OBJAZ PERVOE
  if ($action == 'quick_use_magic') include 'modules/s_quick_use_magic.php'; // bystroe isppolqzovanie magii
  if ($action == 'quick_use_magic_b') include 'modules/s_quick_use_magic_b.php'; // bystroe isppolqzovanie magii iz knigi
  if ($action == 'quick_use_kombo') include 'modules/s_quick_use_kombo.php'; // bystroe isppolqzovanie priema
  if ($action == 'change_weapon') include 'modules/s_change_weapon.php'; // pomenjatq mestami oruzhija
  if ($action == 'addmsg') include 'modules/s_addmsg.php'; // dobavitq napisanoe soobshenie v zhurnal
  if ($action == 'addls') include 'modules/s_addls.php'; // dobavitq napisannoe soobshenie
  if ($action == 'use_skill') include 'modules/s_use_skill.php'; // ispolqzovatq navyk
  if ($action == 'cast_from_head') include 'modules/s_cast_from_head.php'; // kastovatq magju po pamjati
  if ($action == 'cast_from_scroll') include 'modules/s_cast_from_scroll.php'; // kastovatq so svitka
  if ($action == 'cast_from_book') include 'modules/s_cast_from_book.php'; // kastovatq iz knigi
  ////////////////////////////////////////////////////////////
  // zagruzim zhurnal
  //if ($action == 'speak_npc' && isset ($NO_CONTINUE)) unset ($NO_CONTINUE);
  //if (!isset ($no_journal)) require_once ('modules/s_journal.php');

  //------------------------------
  // dalee, proverim $action
  ////////////////////////////////

  if (!isset ($NOACT) && file_exists ('modules/s_'.$action.'.php'))
  {
    include 'modules/s_'.$action.'.php';
  }

  // esli dojdet to hotq chtoto vkljuchim
  include 'modules/s_main.php'; // glavnaja igry
?>