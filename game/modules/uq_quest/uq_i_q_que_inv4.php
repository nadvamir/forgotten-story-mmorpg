<?php
  // novyj rjugzak 4
  $p['settings'][5] = 4;
  do_mysql ("UPDATE players SET settings = '".$p['settings']."' WHERE login = '".$LOGIN."';");
  add_journal ('вы сменили заплесный мешок!', $LOGIN);
  include_once ('modules/f_delete_item.php');
  delete_item ($item);
?>