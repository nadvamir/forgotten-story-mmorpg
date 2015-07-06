<?php
  // dobavlenie foruma:
  //if ($p['stats'][0] < 2 && $p['admin'] < 1) put_g_error ('вам еше нелзя писать на форуме. писать можно начиная с 2 уровня.');
  $id_forum = preg_replace ('/[^0-9]/', '', $_GET['id_forum']);
  $id_theme = preg_replace ('/[^0-9]/', '', $_GET['id_theme']);
  $to = preg_replace ('/[^a-z0-9_]/i', '', $_GET['to']);
  include 'smile/s_smile.php';
  if (!isset ($_GET['msg'])) $_GET['msg'] = '';
  $msg = htmlspecialchars(trim($_GET['msg']));
  $msg = mysql_real_escape_string($msg);
  $msg = str_replace('\n', '<br/>', $msg);
  $msg = str_replace('\r', '', $msg);
  if (!$msg) put_g_error ('зачем слать пустое сообщение?');
  // BBCode
  $msg = str_replace("[u]", "<u>", $msg);
  $msg = str_replace("[/u]", "</u>", $msg);
  $msg = str_replace("[i]", "<i>", $msg);
  $msg = str_replace("[/i]", "</i>", $msg);
  $msg = str_replace("[b]", "<b>", $msg);
  $msg = str_replace("[/b]", "</b>", $msg);
  $msg = str_replace("[br/]", "<br/>", $msg);
  $msg = eregi_replace("(.*)\\[url\\](.*)\\[/url\\](.*)", "\\1<a href=\\2>\\2</a>\\3", $msg);
  //----------------------------------
  // do translita perevodim smaily v cyfry
  //-------------------------------
  $count = count($sa);
  for ($i = 0; $i < $count; $i++)
  {
    $msg = str_replace($sa[$i], $sc[$i], $msg);
  }
  if (!isset ($_GET['t'])) $t = 0;
  else $t = preg_replace ('/[^0-1]/', '', $_GET['t']);
  if ($t)
  {
    include_once ('modules/f_translit.php');
    $msg = translit ($msg);
  }
  /////
  $count = count($sa);
  for ($i = 0; $i < $count; $i++)
  {
    $msg = str_replace($sc[$i], $sb[$i], $msg);
  }
  /////
  if ($to != 'all')
  {
    $id = is_player ($to);
    $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
    $name = mysql_result ($q, 0);
    $msg = $name.', '.$msg;
  }
  $q = do_mysql ("SELECT COUNT(*) FROM themes WHERE id_theme = '".$id_theme."';");
  if (!mysql_num_rows($q)) put_error ('нету такой темы ');
  do_mysql ("INSERT INTO posts VALUES (0, '".$id_theme."', NOW(), '".$LOGIN."');");
  do_mysql ("UPDATE themes SET lpost = '".(time())."' WHERE id_theme = '".$id_theme."';");
  $q = do_mysql ("SELECT id_post FROM posts WHERE author = '".$LOGIN."' ORDER BY puttime DESC LIMIT 0, 1;");
  $id_post = mysql_result ($q, 0);
  $fp = fopen ('modules/posts/post_'.$id_post.'.txt', 'w');
  fwrite ($fp, $msg);
  fclose ($fp);
  $_GET['sub_action'] = 'showposts';
  $_GET['start'] = 1000000;
?>