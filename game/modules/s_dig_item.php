<?php
  // zakopatq
  require_once ('modules/f_real_name.php'); // tut to ponadobitsja...
  $item = $_GET['item'];
  $item = preg_replace ('/[^a-z0-9\._\|]/i', '', $item);
  $q = do_mysql ("SELECT id_item FROM items WHERE fullname = '".$item."' AND belongs = '".$LOGIN."' AND is_in = 'inv';");
  if (!mysql_num_rows ($q)) put_error ('вешь не найдена'); 
  $id = mysql_result ($q, 0);
  $li = loc ($p['location'], 'locinfo');
  if ($li[6]) put_g_error ('пол-то может нестоит портить?');

  // lopata
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE realname = 'i.q.que.lopata' AND belongs = '".$LOGIN."' AND is_in = 'inv';");
  $LOPATA = mysql_result ($q, 0);
  if (!$LOPATA) put_g_error ('а копать ногтями собрался?');
  $rn = real_name ($item);
  if ($rn == 'i.q.que.lopata' && $LOPATA == 1) put_g_error ('Oo зарыть лопату тойже лопатой? сурово...');

  // roem...
  do_mysql ("UPDATE items SET belongs = '".$p['location']."' WHERE id_item = '".$id."';");

  $q = do_mysql ("SELECT name FROM items WHERE id_item = '".$id."';");
  $name = mysql_result ($q, 0);
  add_journal ('вы зарыли '.$name.' себе под ноги. Используйте лопату в этой локации, чтоб отрыть вновь', $LOGIN);

  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>