<?php
  // proverim sostojanie igroka (temperaturu)
  $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a2';");
  if (!mysql_num_rows ($q)) $a1 = '';
  else $a1 = mysql_result ($q, 0);
  $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a6';");
  if (!mysql_num_rows ($q)) $a2 = '';
  else $a2 = mysql_result ($q, 0);

  $c1 = substr_count ($a1, '.bo2.fur.');
  $c3 = substr_count ($a2, '.leg.fur.');
  $c1 += $c3;
  $c2 = substr_count ($a1, '.bo2.bas.');
  $c4 = substr_count ($a2, '.leg.bas.');
  $c2 += $c4;

  include_once ('modules/f_loc.php');
  $tem = loc ($p['location'], 'temperature');

  // iznachalqno temperatura budet na 1 menqshe
  $tem -= 1;

  if ($c1 == 2) $tem += 2;
  if ($c2 == 2) $tem += 1;

  if ($tem < 0) $p['status1'][1] = 0;
  else if ($tem == 0) $p['status1'][1] = 1;
  else $p['status1'][1] = 2;
  
  // esli odezhda svoego poshiva, togda vsegda norma
  if (strpos ($a1, '.bas.') == false && strpos ($a1, '.tun.') == false && strpos ($a1, '.fur.') == false ||
      strpos ($a2, '.bas.') == false && strpos ($a2, '.tun.') == false && strpos ($a2, '.fur.') == false )
    $p['status1'][1] = 1;
  do_mysql ("UPDATE players SET status1 = '".$p['status1']."' WHERE id_player = '".$p['id_player']."';");
?>
