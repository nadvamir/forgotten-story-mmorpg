<?php
  // pokupka veshi iz marketa:
  $item = mysql_real_escape_string ($_GET['buy']);
  $q = do_mysql ("SELECT name, pprice, belongs FROM items WHERE fullname = '".$item."' AND is_in = 'mar';");
  if (!mysql_num_rows ($q)) put_g_error ('нет такой вещи');
  $it = mysql_fetch_assoc ($q);
  if ($p['money'] < $it['pprice'] && $it['belongs'] != $LOGIN) put_g_error ('денег нехватает');
  // ne proverjatq, lezet li v rjukzak po vesu, lishq po slotam:
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
  $c = mysql_result ($q, 0);
  if ($c > $I_SEP_C) put_g_error ('в рюгзаке нехватает места');
  // pokupaem:
  if ($it['belongs'] != $LOGIN)
  {
    do_mysql ("UPDATE players SET money = money - ".$it['pprice']." WHERE id_player = '".$p['id_player']."';");
    do_mysql ("UPDATE players SET money = money + ".$it['pprice']." WHERE login = '".$it['belongs']."';");
    add_journal ('<b>у вас купили '.$it['name'].'!</b>', $it['belongs']);
  }
  do_mysql ("UPDATE items SET is_in = 'inv', belongs = '".$LOGIN."' WHERE fullname = '".$item."';");
  $SYSMSG = 'вы купили '.$it['name'].' за '.$it['pprice'].' серебренных!';
?>