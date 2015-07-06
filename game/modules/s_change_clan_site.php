<?php
  // izmenitq sajt klana:
  if ($p['clan'][0] && $p['clan'][1] > 6)
  {
    $f = '';
    if (isset ($_GET['clansite']))
    {
      // menjaem:
      $clansite = mysql_real_escape_string ( strip_tags ($_GET['clansite']));
      do_mysql ("UPDATE clans SET clansite = '".$clansite."' WHERE clanname = '".$p['clan'][0]."';");
    }
    $q = do_mysql ("SELECT clansite FROM clans WHERE clanname = '".$p['clan'][0]."';");
    $clansite = mysql_result ($q, 0);
    $f .= '<b>текуший сайт:</b><br/><a class="red" href="'.$clansite.'">'.$clansite.'</a><br/>';
    // forma izmenenija
    $f .= '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="change_clan_site"/>';
    $f .= 'новый:<br/><input type="text" name="clansite" value="http://"/><br/>';
    $f .= '<input type="submit" value="изменить!"/>';
    $f .= '</form>';
    exit_msg ('изменить сайт', $f);
  }
?>