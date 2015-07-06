<?php
  // napisatq soobshenie konkretnomu chelu i dobavitq v zhurnal
  $to = preg_replace ('/[^a-z0-9_]/i', '', $_GET['to']);
  // esli u chela otkljuchen zhurnal to nezachem muchatqsja i pisatq emu soobshenie
  // da i servaka zhalko...
  $id = is_player ($to);
  $qset = do_mysql ("SELECT settings FROM players WHERE id_player = '".$id."';");
  $set = mysql_result ($qset, 0);
  if ($set[3] == 0) put_g_error ('у '.$to.' отключен показ событий, ваше сообшение всеровно небудет прочитанно');
  // teperq mozhno vyvoditq formu
  $f = gen_header ('сообщение');
  $q = do_mysql ("SELECT name FROM players WHERE id_player = '".$id."';");
  $namefor = mysql_result ($q, 0);
  $f .= '<div class="y" id="fg"><b>'.$namefor.', </b></div>';
  $f .= '<div class="n" id="eruaj">сообщение: <br/>';
  $f .= '<form action="game.php" method="get">';
  $f .= '<textarea name="msg" rows="2"></textarea>';
  $f .= '<input type="hidden" name="action" value="addmsg"/>';
  $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
  $f .= '<input type="hidden" name="to" value="'.$to.'"/>';
  // translit
  $f .= '<br/><input type="radio" name="t" value="1"/>транслит<br/>';
  $f .= '<input type="radio" name="t" value="0"/>как есть<br/>';
  $f .= '<select size="1" name="shep">';
  $f .= '<option value="0">говорить</option>';
  $f .= '<option value="1">шептать</option>';
  $f .= '<option value="2">всему клану</option>';
  $f .= '<option value="3">партии</option>';
  $f .= '</select><br/>';
  $f .= '<input type="submit" value="написать"/></form></div>';
  //----------
  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>