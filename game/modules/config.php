<?php
  //imja servera
  $dblocation = "localhost";
  //imja bazy dannyh
  $dbname = "waprpg_game";
  //imja polqzovatelja
  $dbuser = "root";
  //ego parolq
  $dbpassw = "";
  
  //soedinenie
  $dbcnx = mysql_connect($dblocation,$dbuser,$dbpassw);
  //esli soedinenie neudachno
  if (!$dbcnx)
  {
    exit ("<P>Could not connect to mysql... ".(mysql_error ())."</P>");
  }
  //vyberem bazu dannyh
  //esli ne vyshlo
  if (! @mysql_select_db($dbname, $dbcnx))
  {
    exit ("<P>&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1087;&#1088;&#1080; &#1089;&#1086;&#1077;&#1076;&#1080;&#1085;&#1077;&#1085;&#1080;&#1080; &#1089; &#1073;&#1072;&#1079;&#1086;&#1081; &#1076;&#1072;&#1085;&#1085;&#1099;&#1093;.</P>");
  }
  else
  {
  }
?>