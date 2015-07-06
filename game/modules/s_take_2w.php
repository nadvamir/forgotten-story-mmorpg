<?php
  // odetq vtoroe oruzhie esli estq takoj navyk
  //
  $item = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['weapon']);
  $f = '';

  if (!$p['skills'][41]) put_g_error ('вы неможете взять второе оружие - у вас нету этого навыка');
  $q = do_mysql ("SELECT name, is_in, type FROM items WHERE fullname = '".$item."';");
  $is_in = mysql_fetch_assoc ($q);

  if ($is_in['type'] != 'w') put_error ('это не оружие: '.$item);

  // vmeste s dvuruchnym nelzja nichego:
  if (is_in ('.2h.', $p['weapon'])) put_g_error ('вместе с двуручным второе оружие не возьмешь');

  if ($is_in['is_in'] == 'shi')
  {
    // mesto:
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
    $c = mysql_result ($q, 0);
    if ($c > $I_SEP_C)  put_g_error('в рюгзаке нехватает места');
    // snimem
    do_mysql ("UPDATE items SET is_in = 'inv' WHERE fullname = '".$item."';");
    $f .= 'вы сняли '.$is_in['name'].'!';
  }
  else
  {
    // znachit gdeto ne tam
    // proverim harakteristiku:
    $itinf = do_mysql ("SELECT on_take FROM items WHERE fullname = '".$item."';");
    $itinf = mysql_result ($itinf, 0);
    $itinf = explode ('~', $itinf);
    $tp = substr ($item, 4, 3);
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
    if ($p['skills'][0] < $itinf[0] || $p['skills'][1] < $itinf[1] || $p['skills'][2] < $itinf[2] || $p['skills'][3] < $itinf[3] || $p['skills'][$numb] < $itinf[4])
    {
      put_g_error ('вы не можете одеть вещь, у нее слишком высокие характеристики');
    }

    $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wea';");
    if (!mysql_num_rows ($q)) $weap = '';
    else $weap = mysql_result ($q, 0);
    if (strpos ($weap, '.2h.') !== false) put_g_error ('вы неможете одеть второе оружие, у вас двуручное оружие в руках');

    // togda chto tam?
    $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'shi';");
    if (!mysql_num_rows ($q))
    {
      do_mysql ("UPDATE items SET is_in = 'shi' WHERE fullname = '".$item."';");
    }
    else
    {
      // mestami menjaem
      $fn = mysql_result ($q, 0);
      do_mysql ("UPDATE items SET is_in = 'inv' WHERE fullname = '".$fn."';");
      do_mysql ("UPDATE items SET is_in = 'shi' WHERE fullname = '".$item."';");
    }
    $f .= 'вы одели '.$is_in['name'].'!';
  }
  
  add_journal ($f, $LOGIN);
  $_GET['type'] = 3;
  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>