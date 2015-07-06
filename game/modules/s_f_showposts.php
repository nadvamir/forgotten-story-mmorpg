<?php
  // posty:
  $id_theme = preg_replace ('/[^0-9]/', '', $_GET['id_theme']);
  $q = do_mysql ("SELECT name FROM themes WHERE id_theme = '".$id_theme."';");
  $name = mysql_result ($q, 0);
  $f = gen_header ($name);
  $q = do_mysql ("SELECT id_forum FROM themes WHERE id_theme = '".$id_theme."';");
  $id_forum = mysql_result ($q, 0);
  if ($id_forum == 8 && $p['admin'] < 1) put_g_error ('you are not wellcome here');
  if ($id_forum == 10 && $p['id_player'] != 1 && $p['id_player'] != 5 && $p['id_player'] != 10) put_g_error ('you are not wellcome here');

  ///////////////////
  // dlja onlajn:
  do_mysql ("INSERT INTO fonline VALUES ('".$LOGIN."', '".$name."', NOW());");

  if (!isset ($_GET['start'])) $start = 0;
  else $start = preg_replace ('/[^-0-9]/', '', $_GET['start']);
  if (!isset ($_GET['tstart'])) $_GET['tstart'] = 0;
  $show = 5;
  if (!$start) $start = 0;
  // qtotth zaprashivaem kolichestvi postov
  $qtotth = do_mysql ("SELECT count(*) FROM posts WHERE id_theme = '".$id_theme."';");
  $totth = mysql_result($qtotth,0);
  if ($start > $totth)
  {
    $start = floor ($totth / $show);
    $start *= $show;
    if ($start == $totth) $start -= $show;
  }

  if ($start < 0) $start = 0;

  $goto = $start + $show;
  if ($goto > $totth) $goto = $totth;

  $f .= '<div class="y" id="dgvdglhk"><b>'.$name.': ('.$start.'-'.$goto.'/'.$totth.')</b>';
  $f .= '</div><div class="n" id="asre">';

  // kolichestvo nechitanyh ls
  $qrl = "SELECT COUNT(*) FROM ls WHERE sentfor = '".$p['id_player']."' AND readed = 'no';";
  $arl = do_mysql($qrl);
  $ls = mysql_result($arl,0);
  if ($ls > 0)
  {
    $f .= 'нов. сообщений: ';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">'.$ls.'</a><br/>';
  }

  $f .= '<a name="up"><b>посты:</b></a> <a class="blue" href="#nav"><small>конец</small></a></div>';

  $qpost = "SELECT * FROM posts WHERE id_theme='".$id_theme."' ORDER BY puttime LIMIT ".$start.", ".$show.";";
  $apost = do_mysql($qpost);
  // poluchjaem vse dannye
  while ($post = mysql_fetch_assoc($apost))
  {
    $f .= '<div class="n" id="s'.$post['puttime'].'">';
    if ($p['admin'] > 0 || $post['author'] == $LOGIN) $f .= '<b><a class="red" style="text-decoration:none"  href="game.php?sid='.$sid.'&action=forum&sub_action=delpost&id_post='.$post['id_post'].'&id_forum='.$id_forum.'&start='.$start.'&id_theme='.$id_theme.'">x</a></b> - ';
    $id = is_player ($post['author']);

    $a = '';

    $q = do_mysql ("SELECT letter FROM anketa WHERE id_player = '".$id."';");
    $letter = mysql_result ($q, 0);
    if ($letter) $a .= '<b>'.$letter.'</b> ';

    $q = do_mysql ("SELECT admin FROM players WHERE id_player = '".$id."';");
    $adm = mysql_result ($q, 0);
    if ($adm == '2') $a .= '<b>@</b>';
    elseif ($adm == 1) $a .= '<b>m</b>';
    $f .= $a.'<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=reply&id_theme='.$post['id_theme'].'&id_forum='.$id_forum.'&to='.$post['author'].'">';
    $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
    $paname = mysql_result ($q, 0);
    $f .= $paname;
    $f .= '</a> - <a class="blue" href="game.php?sid='.$sid.'&action=addcontacts&id_theme='.$post['id_theme'].'&id_forum='.$id_forum.'&to='.$post['author'].'">^</a>';
    if ($p['admin'] > 0 || $post['author'] == $LOGIN) $f .= ' - <a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=edit_post&id='.$post['id_post'].'&start='.$start.'&id_forum='.$id_forum.'&id_theme='.$id_theme.'">изменить</a>';
    $f .= '</div>';
    $f .= '<div class="n" id="s2'.$post['puttime'].'">';
    $f .= '<small><span class="gray">'.$post['puttime'].'</span></small><br/>';
    if (!file_exists ('modules/posts/post_'.$post['id_post'].'.txt')) {do_mysql ("DELETE FROM posts WHERE id_post = '".$post['id_post']."';"); $f .= '-<br/>'; continue; }
    $f .= file_get_contents ('modules/posts/post_'.$post['id_post'].'.txt');
    $f .= '</div>';
  }

  $f .= '</div><div class="n" id="sre">';
  // teperq md'shnye ssylki dlja prosmotra
  $c = $totth;
  $nw = floor ($c / $show);

  function need_show ($i, $start, $nw, $show)
  {
    $n = $start / $show; 
    $m = $nw / 2;
    if ($i < 2 || $i > $nw - 2) return 1;
    else if ($i > $n-2 && $i < $n+2) return 1;
    else if ($i > $m-2 && $i < $m+2) return 1;
    else return 0;
  }
  $dots = false;

  for ($i = 0; $i <= $nw; $i++)
  {
    if (!need_show ($i, $start, $nw, $show))
    {
      if (!$dots) $f .= ' ... ';
      $dots = true;
      continue;
    }
    $dots = false;
    if ($i * $show == $start) $f .= ($i + 1).' : ';
    elseif ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showposts&start='.($i * $show).'&id_forum='.$id_forum.'&id_theme='.$id_theme.'&tstart='.$_GET['tstart'].'">'.($i + 1).'</a> : ';
  }
  $f .= '<span class="gray">('.$c.')</span>';
  $f .= '<br/>';

  $f .= '<b>сообшение:</b><br/>';
  $f .= '<form action="game.php" method="get">';
  $f .= '<textarea name="msg" rows="2"></textarea>';
  $f .= '<input type="hidden" name="action" value="forum"/>';
  $f .= '<input type="hidden" name="sub_action" value="add_post"/>';
  $f .= "<input type=\"hidden\" name=\"id_forum\" value=\"".$id_forum."\"/>";
  $f .= "<input type=\"hidden\" name=\"id_theme\" value=\"".$id_theme."\"/>";
  $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
  $f .= '<input type="hidden" name="to" value="all"/>';
  // translit
  $f .= '<br/><input type="radio" name="t" value="1"/>транслит<br/>';
  $f .= '<input type="radio" name="t" value="0"/>как есть<br/>';
  $f .= '<input type="submit" value="написать"/></form>';

  if (!isset ($_GET['tstart'])) $_GET['tstart'] = 0;
  $f .= '<a name="nav"><b>навигация:</b></a> <a class="blue" href="#up"><small>начало</small></a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showposts&id_forum='.$id_forum.'&id_theme='.$id_theme.'&start='.$start.'">обновить</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showthemes&id_forum='.$id_forum.'&start='.$_GET['tstart'].'">темы</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum">форумы</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">друзья</a><br/>';
  $f .= '><a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
  $f .= '</div>';
  $f .= gen_footer();
  exit ($f);
?>