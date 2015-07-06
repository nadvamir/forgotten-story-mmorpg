<?php
  // izmenitq zadachu klana:
  if ($p['clan'][0] && $p['clan'][1] > 6)
  {
    $f = '';
    if (isset ($_GET['clantask']))
    {
      // menjaem:
      $clantask = mysql_real_escape_string ( strip_tags ($_GET['clantask']));
      do_mysql ("UPDATE clans SET task = '".$clantask."' WHERE clanname = '".$p['clan'][0]."';");
    }
    $q = do_mysql ("SELECT task FROM clans WHERE clanname = '".$p['clan'][0]."';");
    $clantask = mysql_result ($q, 0);
    $f .= '<b>задача клана:</b><br/><i>'.$clantask.'</i><br/>';
    // forma izmenenija
    $f .= '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="change_clan_task"/>';
    $f .= 'новая:<br/><input type="text" name="clantask"/><br/>';
    $f .= '<input type="submit" value="изменить!"/>';
    $f .= '</form>';
    exit_msg ('изменить сайт', $f);
  }
?>