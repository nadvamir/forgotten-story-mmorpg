<?php
  // dobavka lichnogo soobshenija
  // $to dan kak igroka uzhe:)
  // fail dlja obrabotki dannyh ls
  if (!isset ($_GET['msg']))
    $_GET['msg'] = '';
  $msg = mysql_real_escape_string(htmlspecialchars(trim($_GET['msg'])));
  if (!$msg) put_g_error ('зачем нужно слать пустое сообщение?!..');
  // smotrim estq li $to
  if (!$_GET['to']) put_error ('для добавления лс нужен адресат!');
  else $to = preg_replace ('/[^0-9]/', '', $_GET['to']);
  // esli byl ustanovlen translit, to translitiruem
  if (isset($_GET['t']) && $_GET['t'])
  {
    include_once ('modules/f_translit.php');
    $msg = translit ($msg);
  }
  // zapisq v ls
  $addls = "INSERT INTO ls VALUES (0, '".$p['id_player']."', '".$to."', NOW(), 'no');";
  if (mysql_query($addls, $dbcnx))
  {
    $q = do_mysql ("SELECT id_ls FROM ls WHERE sender = '".$p['id_player']."' AND sentfor = '".$to."' ORDER BY senttime DESC;");
    $id_ls = mysql_result ($q, 0);
    $fp = fopen ('modules/ls/ls_'.$id_ls.'.txt', 'w');
    fwrite ($fp, $msg);
    fclose ($fp);
    $action = 'showcontacts';
    if (isset ($_GET['p'])) $action = 'perepiska';
    $ADDED_MSG = 1;
  }
  else
  {
    put_error ('невышло отправить лс');
  }
?>