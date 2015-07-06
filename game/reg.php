<?php
  // fail registracii
  require_once ('modules/config.php');
  require_once ('modules/f_defend.php');
  defend();
  require_once ('site_header.php');
  require_once ('site_footer.php');
  if (isset($_POST['sent']))
  {
    $login = mysql_real_escape_string($_POST['login']);
    $login = preg_replace('/[^a-z0-9_]/i', '', $login);
    $login = strtolower ($login);
    if ($login == 'all') exit ('<p>этот логин уже занят</p>');
    $name = preg_replace('/[^a-z0-9_]/i', '', $_POST['name']);
    if ($login != strtolower ($name)) exit ('<p>логин должен совпадать с именем, различатся могут регистры</p>');
    $pass = mysql_real_escape_string($_POST['pass']);
    $pass = preg_replace('/[^a-z0-9]/i', '', $pass);
    $email = mysql_real_escape_string($_POST['email']);
    $gender = mysql_real_escape_string ( preg_replace ('/[^malef]/', '', $_POST['gender']));
    $age = mysql_real_escape_string(substr(preg_replace('/[^0-9]/', '', $_POST['age']), 0, 2));
    // esli $pass i $_POST['pass2'] ne sovpadajut, soobshim ob oshibke
    if ($pass != $_POST['pass2'])
    {
      # serqeznyj sluchjaj. libo ostroe proevlenie skleroza, libo kody gad pisal...
      exit ('<p>пароли не совпадают.</p>');
    }
    if (!$login || !$pass || !$email || !$gender || !$age)
    {
      // nezapolneny vse polja. dopustimo no tupo
      exit ('<p>заполните все поля!</p>');
    }
    if (strlen($login) < 3 || strlen($name) < 3 || strlen ($pass) < 6)
    {
      exit ('<p>Введенные данные слишком короткие</p>');
    }
    if (strlen ($login) > 12 || strlen ($name) > 12)
    {
      $login = substr ($login, 12);
    }
    if (strlen ($pass) > 30)
    {
      $pass = substr ($pass, 30);
    }
    // esli email ne prohodit proverki, to eto naverno plohoj email...
    if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,4}/i", $email))
    {
      //nekorektno vveden email
      exit ('<p>некорректно введено ваше мыло!</p>');
    }
    // teperq proverim, net li takogo logina ili maila
    $q = mysql_query ("SELECT id_player FROM players WHERE login = '".$login."' OR email = '".$email."' OR name = '".$name."';", $dbcnx);
    if (mysql_num_rows($q))
    {
      // takie estq
      exit ('<p>логин или емайл или имя уже заняты</p>');
    }
    # esli vse harasho, shifranem parolq
    $pass3 = $pass;
    $pass = md5 ($pass);
    // registriruem
    $time = time();

    // kod aktivacii:
