<?php
  // onlain
  require_once ('modules/config.php');
  require_once ('modules/f_defend.php');
  defend();
  require_once ('site_header.php');
  require_once ('site_footer.php');
  $f = gen_sheader ('Забытая История');

  $f .= '<div class="y" id="fdfdg">';
  $f .= 'забыли пароль?';
  $f .= '</div>';
  if (isset ($_GET['login']))
  {
    // otsylaem na mylo parolq
    $login = mysql_real_escape_string ($_GET['login']);
    $q = mysql_query ("SELECT email FROM players WHERE login = '".$login."';", $dbcnx);
    if (!mysql_num_rows ($q)) exit ('незнаю я такого...');
    $email = mysql_result ($q, 0);
    if ($email != $_GET['email']) exit ('email ne sovpadaet');

    function randomPassword($length)
    {
      $pass = md5(microtime());
      $pass = substr($pass, 0, $length);
      return $pass;
    }
    $pass_a = randomPassword (6);
    $pass = md5 ( $pass_a);
    mysql_query ("UPDATE players SET pass = '".$pass."' WHERE login = '".$login."';", $dbcnx);
    
    $header = 'Content-Type: text/html; charset=utf-8\n';
    $header .= ' Content-Transfer-Encoding: quoted-printable\n';
    $msg = "Nedolgo dumaja ja pridumal dlja tebja podhodjashij parolq - vo: ".$pass_a." =) ne zabyvaj ego! http://zio.v1p.su";

    mail ($email, 'zi-online reminder', $msg, $header);

    $f .= '<div class="n" id="wt743t">Так уж и быть, послал я новый пароль на елктронную почту. Проверь ящик =)</div>';
  }
  else
  {
    $f .= '<div class="n" id="wt743t">';
    $f .= 'логин:<br/><form action="forgotten.php" method="get">';
    $f .= '<input type="text" name="login"/><br/>email:';
    $f .= '<input type="text" name="email"/>';
    $f .= '<input type="submit" value="пришли новый плз..."/></form>';
    $f .= '</div>';
  }
  $f .= '<div class="n" id="wts743t"><a class="blue" href="index.php">на главную</a></div>';
  $f .= gen_sfooter();
  exit ($f);
?>