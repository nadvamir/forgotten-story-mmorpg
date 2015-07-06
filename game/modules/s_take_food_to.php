<?php
  // odevaet eleksiry na pojas
  $q = do_mysql ("SELECT on_drop FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a5';");
  if (!mysql_num_rows ($q)) put_g_error ('вы не можете повесить напиток себе на пояс, по причине отсутствия такого.');
  $max = mysql_result ($q, 0);

  // skolqko sejchas estq:
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'pot';");
  $num = mysql_result ($q, 0);

  if ($num >= $max) put_g_error ('все слоты исчерпаны!');

  $item = preg_replace ('/[^0-9a-z_\.]/i', '', $_GET['food']);
  $q = do_mysql ("SELECT name FROM items WHERE belongs = '".$LOGIN."' AND fullname = '".$item."' AND type = 'f';");
  if (!mysql_num_rows ($q)) put_g_error ('у вас нету этой вещи!');
  $name = mysql_result ($q, 0);

  // esli vse horosho - veshaem:
  do_mysql ("UPDATE items SET is_in = 'pot' WHERE fullname = '".$item."';");
  $f = 'вы повесили '.$name.' на пояс!';
  
  add_journal ($f, $LOGIN);
  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>