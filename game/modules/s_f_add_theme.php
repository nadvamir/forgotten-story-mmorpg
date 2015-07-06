<?php
  // dobavlenie foruma:
  //if ($p['stats'][0] < 2 && $p['admin'] < 1) put_g_error ('вам еше нелзя писать на форуме. писать можно начиная с 2 уровня.');
  $id_forum = preg_replace ('/[^0-9]/', '', $_GET['id_forum']);
  $t = 0;
  if (isset ($_GET['t']))
    $t = preg_replace ('/[^0-1]/', '', $_GET['t']);
  $name = mysql_real_escape_string ( strip_tags ( addslashes ( trim ( $_GET['name'] ))));
  if (!$name) put_g_error ('а название где?');
  if ($t)
  {
    include_once ('modules/f_translit.php');
    $name = translit ($name);
  }
  $q = do_mysql ("SELECT COUNT(*) FROM forums WHERE id_forum = '".$id_forum."';");
  if (!mysql_num_rows($q)) put_error ('нету такого форума');
  $q = do_mysql ("SELECT id_forum FROM themes WHERE name = '".$name."';");
  if (mysql_num_rows ($q)) put_g_error ('тема с таким названием существует!');
  do_mysql ("INSERT INTO themes VALUES (0, '".$name."', '".$id_forum."', NOW(), '".$LOGIN."', '".(time())."');");
  $_GET['sub_action'] = 'showthemes';
?>