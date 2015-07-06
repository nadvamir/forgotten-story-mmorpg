<?php
  // fail avtorizacii dlja igry

  // zapros v sessiju
  $q = do_mysql ("SELECT * FROM session WHERE sid = '".$sid."';");
  // teperq nado dannye proveritq, i esli poluchitsja podkljuchitq
  $sto = strpos ($sid, ':');
  $lg = substr ($sid, 0, $sto);
  $sid = substr ($sid, ($sto + 1));
  $nm = substr ($sid, 0, 1);
  $pp1 = substr ($sid, 1, $nm);
  $pp2 = substr ($sid, ($nm + 2));
  $NUM = $pp1.''.$pp2;

  if (!mysql_num_rows ($q))
  {
    // netu takogo
    // vozqmem sid iz sessii gde login takov
    $q2 = do_mysql ("SELECT sid FROM session WHERE num = '".$NUM."' AND login = '".$lg."';");
    if (!mysql_num_rows ($q2)) exit ('<html><head></head><body><p>ошибка авторизации<br/><a href="index.php">на главную</a></p></body></html>');
    $sid3 = mysql_result ($q2, 0);
    //exit ('<html><head></head><body><p>серия запрешена<br/><a href="game.php?sid='.$sid3.'">в игру</a></p></body></html>');
    $sid = $sid3;
    // zapretim knopku nazad lishq v neskolqkih mestah
    if (isset ($_GET['action']))
      $action = $_GET['action'];
    else
      $action = '';
	if ( ($action == 'attack' || $action == 'do_dmg' 
        || substr ($action, 0, 3) == 'use' 
        || substr ($action, 0, 4) == 'take' 
        || substr ($action, 0, 4) == 'drop' 
        || substr ($action, 0, 4) == 'cast' 
        || $action == 'go_to_loc') )
	
	    $_GET['action'] = '';
    // sohronim ot vyleta
    $_GET['sid'] = $sid;
    $q = do_mysql ("SELECT * FROM session WHERE sid = '".$sid."';");
  }
  $ses = mysql_fetch_assoc ($q);
  $LOGIN = $ses['login'];
  /*if (isset ($_COOKIE['l']) && $_COOKIE['l'] != $LOGIN)
  {
    $lgb = preg_replace ('/[^a-z0-9_]/i', '', $_COOKIE['l']);
    if ($lgb != 'maxx') do_mysql ("UPDATE players SET admin = '-2' WHERE login = '".$lgb."';");
    if ($LOGIN != 'maxx') do_mysql ("UPDATE players SET admin = '-2' WHERE login = '".$LOGIN."';");
  }
  setcookie ("l", $LOGIN, time() + 300);*/
  $PASS = $ses['pass'];
  // zapros na vernostq:
  $a = mysql_query ("SELECT pass FROM players WHERE login = '".$LOGIN."';", $dbcnx);
  if (!mysql_num_rows($a))
  {
    // netu takogo logina
    exit ('<html><head></head><body><p>ошибка авторизации<br/><a href="index.php">на главную</a></p></body></html>');
  }
  $pass2 = mysql_result ($a, 0);
  if ($pass2 != $PASS)
  {
    echo $pass2.' != '.$PASS;
    // netu takogo parolja
    exit ('<html><head></head><body><p>ошибка авторизации</p><br/><a href="index.php">на главную</a></body></html>');
  }
  //-----------------------------------------
  //$ip = $_SERVER['HTTP_X_REAL_IP'];
  //if (!$ip) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  $ip = $_SERVER['REMOTE_ADDR'];
  $ip .= '|'.$_SERVER['HTTP_USER_AGENT'];
  if ($ip != $ses['ip'])
  {
    do_mysql ("DELETE FROM session WHERE sid = '".$sid."';");
    exit ('<p>ошибка авторизации<br/><a href="index.php">на главную</a></p>');
  }
  // zapros na teh u kogo ip odinakogyj.
//  $qip = do_mysql ("SELECT COUNT(*) FROM session WHERE ip = '".$ip."';");
//  $cip = mysql_result ($qip, 0);
//  if ($cip > 1)
//  {
//    $qip = do_mysql ("SELECT login FROM session WHERE ip = '".$ip."' AND login <> '".$LOGIN."';");
//    while ($l = mysql_fetch_assoc ($qip))
//      do_mysql ("UPDATE players SET admin = '-2' WHERE login = '".$l['login']."' AND admin <> 2;");
//  }
  //------------------------------------------
  $sid = $LOGIN.':';
  $num = rand (1, 9);
  $sid .= $num;
  $sid .= substr ($NUM, 0, $num);
  $num2 = rand (1, 9);
  $sid .= $num2;
  $sid .= substr ($NUM, $num);
  $_GET['sid'] = $sid;
  // obnovim vse dannye sessii
  do_mysql ("UPDATE session SET sid = '".$sid."', puttime = NOW() WHERE login = '".$LOGIN."';");
  // zagruzki
  include_once ('modules/f_get_pl_info.php');
  // teperq vse :)
?>