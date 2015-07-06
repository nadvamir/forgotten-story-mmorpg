<?php
  // ssylka izmenitq na loc mode i nadpisq chto eto chat
  // esli estq poslannoe dobavim:
  // qtotth zaprashivaem kolichestvi postov
  if (!$p['clan'][0]) $clan = 'not';
  else $clan = $p['clan'][0];
  if (isset ($_GET['subaction']) && $_GET['subaction'] == 'delete')
  {
    $what = preg_replace ('/[^0-9]/', '', $_GET['what']);
    $q = do_mysql ("SELECT id_chat FROM chat WHERE msgto = '".$LOGIN."' OR msgfrom = '".$LOGIN."';");
    if (mysql_num_rows ($q) || $p['admin'] > 0)
    {
      do_mysql ("DELETE FROM chat WHERE id_chat = '".$what."';");
    }
  }
  if (isset ($_GET['msg']))
  {
    $msg = htmlspecialchars(mysql_real_escape_string(addslashes(trim($_GET['msg']))));
    if (!$msg) put_g_error ('зачем нужно слать пустое сообщение?!..');
    // esli byl ustanovlen translit, to translitiruem
    if (isset($_GET['t']) && $_GET['t'])
    {
      include_once ('modules/f_translit.php');
      $msg = translit ($msg);
    }
    // smotrim estq li $to
    $to = preg_replace ('/[^0-9a-z_]/', '', $_GET['to']);
    if ($_GET['shep'] == 2)
    {
      $to = $p['clan'][0];
      $msg = '<span style="color:#129812">[clan]</span>'.$msg;
    }
    else if ($to && $_GET['shep'] == 1)
    {
      $msg = '<span style="color:#981212">[PM]</span>'.$msg;
    }

    // zapisq v ls
    // esli postov 21 - udalim pervyj:
    $qtotth = do_mysql ("SELECT count(*) FROM chat WHERE map = '".(substr ($p['location'], 0, 4))."' ;");
    $totth = mysql_result($qtotth,0);
    if ($totth > 20)
    {
      $q = do_mysql ("SELECT id_chat FROM chat WHERE map = '".(substr ($p['location'], 0, 4))."' ORDER BY puttime LIMIT 0, 1;");
      $chatd = mysql_result ($q, 0);
      do_mysql ("DELETE FROM chat WHERE id_chat = '".$chatd."';");
    }
    $qtotth = do_mysql ("SELECT count(*) FROM chat WHERE msgto = '".$LOGIN."' OR msgto = '".$clan."' OR msgfrom = '".$LOGIN."' ;");
    $totth = mysql_result($qtotth,0);
    if ($totth > 9)
    {
      $q = do_mysql ("SELECT id_chat FROM chat WHERE msgto = '".$LOGIN."' OR msgto = '".$clan."' OR msgfrom = '".$LOGIN."' ORDER BY puttime LIMIT 0, 1;");
      $chatd = mysql_result ($q, 0);
      do_mysql ("DELETE FROM chat WHERE id_chat = '".$chatd."';");
    }
    $map = (substr ($p['location'], 0, 4));
    if ($to) $map = '';
    if ($_GET['shep'] == 0) $map = (substr ($p['location'], 0, 4));
    do_mysql ("INSERT INTO chat VALUES (0, '".$msg."', NOW(), '".$to."', '".$map."', '".$LOGIN."');"); 
  }

  $qtotth = do_mysql ("SELECT count(*) FROM chat WHERE msgto = '".$LOGIN."' OR msgto = '".$clan."' OR msgfrom = '".$LOGIN."' OR map <> '' ;");
  $totth = mysql_result($qtotth,0);

  if (!isset ($_GET['start'])) $start = 0;
  else $start = preg_replace ('/[^-0-9]/', '', $_GET['start']);
  $show = 7;
  if ($start === false) $start = 0;
  if ($start > $totth)
  {
    $start = floor ($totth / $show);
    $start *= $show;
    if ($start == $totth) $start -= $show;
  }
  if ($start < 0) $start = 0;
  $c = $totth;
  // pokaz soobshenij
  $f = '';
  if ($p['last'][7] > 1000000000) $p['last'][7] = 0;
  $q = do_mysql ("SELECT * FROM chat WHERE msgto = '".$LOGIN."' OR msgto = '".$clan."' OR msgfrom = '".$LOGIN."' OR map <> '' ORDER BY puttime DESC LIMIT ".$start.", ".$show.";");
  while ($ch = mysql_fetch_assoc ($q))
  {
    if ($p['last'][7] < $ch['id_chat'])
    {
      $p['last'][7] = $ch['id_chat'];
      $last = implode ('|', $p['last']);
      do_mysql ("UPDATE players SET last = '".$last."' WHERE id_player = '".$p['id_player']."';");
    }
    $id = is_player ($ch['msgfrom']);
    $q2 = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
    if (!mysql_num_rows ($q2)) $name = '';
    else $name = mysql_result ($q2, 0);
    $f .= '<div class="n" id="affie'.$ch['id_chat'].'">';
    if ($ch['msgto'] == $LOGIN || $ch['msgfrom'] == $LOGIN || $p['admin'] > 0) $f .= '<a class="red" href="game.php?sid='.$sid.'&action=chat&what='.$ch['id_chat'].'&subaction=delete&start='.$start.'">x</a> ';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=chat&to='.$ch['msgfrom'].'&start='.$start.'">'.$name.'</a>';
    $id = is_player ($ch['msgto']);
    $q4n = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
    if (!mysql_num_rows ($q4n)) $to = '';
    else $to = mysql_result ($q4n, 0);
    $f .= ' &#187; '.$to.'<br/>';
    $f .= $ch['puttime'].'<br/>';
    $f .= '- '.$ch['text'].'</div>';
  }
  $f .= '<div class="n" id="nav">';
  $nw = floor ($c / $show);
  for ($i = 0; $i <= $nw; $i++)
  {
    if ($i * $show == $start) $f .= ($i + 1).' : ';
    elseif ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=chat&start='.($i * $show).'">'.($i + 1).'</a> : ';
  }
  $f .= '</div>';

  $f .= '<div class="n" id="afie">сообщение: ';
  $f .= '<form action="game.php" method="get">';
  $f .= '<textarea name="msg" rows="2"></textarea>';
  $f .= '<input type="hidden" name="action" value="chat"/>';
  //$f .= '<input type="hidden" name="start" value="'.$start.'"/>';
  $f .= '<input type="hidden" name="subaction" value="reply"/>';
  $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
  if (!isset ($_GET['to'])) $_GET['to'] = '';
  $f .= '<br/>для: (ник или пусто(всем))<br/><input type="text" name="to" value="'.$_GET['to'].'"/>';
  // translit
  $f .= '<br/><input type="radio" name="t" value="1"/>транслит<br/>';
  $f .= '<input type="radio" name="t" value="0"/>как есть<br/>';
  $f .= '<select size="1" name="shep">';
  $f .= '<option value="0">говорить</option>';
  $f .= '<option value="1">лично</option>';
  $f .= '<option value="2">вему клану</option>';
  $f .= '<option value="3">партии</option>';
  $f .= '</select><br/>';
  $f .= '<input type="submit" value="написать"/></form>';
  // te kto v loke
  $a = do_mysql ("SELECT login, name FROM players WHERE location LIKE '".(substr ($p['location'], 0, 4))."%' AND login != '".$LOGIN."' AND active = '1' AND hidden = '0';");
  while ($pl = mysql_fetch_assoc ($a))
  {
    // login -- ssylka napisatq emu soobshenie
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=chat&to='.$pl['login'].'&start='.$start.'">';
    $f .= $pl['name'].'</a> | ';
  }
  $f .= '<br/>&#187;<a class="blue" href="game.php?sid='.$sid.'&action=chat&start='.$start.'" accesskey="5">обновить</a></div>';
  exit_msg ('чат', $f);
?>