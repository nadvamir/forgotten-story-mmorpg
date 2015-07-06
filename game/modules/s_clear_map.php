<?php
  // ochistitq kartu
  if ($p['admin'] > 1)
  {
    if (isset ($_GET['map']))
    {
      include_once ('modules/f_erease_map.php');
      $map = preg_replace ('/[^a-z_0-9]/i', '', $_GET['map']);
      erease_map ($map);
    }
    else
    {
      $f = gen_header ('очистка');
      $f .= '<div class="y" id="lsigh"><b>очистка</b></div><p>';
      $q = do_mysql ("SELECT map FROM maps WHERE active <> 'no'");
      while ($map = mysql_fetch_assoc ($q))
      {
        $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=clear_map&map='.$map['map'].'">'.$map['map'].'</a><br/>';
      }
      //$f .= '<form action="game.php" method="get">карта<input type="text" name="map"/><input type="hidden" name="sid" value="'.$sid.'"/><input type="hidden" name="action" value="clear_map"/><input type="submit" value="очистить"/></form>';
      $f .= '<br/> <a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
      $f .= gen_footer();
      exit ($f);
    }
  }      
?>