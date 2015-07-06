<?php
  // snjatq oruzhie s pojasa v inventarq
  $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wst';");
  if (!mysql_num_rows ($q)) put_error ('у вас нету ничего на поясе!');
  $wst = mysql_result ($q, 0);

  // kolichestvo:
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv';");
  $c = mysql_result ($q, 0);
  if ($c > $I_SEP_C) put_g_error ('вы неможете снять оружие, ваш рюгзак полон!');

  do_mysql ("UPDATE items SET is_in = 'inv' WHERE fullname = '".$wst."';");

  $f = 'вы сняли оружие c поясa!';
  
  add_journal ($f, $LOGIN);
  $_GET['type'] = 3;
  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>