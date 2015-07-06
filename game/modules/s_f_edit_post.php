<?php
  // izmenitq post
  $id = preg_replace ('/[^0-9]/', '', $_GET['id']);

  if ($p['admin'] < 1) $q = do_mysql ("SELECT author FROM posts WHERE id_post = '".$id."' AND author = '".$LOGIN."';");
  else  $q = do_mysql ("SELECT author FROM posts WHERE id_post = '".$id."';");
  if (!mysql_num_rows ($q)) put_g_error ('пост не существует.');

  if (isset ($_GET['msg']))
  {
    include 'smile/s_smile.php';
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
    $msg .= '<br/>изменен: <b>'.$p['name'].'</b>';


    $fp = fopen ('modules/posts/post_'.$id.'.txt', 'w');
    fwrite ($fp, $msg);
    fclose ($fp);
    $_GET['sub_action'] = 'showposts';
  }
  else
  {
    include 'smile/s_smile.php';
    $f = '';
    if (!file_exists ('modules/posts/post_'.$id.'.txt')) put_g_error ('пост не существует');
    $msg = file_get_contents ('modules/posts/post_'.$id.'.txt');
    // vozvrat smajlov
    $count = count($sa);
    for ($i = 0; $i < $count; $i++)
    {
      $msg = str_replace($sb[$i], $sa[$i], $msg);
    }
    $msg = str_replace("<u>", "[u]", $msg);
    $msg = str_replace("</u>", "[/u]", $msg);
    $msg = str_replace("<i>", "[i]", $msg);
    $msg = str_replace("</i>", "[/i]", $msg);
    $msg = str_replace("<b>", "[b]", $msg);
    $msg = str_replace("</b>", "[/b]", $msg);
    $msg = str_replace("<br/>", "[br/]", $msg);
    $msg = str_replace('<a href=', '[url]', $msg);
    $msg = str_replace('</a>', '[/url]', $msg);


    $f .= '<b>сообшение:</b><br/>';
    $f .= '<form action="game.php" method="get">';
    $f .= '<textarea name="msg" rows="2">'.$msg.'</textarea>';
    $f .= '<input type="hidden" name="action" value="forum"/>';
    $f .= '<input type="hidden" name="sub_action" value="edit_post"/>';
    $f .= '<input type="hidden" name="id" value="'.$id.'"/>';
    $f .= "<input type=\"hidden\" name=\"id_forum\" value=\"".$_GET['id_forum']."\"/>";
    $f .= "<input type=\"hidden\" name=\"start\" value=\"".$_GET['start']."\"/>";
    $f .= "<input type=\"hidden\" name=\"id_theme\" value=\"".$_GET['id_theme']."\"/>";
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="to" value="all"/>';
    // translit
    $f .= '<br/><input type="radio" name="t" value="1"/>транслит<br/>';
    $f .= '<input type="radio" name="t" value="0"/>как есть<br/>';
    $f .= '<input type="submit" value="изменить"/></form>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showposts&id_forum='.$_GET['id_forum'].'&id_theme='.$_GET['id_theme'].'&start='.$_GET['start'].'">назад</a><br/>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum&sub_action=showthemes&id_forum='.$_GET['id_forum'].'">темы</a><br/>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=forum">форумы</a><br/>';
    $f .= '><a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">друзья</a><br/>';
    exit_msg ('изменить', $f);
  }
?>