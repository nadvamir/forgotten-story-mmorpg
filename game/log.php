<?php
  require_once ('modules/config.php');
  require_once ('modules/f_defend.php');
  defend();
  require_once ('site_header.php');
  require_once ('site_footer.php');

  // udalenie ne aktivirovavshihsja:
  //mysql_query ("DELETE FROM players WHERE actcode <> '' AND regtime + 21600 < ".(time()).";", $dbcnx);

/*  // udalenija staryh - 
  // esli ostalisq starye, ih nado udalitq, no eshe i s lokacii vykinutq
  $a = mysql_query ("SELECT login FROM session WHERE puttime < NOW() - INTERVAL '5' MINUTE", $dbcnx);
  // zagruzki
  require_once ('modules/f_delete_from_loc.php');
  require_once ('modules/f_get_pl_info.php');
  // perebor
  while ($del = mysql_fetch_assoc ($a))
  {
    $del_loc = get_pl_info ($del['login'], 'location');
    delete_from_loc ($del_loc, $del['login']);
  }*/
  // stranica logina
  // vse dannye na nee uzhe otoslany
  // teperq nado ih proveritq, i esli poluchitsja podkljuchitq
  $login = $_GET['login'];
  $login = preg_replace('/[^a-z0-9_]/i', '', $login);
  $login = strtolower ($login);
  $pass = $_GET['pass'];
  $pass_a = $pass;
  $pass = md5($pass);
  // zapros na vernostq:
  $a = mysql_query ("SELECT pass FROM players WHERE login = '".$login."';", $dbcnx);
  if (!mysql_num_rows($a))
  {
    // netu takogo logina
    exit ("<p>логин не найден</p>");
  }
  $pass2 = mysql_result ($a, 0);
  if ($pass2 != $pass)
  {
    // netu takogo parolja
    exit ('<p>неверный пароль</p>');
  }
  ////////////////
  // proverka na okonchenuju registraciju (aktivacija)
  /*$qr = mysql_query ("SELECT actcode FROM players WHERE login = '".$login."';", $dbcnx);
  $act = mysql_result ($qr, 0);
  if ($act)
  {
    if (isset ($_GET['act']))
    {
      // proverjaem
      if ($act != $_GET['act']) exit ('<p>код активации не верен</p>');
      mysql_query ("UPDATE players SET actcode = '' WHERE login = '".$login."'", $dbcnx);
    }
    else
    {
      $f = gen_sheader ('активизация');
      $f .= '<div class="y" id="oiuytr">угодайте код который мы вам отослали на эмайл, и вы войдете:</div>';
      $f .= '<form action="log.php" method="get"><p><input type="hidden" name="login" value="'.$login.'"/><input type="hidden" name="pass" value="'.$pass_a.'"/><input type="text" name="act"/><input type="submit" value="&#187;"/></p></form>';
      $f .= gen_sfooter();
      exit ($f);
    }
  }*/
  ////////////////
  // proverka na okonchenuju registraciju (rassa)
  $qr = mysql_query ("SELECT rase FROM players WHERE login = '".$login."';", $dbcnx);
  $rase = mysql_result ($qr, 0);
  if (!$rase) exit ('<p>вы еше не окончили регистрацию!<br/><a href="reg2.php?login='.$login.'&pass='.$pass_a.'">окончить</a></p>');
  ////////////////
  // kolq skript prodolzhaetsja, vidatq vse pravilqno
  //poetomu sozdadim sessiju
  // sekretnaja cifra :)))
  $numa = rand (2, 1000);
  $numa = md5 ($numa);
  $sid = $login.':';
  $num = rand (1, 9);
  $sid .= $num;
  $sid .= substr ($numa, 0, $num);
  $num2 = rand (1, 9);
  $sid .= $num2;
  $sid .= substr ($numa, $num);
  // udalim staruju sessiju
  mysql_query ("DELETE FROM session WHERE login = '".$login."';", $dbcnx);
  // sozdadim novuju
  //$ip = $_SERVER['HTTP_X_REAL_IP'];
  // (!$ip) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  $ip = $_SERVER['REMOTE_ADDR'];
  $ua = $_SERVER['HTTP_USER_AGENT'];
  add_ip ($ip, $ua, $login);
  $ip .= '|'.$ua;
  mysql_query ("INSERT INTO session VALUES ('".$sid."', '".$login."', '".$pass."', NOW(), '".$ip."', '".$numa."');", $dbcnx);
  ////////
  $q = mysql_query ("SELECT last, admin FROM players WHERE login = '".$login."';", $dbcnx);
  $l = mysql_fetch_assoc ($q);
  $last = explode ('|', $l['last']);
  // poslednij razegeneracija sejchas bud:
  $last[2] = time();
  $nlast = $last[0].'|'.$last[1].'|'.$last[2].'|'.$last[3].'|'.$last[4].'|'.$last[5].'|'.$last[6].'|'.$last[7].'|'.$last[8];
  mysql_query ("UPDATE players SET active = '1', last = '".$nlast."' WHERE login = '".$login."';", $dbcnx);
  // tem kto v polnom bloke -3 wiw:
  if ($l['admin'] == -3) exit ('вы в абсолютном блоке!');

  // proverka otkryta li igra
  if (file_exists ('modules/posts/closed.txt'))
  {
    
    $fr = file ('modules/posts/closed.txt');
    if ($fr[0] > $l['admin'])
    {
      die ('the game data is updating, so the game is closed');
    }
  }
  /*if (isset ($_COOKIE['l']) && $_COOKIE['l'] != $login)
  {
    $lgb = preg_replace ('/[^a-z0-9_]/i', '', $_COOKIE['l']);
    if ($lgb != 'maxx') do_mysql ("UPDATE players SET admin = '-2' WHERE login = '".$lgb."';");
    if ($login != 'maxx') do_mysql ("UPDATE players SET admin = '-2' WHERE login = '".$login."';");
  }
  setcookie ("l", $login, time() + 300);*/

  // i tak kak vse horosho, sozdadim stranicu s privetstviem
  $f = gen_sheader ('приветствие!');
  $f .= '<div class="y" id="oiuytr">';
  $f .= 'Здравствуйте, '.$login.'!</div><div class="n" id="wt743t">';
  $q = mysql_query ("SELECT puttime FROM news ORDER BY puttime DESC;", $dbcnx);
  if (mysql_num_rows ($q))
  {
    $pt = mysql_result ($q, 0);
    //$pt = substr ($pt, 0, 10);
    $f .= 'Hовости от <a class="black" href="news.php">'.$pt.'</a><br/>';
  }
  // proverka maximalqnogo onlajn:
  $q = mysql_query ("SELECT COUNT(*) FROM session;", $dbcnx);
  $count = mysql_result ($q, 0);
  if (!file_exists ('modules/posts/maxonline.txt'))
  {
    $fw = fopen ('modules/posts/maxonline.txt', 'w');
    fwrite ($fw, $count."\n".(date("d-M-Y H:i")));
    fclose ($fw);
  }
  else
  {
    $fr = file ('modules/posts/maxonline.txt');
    if ((int) $fr[0] < $count)
    {
      $fw = fopen ('modules/posts/maxonline.txt', 'w');
      fwrite ($fw, $count."\n".(date("d-M-Y H:i")));
      fclose ($fw);
    }
  }
  $f .= 'Вы вошли успешно! Сохраните сию страницу в закладки, она пригодна для автоаутентификации ;)<br/>';
  $f .= '&#187;<a class="red" href="game.php?sid='.$sid.'">';
  $f .= 'в игру</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum">форум</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=handler_set">';
  $f .= 'настройки</a><br/>';
  $f .= '&#171;<a class="blue" href="index.php">';
  $f .= 'на главную</a></div>';
  $f .= gen_sfooter();
  echo $f;

  function add_ip ($ip, $ua, $login)
  {
    global $dbcnx;
    $q = mysql_query ("SELECT * FROM ip_list WHERE ip = '".$ip."';", $dbcnx);
    if (mysql_num_rows ($q))
    {
      $il = mysql_fetch_assoc ($q);
      $ilua = explode ('|', $il['user_agent']);
      $illo = explode ('|', $il['logins']);

      $found = 0;
      $c = count ($ilua);
      for ($i = 0; $i < $c; $i++) if ($ilua[$i] == $ua) $found = 1;
      if (!$found)
      {
        $il['user_agent'] .= '|'.$ua;
        mysql_query ("UPDATE ip_list SET user_agent = '".$il['user_agent']."' WHERE id_ip = '".$il['id_ip']."';", $dbcnx);
      }

      $found = 0;
      $c = count ($illo);
      for ($i = 0; $i < $c; $i++) if ($illo[$i] == $login) $found = 1;
      if (!$found)
      {
        $il['logins'] .= '|'.$login;
        mysql_query ("UPDATE ip_list SET logins = '".$il['logins']."' WHERE id_ip = '".$il['id_ip']."';", $dbcnx);
      }
    }
    else
      mysql_query ("INSERT INTO ip_list VALUES (0, '".$ip."', '".$ua."', '".$login."');", $dbcnx);
  }
?>