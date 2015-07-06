<?php
  // testovyj varijant zashity ot sinhrona
  function defend ()
  {
    global $dbcnx;
    mysql_query ("DELETE FROM customers WHERE puttime < NOW() - INTERVAL '1' SECOND", $dbcnx);
    $ip = getenv('HTTP_X_FORWARDED_FOR');
    if (!$ip) $ip = $_SERVER['REMOTE_ADDR'];
    $user = mysql_query ("SELECT puttime FROM customers WHERE user_ip = '".$ip."';");
    $user = mysql_fetch_assoc ($user);
    if ($user['puttime']) exit ('<p>в целях защиты запрещено обновлятся чаще 1 сек<br/><a href="index.php">на главную</a></p>');
    mysql_query ("INSERT INTO customers VALUES ('".$ip."', '".$_SERVER['HTTP_USER_AGENT']."', NOW());", $dbcnx);
  }  
/*
strahovoj variant
    global $dbcnx;
    mysql_query ("DELETE FROM customers WHERE puttime < NOW() - INTERVAL '3' SECOND", $dbcnx);
    $user = mysql_query ("SELECT puttime FROM customers WHERE user_agent = '".$_SERVER['HTTP_USER_AGENT']."'AND user_ip = '".$_SERVER['REMOTE_ADDR']."';");
    $user = mysql_fetch_assoc ($user);
    if ($user['puttime']) exit ('<p>в целях защиты запрещено обновлятся чаще 3 сек<br/><a href="index.php">на главную</a></p>');
    mysql_query ("INSERT INTO customers VALUES ('".$_SERVER['REMOTE_ADDR']."', '".$_SERVER['HTTP_USER_AGENT']."', NOW());", $dbcnx);
*/
?>