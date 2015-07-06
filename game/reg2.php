<?php
  // fail vybora rassy
  // princyp takoj, podkljuchaetsja chel k baze
  // i esli uspeshno podkljuchilsja
  // to ukazanaja im rassa
  // zanositsja v bazu esli nebylo takovoj
  //--------------
  require_once ('modules/config.php');
  require_once ('modules/f_defend.php');
  defend();
  require_once ('site_header.php');
  require_once ('site_footer.php');
  $login = $_GET['login'];
  $login = preg_replace('/[^a-z0-9_]/i', '', $login);
  $pass = $_GET['pass'];
  $pass = mysql_real_escape_string ($pass);
  $pass_a = $pass;
  $pass = md5($pass);
  // zapros na vernostq:
  $a = mysql_query ("SELECT pass FROM players WHERE login = '".$login."';", $dbcnx);
  if (!mysql_num_rows($a))
  {
    // netu takogo logina
    exit ("<p>1извините, произошла ошибка. Возможно что такой персонаж незарегистрирован или удален</p>");
  }
  $pass2 = mysql_result ($a, 0);
  if ($pass2 != $pass)
  {
    // netu takogo parolja
    exit ('<p>2извините, произошла ошибка. Возможно что такой персонаж незарегистрирован или удален</p>');
  }
  ////////////////
  // proverka na okonchenuju registraciju (rassa)
  $qr = mysql_query ("SELECT rase FROM players WHERE login = '".$login."';", $dbcnx);
  $rase = mysql_result ($qr, 0);
  if ($rase) exit ('<p>вы уже зарегистрированны!<br/>&#187;<a class="blue" href="index.php">на главную</a></p>');
  ////////////////
  if (!isset ($_GET['rase'])) $_GET['rase'] = '';
  $rase = preg_replace('/[^123]/', '', $_GET['rase']);
  if (!$rase)
  {
      $f = gen_sheader ('регистрация 2');
      $f .= '<div class="y" id="ioty">Ваши данные приняты!</div><div class="n" id="wt7xx43t">';
      $f .= 'Ваш логин: '.$login.'<br/>';
      $f .= '<b>Выберите вашу рассу:</b><br/>';
      $f .= '- Из персонажа человека может получится как и хороший воин так и лучник. <b>Боевой магии его нет равных</b>. Это самая многочисленая раса в мире Лаернора, оффициально господствуещая в нем.';
      $f .= '<br/>- Эльфы - лучшие лучники, обитаюшие в дремучих лесах. <b>Незаметность и скорость</b> - это все что нужно для победы в дальнем бою!';
      $f .= '<br/>- Гномы - владыки подземельев. <b>Топор и молот</b> - их главное оружие. А под воздействием Магии иллюзии противник даже незаметит, как отправится в мир иной...</p>';
      $f .= '<div class="y" id="oios">Выберите:</div><p>';
      $f .= '- <a href="reg2.php?login='.$login.'&pass='.$pass_a.'&rase=1">Человек</a><br/>';
      //$f .= '- <a href="reg2.php?login='.$login.'&pass='.$pass_a.'&rase=2">Эльф</a><br/>';
      //$f .= '- <a href="reg2.php?login='.$login.'&pass='.$pass_a.'&rase=3">Гном</a>';
      $f .= 'гномы и эльфы в демо версии игры недоступны</div>';
      $f .= gen_sfooter();
      exit ($f);
  }
  // esli vse horosho to zanesem rassu v mysql bazzu
  $q = mysql_query ("UPDATE players SET rase = '".$rase."' WHERE login = '".$login."' AND pass = '".$pass."';", $dbcnx);
  if (!$q) exit('<p>произошла ошибка при внесении вашей рассы, сообшите об ней администрации</p>');
  // teperq nado napisatq vstupitelqnye slova :(
  $f = gen_sheader ('Регистрация 3');
  $loc = 'novi|2x1';
  $f .= '<div class="y" id="hjkh">ПРОЛОГ:<br/>';
  $f .= '<b>По разбитой дороге</b></div>';
  //---
  $f .= '<div class="n" id="wt743t">- Путь был долгим, казалось безконечным. Ноги устали, ноги болят. Огонь сжег все. Голые ступни до крови избились о расчепленые камни дороги. "Почему все еще больно?". "Где конец?"</div>';
  $q = mysql_query ("UPDATE players SET location = '".$loc."' WHERE login = '".$login."' AND pass = '".$pass."';", $dbcnx);
  $f .= '<div class="y" id="khlh"> ... </div>';
  $f .= '<div class="n" id="wssat743t">&#187;Чтобы прочитать надпись на камне, нажмите на его. Чтобы говорить с нпц, нажмите на имя. Чтобы поднять вешь, нажмите на название. Удачи!<br/>';
  $f .= '&#187;<a class="blue" href="log.php?login='.$login.'&pass='.$pass_a.'">в игру</a></div>';
  $f .= gen_sfooter();
  exit ($f);
?>