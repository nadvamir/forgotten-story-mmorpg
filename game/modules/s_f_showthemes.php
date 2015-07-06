<?php
  // temy:
  $id_forum = preg_replace ('/[^0-9]/', '', $_GET['id_forum']);
  if ($id_forum == 8 && $p['admin'] < 1) put_g_error ('you are not wellcome here');
  if ($id_forum == 10 && $p['id_player'] != 1 && $p['id_player'] != 5 && $p['id_player'] != 10) put_g_error ('you are not wellcome here');
  $q = do_mysql ("SELECT name FROM forums WHERE id_forum = '".$id_forum."';");
  $name = mysql_result ($q, 0);
  $f = gen_header ($name);
  $f .= '<div class="y" id="dgvdglhk"><b>'.$name.':</b></div>';
  $f .= '<div class="n" id="ierao">';

  ///////////////////
  // dlja onlajn:
  do_mysql ("INSERT INTO fonline VALUES ('".$LOGIN."', '".$name."', NOW());");

  // kolichestvo nechitanyh ls
  $qrl = "SELECT COUNT(*) FROM ls WHERE sentfor = '".$p['id_player']."' AND readed = 'no';";
  $arl = do_mysql($qrl);
  $ls = mysql_result($arl,0);
  if ($ls > 0)
  {
    $f .= 'нов. сообщений: ';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">'.$ls.'</a><br/>';
  }

  $f .= '<a name="up"><b>темы:</b></a> <a class="blue" href="#nav"><small>конец</small></a></div>';
  if (!isset ($_GET['start'])) $start = 0;
  else $start = preg_replace ('/[^0-9]/', '', $_GET['start']);
  $show = 5;
  if (!$start) $start = 0;
  // qtotth zaprashivaem kolichestvi tem
  $qtotth = do_mysql ("SELECT count(*) FROM themes WHERE id_forum = '".$id_forum."';");
  $totth = mysql_result($qtotth,0);
  if ($start > $totth) $start = $totth - 3;
  if ($start < 0) $start = 0;
  $q4st = "SELECT * FROM themes WHERE id_forum='".$id_forum."' ORDER BY lpost DESC LIMIT ".$start.", ".$show.";";
  $a4st = do_mysql($q4st);
  // poluchjaem vse dannye
  while ($themes = mysql_fetch_assoc($a4st))
  {
    $f .= '<div class="n" id="'.$themes['puttime'].'">';
    if ($p['admin'] > 0 || $themes['author'] == $LOGIN) $f .= '<b><a class="red" style="text-decoration:none"  href="game.php?sid='.$sid.'&action=forum&sub_action=deltheme&id_forum='.$id_forum.'&start='.$start.'&id_theme='.$themes['id_theme'].'">x</a></b>';
    $f .= '<b> - </b><a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showposts&id_theme='.$themes['id_theme'].'&id_forum='.$id_forum.'&start=0&tstart='.$start.'">';
    $f .= $themes['name'];
    $q = do_mysql ("SELECT COUNT(*) FROM posts WHERE id_theme='".$themes['id_theme']."';");
    $c = mysql_result ($q, 0);
    $id = is_player ($themes['author']);
    $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
    $nm = mysql_result ($q, 0);
    $f .= '</a> ('.$c.') '.$nm;
    if ($p['admin'] > 0) $f .= ' <a class="red" href="game.php?sid='.$sid.'&action=forum&sub_action=move_topic1&id_theme='.$themes['id_theme'].'">></a>';
    $f .= '</div>';
    $f .= '<div class="n" id="a'.$themes['puttime'].'">';
    $q = do_mysql ("SELECT * FROM posts WHERE id_theme = '".$themes['id_theme']."' ORDER BY puttime DESC LIMIT 0, 1;");
    $lp = mysql_fetch_assoc ($q);
    $f .= '<small><span class="gray">'.$themes['puttime'].'</span><br/>';
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showposts&id_theme='.$themes['id_theme'].'&id_forum='.$id_forum.'&start=10000&tstart='.$start.'">';
    $id = is_player ($lp['author']);
    $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
    if (!mysql_num_rows ($q)) $nm = '';
    else $nm = mysql_result ($q, 0);
    $f .= $nm.'</a> <span class="gray">'.$lp['puttime'].'</span></small></div>';
  }

  $f .= '<div class="n" id="isao">';
  // teperq md'shnye ssylki dlja prosmotra
  $c = $totth;
  $nw = floor ($c / $show);
  for ($i = 0; $i <= $nw; $i++)
  {
    if ($i * $show == $start) $f .= ($i + 1).' : ';
    elseif ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showthemes&start='.($i * $show).'&id_forum='.$id_forum.'">'.($i + 1).'</a> : ';
  }
  $f .= '<span class="gray">('.$c.')</span>';
  $f .= '<br/>';

  $f .= '<a name="nav"><b>навигация:</b></a> <a class="blue" href="#up"><small>начало</small></a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showthemes&id_forum='.$id_forum.'">обновить</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=create_theme&id_forum='.$id_forum.'">создать тему</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum">форумы</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">друзья</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
  $f .= '</div>';
  $f .= gen_footer();
  exit ($f);
?>