﻿<?php
  // ukazatq kolichestvo dlja vzjatija veshi
  $item = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['item']);
  if (substr ($item, 2, 1) != 'm') put_error ('это не мелкая вещь');
  $f = gen_header ('Поднять');
  $f .= '<div class="y" id="oaisy"><b>';
  $mit = do_mysql ("SELECT name, on_take FROM items WHERE fullname = '".$item."';");
  $mit = mysql_fetch_assoc ($mit);
  $f .= $mit['name'].'</b> ('.$mit['on_take'].')</div><div class="n" id="ag">';
  $f .= '<form action="game.php" method="get">';
  $f .= 'количество: <br/>';
  $f .= '<input type="text" name="count"/><br/>';
  $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
  $f .= '<input type="hidden" name="action" value="take_misc2"/>';
  $f .= '<input type="hidden" name="item" value="'.$item.'"/>';
  $f .= '<input type="submit" value="взять"/></form>';
  $f .= '<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a>';
  $f .= '</div>';
  $f .= gen_footer();
  exit ($f);
?>