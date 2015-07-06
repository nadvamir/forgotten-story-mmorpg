<?php
  // sozdanie foruma:
  if ($p['admin'] > 1)
  {
    $name = mysql_real_escape_string ( strip_tags ( addslashes ( trim ( $_GET['name'] ))));
    // BBCode
    $name = str_replace("[u]", "<u>", $name);
    $name = str_replace("[/u]", "</u>", $name);
    $name = str_replace("[i]", "<i>", $name);
    $name = str_replace("[/i]", "</i>", $name);
    $name = str_replace("[b]", "<b>", $name);
    $name = str_replace("[/b]", "</b>", $name);
    $name = str_replace("[br/]", "<br/>", $name);
    $name = eregi_replace("(.*)\\[url\\](.*)\\[/url\\](.*)", "\\1<a href=\\2>\\2</a>\\3", $name);
    do_mysql ("INSERT INTO news VALUES (0, NOW(), '".$LOGIN."');");
    $q = do_mysql ("SELECT id_new FROM news WHERE author = '".$LOGIN."' ORDER BY puttime DESC;");
    $id_new = mysql_result ($q, 0);
    $fp = fopen ('modules/news/new_'.$id_new.'.txt', 'w');
    fwrite ($fp, $name);
    fclose ($fp);
    exit_msg ('coздание новости:', 'новость ::  '.$name.' :: добавленна!');
  }
?>