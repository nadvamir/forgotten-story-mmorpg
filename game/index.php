<?php
  // index file
  require_once ('modules/config.php');
  require_once ('modules/f_defend.php');
  defend();
  require_once ('site_header.php');
  require_once ('site_footer.php');
  $f = gen_sheader ('Забытая История');
  $f .= '<div class="y" id="fdfdg"><b>';
  $f .= 'Добро пожаловать!</b></div>';
  $f .= '<div class="n" id="rtad">';
  $f .= '<img src="smile/dwarf.gif" alt="zi"/>';
  $f .= '<b>Забытая История</b><br/>';
  $f .= '<small>текстовый экшен</small><br/>';
  $f .= '<small>v: 0.1.2demo [e.v. 0.9.1]<br/>';
  // zapros onlain
  $a = mysql_query ("SELECT COUNT(*) FROM session;", $dbcnx);
  $count = mysql_result ($a, 0);
  $f .= 'онлайн: <a class="blue" href="online.php">'.$count.'</a> человек<br/>';
  if (file_exists ('modules/posts/maxonline.txt'))
  {
    $fr = file ('modules/posts/maxonline.txt');
    $f .= 'max '.$fr[0].' ['.$fr[1].']<br/>';
  }
  $q = mysql_query ("SELECT puttime FROM news ORDER BY puttime DESC;", $dbcnx);
  if (mysql_num_rows ($q))
  {
    $pt = mysql_result ($q, 0);
    //$pt = substr ($pt, 0, 10);
    $f .= 'новости от <a class="black" href="news.php">'.$pt.'</a>';
  }
  $f .= '</small><br/>';


  $f .= '<small><img src="smile/plus/opera.PNG" alt="mo"/>рекомендуемый браузер - <a class="blue" href="http://mini.opera.com/">Opera Mini</a></small><br/>';

  $f .= '</div><div class="y" id="login"><b>Вход</b></div>';
  $f .= '<div class="n" id="rdtad">';
  // forma
  $f .= '<form action="log.php" method="get">';
  $f .= 'Логин:';
  $f .= '<br/><input type="text" name="login" value=""/>';
  $f .= '<br/>Пароль:';
  $f .= '<br/><input type="password" name="pass"/>';
  $f .= '<br/><input type="submit" value="Вход"/></form>';
  // konec formy
  // zabyl parolq:
  $f .= '&#187;<a class="blue" href="forgotten.php">забыли пароль?</a></div>';
  // nachalo meniu
  $f .= '<div class="y" id="idfua"><b>Mеню:</b></div><div class="n" id="rt1ad">';
  $f .= '&#187;<a class="blue" href="reg.php">';
  $f .= 'регистрация</a><br/>';
  $f .= '&#187;<a class="blue" href="statistic.php">';
  $f .= 'статистика</a><br/>';
  $f .= '&#187;<a class="blue" href="info.php">';
  $f .= 'информация</a><br/>';
  $f .= '&#187;<a class="blue" href="authors.php">';
  $f .= 'авторы</a></div>';
  if (file_exists ('friends.txt'))
  {
    $f .= '<div class="y" id="iyurwy"><b>друзья:</b></div><div class="n" id="rtad777">';
    $fr = file ('friends.txt');
    for ($i = 0; $i < 5; $i++)
    {
      $n = array_rand ($fr);
      $f .= '<a class="blue" href="'.$fr[$n].'">'.$fr[$n].'</a><br/>';
      unset ($fr[$n]);
      if (!count ($fr)) break;
    }
    $f .= '</div>';
  }
  $f .= '<div class="n">'."<a href=\"http://vigre.su/vote?game_id=174\" id=\"vigre.su.banner\"><img style=\"border:0px\" alt=\"vigre.su\" src=\"http://vigre.su/banner.php?game_id=174&http_referer=".urlencode(@$_SERVER['HTTP_REFERER'])."\"/></a>".'</div>';

  $f .= gen_sfooter();
  echo $f;
?>