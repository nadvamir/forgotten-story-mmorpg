<?php
  // napisatq ls kontaktu
  // $to eto login, no dlja sender i sentfor nado id
  $f = gen_header ('писать ЛC');
  // perepishem
  $to = preg_replace ('/[^a-z0-9_]/i', '', $_GET['to']);
  $id = is_player ($to);
  /////////////////////////////////////////////
  // a mozhno li emu pisatq
  $k = do_mysql ("SELECT contacts FROM players WHERE id_player = '".$id."';");
  if (!mysql_num_rows ($k)) $cont = '';
  $cont = mysql_result ($k, 0);
  if (strpos ($cont, $LOGIN) === false) put_g_error ('вы недобавленны у '.$to.' в контакты');
  /////////////////////////////////////////////
  // zapros na imja komu
  $sentfor = $id;
  $k = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
  $namefor = mysql_result ($k, 0);
  $f .= '<div class="y" id="li"><b>написать ЛС:</b></div>';
  $f .= '<div class="n" id="erwu"><a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$to.'">'.$namefor.'</a><br/>';
  $f .= '(<a class="blue" href="game.php?sid='.$sid.'&action=perepiska&to='.$id.'"/>переписка</a>)<br/>';
  $f .= 'сообшение:<br/>';
  $f .= '<form action="game.php" method="get">';
  $f .= '<textarea name="msg" rows="2"></textarea>';
  $f .= '<input type="hidden" name="action" value="addls"/>';
  $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
  $f .= '<input type="hidden" name="to" value="'.$sentfor.'"/>';
  if (isset ($_GET['p']))
    $f .= '<input type="hidden" name="p" value="1"/>';
  // translit
  $f .= '<br/><input type="radio" name="t" value="1"/>транслит<br/>';
  $f .= '<input type="radio" name="t" value="0"/>как есть<br/>';
  $f .= '<input type="submit" value="написать"/></form></div>';
  //--
  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">';
  $f .= 'друзья</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit($f);
?>