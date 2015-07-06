<?php
  // izmenitq zadachu klana:
  if ($p['clan'][0] && $p['clan'][1] > 6)
  {
    $f = '';
    if (isset ($_GET['rank1']))
    {
      // menjaem:
      $rank1 = substr ((mysql_real_escape_string ( strip_tags ($_GET['rank1']))), 0, 20);
      $rank2 = substr ((mysql_real_escape_string ( strip_tags ($_GET['rank2']))), 0, 20);
      $rank3 = substr ((mysql_real_escape_string ( strip_tags ($_GET['rank3']))), 0, 20);
      $rank4 = substr ((mysql_real_escape_string ( strip_tags ($_GET['rank4']))), 0, 20);
      $rank5 = substr ((mysql_real_escape_string ( strip_tags ($_GET['rank5']))), 0, 20);
      $rank6 = substr ((mysql_real_escape_string ( strip_tags ($_GET['rank6']))), 0, 20);
      $rank7 = substr ((mysql_real_escape_string ( strip_tags ($_GET['rank7']))), 0, 20);
      do_mysql ("UPDATE clans SET rank1 = '".$rank1."', rank2 = '".$rank2."', rank3 = '".$rank3."', rank4 = '".$rank4."', rank5 = '".$rank5."', rank6 = '".$rank6."', rank7 = '".$rank7."' WHERE clanname = '".$p['clan'][0]."';");
      $f .= '<b>изменено!</b><br/>';
    }
    $q = do_mysql ("SELECT rank1, rank2, rank3, rank4, rank5, rank6, rank7 FROM clans WHERE clanname = '".$p['clan'][0]."';");
    $ranks = mysql_fetch_assoc ($q);
    $f .= '<b>ранги:</b><br/><i>'.$clantask.'</i><br/>';
    // forma izmenenija
    $f .= '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="change_c_titles"/>';
    $f .= '#1: <input type="text" name="rank1" value="'.$ranks['rank1'].'"/><br/>';
    $f .= '#2: <input type="text" name="rank2" value="'.$ranks['rank2'].'"/><br/>';
    $f .= '#3: <input type="text" name="rank3" value="'.$ranks['rank3'].'"/><br/>';
    $f .= '#4: <input type="text" name="rank4" value="'.$ranks['rank4'].'"/><br/>';
    $f .= '#5: <input type="text" name="rank5" value="'.$ranks['rank5'].'"/><br/>';
    $f .= '#6: <input type="text" name="rank6" value="'.$ranks['rank6'].'"/><br/>';
    $f .= '#7: <input type="text" name="rank7" value="'.$ranks['rank7'].'"/><br/>';
    $f .= '<input type="submit" value="изменить!"/>';
    $f .= '</form>';
    exit_msg ('ранги', $f);
  }
?>