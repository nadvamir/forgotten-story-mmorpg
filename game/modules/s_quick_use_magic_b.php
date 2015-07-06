<?php
  // bystroe ispolqzovanie veshej
  $num = preg_replace ('/[^0-9]/', '', $_GET['num']);
  if ($num === false) put_error ('a num gde?');
  // spisok zaklinanij:
  $q = do_mysql ("SELECT on_take, fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'mbk';");
  if (!mysql_num_rows ($q)) put_error ('у вас неодета книга');
  $b = mysql_fetch_assoc ($q);
  $spl = $b['on_take'];
  $spl = explode ('~', $spl);
  if ($num > (count ($spl))) $num = count ($spl);
  if ($num <= 0) $num = 1;
  $num -= 1;
  $_GET['spell'] = $spl[$num];
  $_GET['book'] = $b['fullname'];
  $action = 'cast_from_book';
?>