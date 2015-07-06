<?php
  // systemnaja slezhka obnovlenie kvestov:
  include_once ('modules/f_gen_quest.php');
  gen_quest ($p['location']);
  // teperq obnovim zapisq:
  do_mysql ("UPDATE gamesys SET quests_ch = '".$time."' WHERE month = '".$mon."';");
  // zaodno i 
  // ochistim ot staryh trupov
  $qdd = do_mysql ("SELECT fullname FROM dead WHERE puttime < NOW() - INTERVAL '15' MINUTE;");
  while ($de = mysql_fetch_assoc($qdd))
  {
    do_mysql ("DELETE FROM items WHERE belongs = '".$de['fullname']."';");
    do_mysql ("DELETE FROM dead WHERE fullname = '".$de['fullname']."';");
  }
?>