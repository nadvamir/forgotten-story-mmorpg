<?php
  // povesitq na pojas oruzhie iz inventarja
  $weapon = preg_replace ('/[^a-z-0-9\._]/i', '', $_GET['weapon']);
  $q = do_mysql ("SELECT name FROM items WHERE fullname = '".$weapon."' AND type = 'w' AND belongs = '".$LOGIN."' AND is_in = 'inv';");
  if (!mysql_num_rows ($q)) put_g_error ('у вас нету этой вещи');
  $name = mysql_result ($q, 0);

  // harakteristika:
  $itinf = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$weapon."';");
  $itinf = mysql_result ($itinf, 0);
  $itinf = explode ('~', $itinf);
  // tip
  $tp = substr ($weapon, 4, 3);
  switch ($tp)
  {
    case 'swo': $numb = 7; break;
    case 'axe': $numb = 8; break;
    case 'ham': $numb = 9; break;
    case 'spe': $numb = 10; break;
    case 'bow': $numb = 11; break;
    case 'arb': $numb = 12; break;
    case 'kni': $numb = 13; break;
    case 'kli': $numb = 14; break;
    case 'tre': $numb = 15; break;
  }
  if ($p['skills'][0] < $itinf[0] || $p['skills'][1] < $itinf[1] || $p['skills'][2] < $itinf[2] || $p['skills'][3] < $itinf[3] || isset($numb) && $p['skills'][$numb] < $itinf[4])
  {
    put_g_error ('толку вам это на пояс вешать, у вас слишком малые характеристики, ведь всеровно не воспользуетесь...?');
  }

  // estq li na pojase chtoto:
  $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wst';");
  if (mysql_num_rows ($q))
  {
    $wst = mysql_result ($q, 0);
    do_mysql ("UPDATE items SET is_in = 'inv' WHERE fullname = '".$wst."';");
  }

  // stavim:
  do_mysql ("UPDATE items SET is_in = 'wst' WHERE fullname = '".$weapon."';");

  $f = 'вы повесили '.$name.' на пояс!';
  
  add_journal ($f, $LOGIN);
  $_GET['type'] = 3;
  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>