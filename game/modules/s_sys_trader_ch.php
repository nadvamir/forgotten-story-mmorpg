<?php
  // smena tovarov torgovcev
  $map = substr ($p['location'], 0, 4);
  $qn = do_mysql ("SELECT fullname FROM npc WHERE map = '".$map."' AND type = 't';");
  include_once ('modules/f_new_trade.php');
  while ($n = mysql_fetch_assoc ($qn))
    new_trade ($n['fullname']);
  do_mysql ("UPDATE gamesys SET trader_ch = '".$time."' WHERE month = '".$mon."';");
?>