function randomPassword($length){

  $pass = md5(microtime());
  $pass = substr($pass, 0, $length);
  return $pass;
} 
    $actcode = randomPassword (6);
    // shlem ego na email
    $header = 'Content-Type: text/html; charset=utf-8\n';
    $header .= ' Content-Transfer-Encoding: quoted-printable\n';
    $msg = "Здравствуйте! Вы толькочто успешно зарегистрировались в онлайн игре Забытая История!\n Для окончания регистрации зайдите в игру и введите там код: ".$actcode." . Приятной игры!";
    $msg .= "<br/><br/>Zdravstvujte! Vy tolqkochto uspeshno zaregistrirovalisq v onlajn igre Zabytaja Istorija! Dlja okonchanija registracii zajdite v igru i vvedite tam kod: ".$actcode." . Prijatnoj igry!";

    $a = mysql_query ("INSERT INTO players VALUES (0, '".$login."', '".$pass."', '".$email."', '".$gender."', '".$age."', '0', '100', '1|0|1600|1|0|178|1|1', '2|2|1|1|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0', '0', '0', '100|100', '100|100', '15', 'location|location', '".$time."|".$time."|".$time."|".$time."|".$time."|".$time."|".$time."|".$time."|".$time."', '', '01000', '0', '0', '0', '11111100111111111111', '<p>для того, чтоб говорить, нажмите на ник игрока/нпц</p>', '', '', '000000000000000000000000000000000000000000000000000000000', '', '', '', '', '', '".$time."', '0', '0', '0', '0', '".$actcode."', '".$name."', '|||||||||', '0', '0', '000000000000000000000000000000000000000000000000000000000000000000000', NOW(), '0', '0', '0', '0', '0');", $dbcnx);

    if ($a)
    {
      $q = mysql_query ("SELECT id_player FROM players WHERE login = '".$login."';", $dbcnx);
      $id = mysql_result ($q, 0);
      mysql_query ("INSERT INTO anketa VALUES (0, '".$id."', '', '', '', '', '');", $dbcnx);
      // otpravljaem:
      //mail ($email, 'zi-online registration', $msg, $header);
      // vse horosho. poprivetstvuem i otpravim dalqshe
      $f = gen_sheader ('регистрация 2');
      $f .= '<div class="y" id="ioty">Ваши данные приняты!</div><div class="n" id="wt743t">';
      $f .= 'Ваш логин: '.$login.'<br/>';
      $f .= 'Hа ваш емайл выслан код активации.<br/>';
      $f .= '<b>Выберите вашу рассу:</b><br/>';
      $f .= '- Из персонажа человека может получится как и хороший воин так и лучник. <b>Боевой магии его нет равных</b>. Это самая многочисленая раса в мире Лаернора, оффициально господствуещая в нем.';
      $f .= '<br/>- Эльфы - лучшие лучники, обитаюшие в дремучих лесах. <b>Незаметность и скорость</b> - это все что нужно для победы в дальнем бою!';
      $f .= '<br/>- Гномы - владыки подземельев. <b>Топор и молот</b> - их главное оружие. А под воздействием Магии иллюзии противник даже незаметит, как отправится в мир иной...</p>';
      $f .= '<div class="y" id="oios">Выберите:</div><p>';
      $f .= '- <a href="reg2.php?login='.$login.'&pass='.$pass3.'&rase=1">Человек</a><br/>';
      //$f .= '- <a href="reg2.php?login='.$login.'&pass='.$pass3.'&rase=2">Эльф</a><br/>';
      //$f .= '- <a href="reg2.php?login='.$login.'&pass='.$pass3.'&rase=3">Гном</a>';
      $f .= 'гномы и эльфы в бета версии игры недоступны</div>';
      $f .= gen_sfooter();
      exit ($f);
    }
    else
    {
      // nevyshlo vnesti dannye
      exit ('<p>при записи ваших данных произошла ошибка! Повторите еше один раз...</p>');
    }
  }
  else
  {
    // nam tolko predstoit zaregistrirovatsja
    // podoidut polja staryh igr
    $f = gen_sheader ('Регистрация 1');
    $f .= '<div class="y" id="oioasd">Забытая История</div>';
    $f .= '<div class="n" id="wt743t">';
    $f .= "<form action=\"reg.php\" method=\"post\">";
    $f .= "Логин (3-12симв., нижним регистром): <br/><input type=\"text\" name=\"login\" maxlength=\"12\"/><br/>";
    $f .= "Имя (будет видно в игре, 3-12cuм): <br/><input type=\"text\" name=\"name\" maxlength=\"12\"/><br/>";
    $f .= "Пароль (мин 6 симв.): <br/><input type=\"password\" name=\"pass\"/><br/>";
    $f .= 'Повторите пароль: <br/><input type="password" name="pass2"/><br/>';
    $f .= "e-майл: <br/><input type=\"text\" name=\"email\"/><br/>";
    $f .= "пол: <br/><input type=\"radio\" name=\"gender\" value=\"male\"/>&#1084;&#1091;&#1078;&#1089;&#1082;&#1086;&#1081;<br/>";
    $f .= "<input type=\"radio\" name=\"gender\" value=\"female\"/>женский<br/>";
    $f .= "возраст: <br/><input type=\"text\" name=\"age\" format=\"*N\"/><br/>";
    // $_POST['sent']
    $f .= "<input type=\"hidden\" name=\"sent\" value=\"1\"/>";
    // submit
    $f .= "<input type=\"submit\" value=\"регистрация\"/></form></div>";
    $f .= '<div class="y" id="uitiu">Меню:</div>';
    $f .= '<div class="n" id="wt7dd43t">&#187;<a class="blue" href="index.php">на главную</a></div>';
    $f .= gen_sfooter();
    exit($f);
  }
?>
