<?php
  // odetq ili snjatq knigu magii na mesto:
  $book = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['book']);
  if (!$book) put_error ('neukazana kniga');
  $q = do_mysql ("SELECT name, is_in FROM items WHERE fullname = '".$book."' AND belongs = '".$LOGIN."' AND is_in <> 'ban';");
  if (!mysql_num_rows ($q)) put_error ('нету такой книги');
  $it = mysql_fetch_assoc ($q);

  $f = '';

  if ($it['is_in'] == 'mbk')
  {
    // snimem:
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
    $c = mysql_result ($q, 0);
    if ($c > $I_SEP_C)  put_g_error('в рюгзаке нехватает места');
    $q = do_mysql ("UPDATE items SET is_in = 'inv' WHERE fullname = '".$book."';");
    $f .= 'вы сняли '.$it['name'].'!';
  }
  else
  {
    // estq li tam eshe odna?
    $q = do_mysql ("SELECT fullname FROM items WHERE is_in = 'mbk' AND belongs = '".$LOGIN."';");
    if (mysql_num_rows ($q))
    {
      $itb = mysql_result ($q, 0);
      do_mysql ("UPDATE items SET is_in = 'inv' WHERE fullname = '".$itb."';");
      do_mysql ("UPDATE items SET is_in = 'mbk' WHERE fullname = '".$book."';");
    }
    else do_mysql ("UPDATE items SET is_in = 'mbk' WHERE fullname = '".$book."';");
    $f .= 'вы одели '.$it['name'].'!';
  }

  
  add_journal ($f, $LOGIN);
  $_GET['type'] = 5;
  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>