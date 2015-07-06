<?php
  // peredvizhenie npc po lokacii
  // peredvizhem vseh npc, kotorye umejut dvigatsja v svoei karte
  $map = substr ($p['location'], 0, 4);
  include_once ('modules/f_loc.php');
  include_once ('modules/f_go_to_loc.php');
  $qn = do_mysql ("SELECT fullname, location, in_battle FROM npc WHERE map = '".$map."' AND move > 0 AND move < 10000 AND belongs = '0';");
  while ($n = mysql_fetch_assoc ($qn))
  {
    if ($n['in_battle']) continue;
    $near = loc ($n['location'], 'near');
    $num = array_rand ($near);
    $n_loc = $near[$num];
    go_to_loc ($n['fullname'], $n_loc[0], $num);
  }
  do_mysql ("UPDATE gamesys SET npc_move = '".$time."' WHERE month = '".$mon."';");
?>