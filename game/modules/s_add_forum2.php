<?php
  // sozdanie foruma:
  if ($p['admin'] > 1)
  {
    $name = mysql_real_escape_string ( strip_tags ( addslashes ( trim ( $_GET['name'] ))));
    do_mysql ("INSERT INTO forums VALUES (0, '".$_GET['name']."');");
    exit_msg ('coздание форума:', 'форум '.$name.' создан!');
  }
?>