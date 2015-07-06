<?php
  // novyj rjugzak 5
  $p['settings'][5] = 5;
  do_mysql ("UPDATE players SET settings = '".$p['settings']."' WHERE login = '".$LOGIN."';");
  add_journal ('вы сменили заплесный мешок!', $LOGIN);
  include_once ('modules/f_delete_item.php');
  delete_item ($item);
?>