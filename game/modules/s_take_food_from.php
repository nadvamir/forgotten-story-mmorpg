<?php
  // snimajut eleksiry s pojasa
  $item = preg_replace ('/[^0-9a-z_\.]/i', '', $_GET['food']);
  $q = do_mysql ("SELECT name FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'pot' AND fullname = '".$item."';");
  if (!mysql_num_rows ($q)) put_g_error ('у вас нету этой вещи: '.$item);
  $name = mysql_result ($q, 0);

  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
  $c = mysql_result ($q, 0);
  if ($c > $I_SEP_C)  put_g_error('в рюгзаке нехватает места');

  // mesta hvataet, veshq estq - kidaem:
  do_mysql ("UPDATE items SET is_in = 'inv' WHERE fullname = '".$item."';");
  $f .= 'вы положили '.$name.' в рюгзак!';
  
  add_journal ($f, $LOGIN);
  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>