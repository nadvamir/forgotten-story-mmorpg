<?php
  // urna, iz kotoroj nado dostatq poroshek
  $p['smq'][5] = 2;
  do_mysql ("UPDATE players SET smq = '".$p['smq']."' WHERE login = '".$LOGIN."';");
  include_once ('modules/f_gain_item.php');
  gain_item ('i.q.que.ib_powder', 1, $LOGIN);
  include_once ('modules/f_teleport.php');
  teleport ($LOGIN, 'novi|1x6');
?>