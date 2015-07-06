<?php
  // dobavka lichnogo soobshenija
  // $to dan kak igroka uzhe:)
  // fail dlja obrabotki dannyh ls
  //$msg = mysql_real_escape_string(htmlspecialchars(trim($_GET['msg'])));
  // zachem proverjatq? proverka v add_journal
  $msg = trim($_GET['msg']);
  if (!$msg) put_g_error ('зачем нужно слать пустое сообщение?!..');
  // smotrim estq li $to
  if (!$_GET['to']) $to_all = 1;
  else $to = preg_replace ('/[^a-z0-9_]/i', '', $_GET['to']);
  // esli byl ustanovlen translit, to translitiruem
  if (isset($_GET['t']) && $_GET['t'])
  {
    include_once ('modules/f_translit.php');
    $msg = translit ($msg);
  }
  // zapisq v ls
  $id = is_player ($to);
  $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
  if (!mysql_num_rows ($q)) $toname = '';
  else $toname = mysql_result ($q, 0);
  if (isset ($_GET['shep']) && $_GET['shep'] == 1) add_journal ('[orange][wisper]'.$p['name'].' щепчет: '.$toname.', '.$msg.'[/end]', $LOGIN.'|'.$to);
  else if ($_GET['shep'] == 0 || $_GET['shep'] == 3) add_journal (''.$p['name'].' говорит '.$toname.': '.$msg.'', 'l.'.$p['location']);
  else if ($_GET['shep'] == 2)
  {
    // vsemu klanu:
    if ($p['clan'][0])
    {
      $q = do_mysql ("SELECT login FROM players WHERE clan LIKE '".$p['clan'][0]."%';");
      $to = '';
      while ($tmp = mysql_fetch_assoc ($q)) $to .= $tmp['login'].'|';
      add_journal ('[green][clan]'.$p['name'].' говорит '.$toname.': '.$msg.'[/end]', $to);
    }
  }
  $action = '';
  $NO_CONTINUE = 1;
  $NOACT = 1;
?>