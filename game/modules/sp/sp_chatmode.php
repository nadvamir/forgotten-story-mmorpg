<?php
  // ssylka izmenitq na loc mode i nadpisq chto eto chat
  $f .= '<div class="y" id="odisd">';
  $f .= '<a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=pgmode&set=1">+</a>';
  $f .= '<b>чат</b>:</div>';
  $f .= '<div class="n" id="afie">сообщение: <br/>';
  $f .= '<form action="game.php" method="get">';
  $f .= '<textarea name="msg" rows="2"></textarea>';
  $f .= '<input type="hidden" name="action" value="addmsg"/>';
  $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
  $f .= '<input type="hidden" name="to" value=""/>';
  // translit
  $f .= '<br/><input type="radio" name="t" value="1"/>транслит<br/>';
  $f .= '<input type="radio" name="t" value="0"/>как есть<br/>';
  $f .= '<select size="1" name="shep">';
  $f .= '<option value="0">говорить</option>';
  $f .= '<option value="2">всему клану</option>';
  $f .= '<option value="3">партии</option>';
  $f .= '</select><br/>';
  $f .= '<input type="submit" value="написать"/></form>----------<br/>';
  // te kto v loke
  $a = do_mysql ("SELECT login, name FROM players WHERE location = '".$p['location']."' AND login != '".$LOGIN."' AND active = '1' AND hidden = '0';");
  $f .= '<small>';
  while ($pl = mysql_fetch_assoc ($a))
  {
    // login -- ssylka napisatq emu soobshenie
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=wmsg&to='.$pl['login'].'">';
    $f .= $pl['name'].'</a> | ';
  }
  $f .= '</small>';
  $f .= '<br/>><a class="blue" href="game.php?sid='.$sid.'" accesskey="5">обновить</a></div>';
?>