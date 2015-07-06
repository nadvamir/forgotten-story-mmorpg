<?php
  // ispolqzovatq bronju (ili snjatq esli odeto)
  //
  $q = do_mysql ("SELECT id_item, name, is_in FROM items WHERE fullname = '".$item."';");
  $is_in = mysql_fetch_assoc ($q);
 
  $f = '';
  if ($is_in['is_in'] == 'shi')
  {
    // mesto:
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
    $c = mysql_result ($q, 0);
    if ($c > $I_SEP_C)  put_g_error('в рюгзаке нехватает места');
    // snimem
    do_mysql ("UPDATE items SET is_in = 'inv' WHERE id_item = '".$is_in['id_item']."';");
    $f .= 'вы сняли '.$is_in['name'].'!';
  }
  else
  {
    // znachit gdeto ne tam
    // proverim harakteristiku:
    $itinf = do_mysql ("SELECT on_take FROM items WHERE id_item = '".$is_in['id_item']."';");
    $itinf = mysql_result ($itinf, 0);
    $itinf = explode ('~', $itinf);
    if ($p['skills'][0] < $itinf[0] || $p['skills'][1] < $itinf[1] || $p['skills'][2] < $itinf[2] || $p['skills'][3] < $itinf[3])
    {
      put_g_error ('вы не можете одеть вещь, у нее слишком высокие характеристики');
    }
    if (!$p['skills'][18]) put_g_error ('вы неумеете пользоватся щитом');

    $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wea';");
    if (!mysql_num_rows ($q)) $weap = '';
    else $weap = mysql_result ($q, 0);
    if (strpos ($weap, '.2h.') !== false) put_g_error ('вы неможете одеть щит, у вас двуручное оружие');

    // togda chto tam?
    $q = do_mysql ("SELECT id_item FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'shi';");
    if (!mysql_num_rows ($q))
    {
      do_mysql ("UPDATE items SET is_in = 'shi' WHERE id_item = '".$is_in['id_item']."';");
    }
    else
    {
      // mestami menjaem
      $fn = mysql_result ($q, 0);
      do_mysql ("UPDATE items SET is_in = 'inv' WHERE id_item = '".$fn."';");
      do_mysql ("UPDATE items SET is_in = 'shi' WHERE id_item = '".$is_in['id_item']."';");
    }
    $f .= 'вы одели '.$is_in['name'].'!';
  }
  
  add_journal ($f, $LOGIN);
  $_GET['type'] = 4;
  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>