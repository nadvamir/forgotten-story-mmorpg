<?php
  // ispolqzovatq bronju (ili snjatq esli odeto)
  //
  $q = do_mysql ("SELECT id_item, name, is_in FROM items WHERE fullname = '".$item."';");
  $is_in = mysql_fetch_assoc ($q);
  $f = '';

  if ($is_in['is_in'] == 'wea')
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
    // proverka na navyki
    // proverka na dvuruchnoe:    
    $itinf = do_mysql ("SELECT on_take FROM items WHERE id_item = '".$is_in['id_item']."';");
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
      case 'wan': $numb = 16; break;
    }
    $DVU = 0;
    if (strpos ($item, '.2h.') !== false)
    {
      if ($p['skills'][40] < 1 && $numb != 10 && $numb != 11 && $numb != 12) put_g_error ('вы неможете одеть двуручное оружее, неумеете');
      $DVU = 1;
    }
    $DVA = 0;
    $q = do_mysql ("SELECT id_item, type FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'shi';");
    if (mysql_num_rows ($q) && $DVU)
    {
      $fn = mysql_fetch_assoc ($q);
      if ($DVU) 
      {
        // snimem wit:
        // mesto:
        $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv';");
        $c = mysql_result ($q, 0);
        if ($c > $I_SEP_C)  put_g_error('в рюгзаке нехватает места чтоб снять щит');
        // snimem
        do_mysql ("UPDATE items SET is_in = 'inv' WHERE id_item = '".$fn['id_item']."';");
        $f .= 'вы сняли '.$is_in['name'].'!';
      }
      else
      {
        // eto dva oruzhija
        if ($fn['type'] == 'w')
          $DVA = 1;
      }
    }
    $minskill = $p['skills'][$numb] + (($DVU) ? $p['skills'][40] : 0) + (($DVA) ? $p['skills'][41] : 0);
    if ($p['skills'][0] < $itinf[0] || $p['skills'][1] < $itinf[1] || $p['skills'][2] < $itinf[2] || $p['skills'][3] < $itinf[3] || isset($numb) && $minskill < $itinf[4])
    {
      put_g_error ('вы не можете одеть вещь, у нее слишком высокие характеристики');
    }


    // togda chto tam?
    $q = do_mysql ("SELECT id_item FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'wea';");
    if (!mysql_num_rows ($q))
    {
      do_mysql ("UPDATE items SET is_in = 'wea' WHERE id_item = '".$is_in['id_item']."';");
    }
    else
    {
      // mestami menjaem
      $fn = mysql_result ($q, 0);
      do_mysql ("UPDATE items SET is_in = 'inv' WHERE id_item = '".$fn."';");
      do_mysql ("UPDATE items SET is_in = 'wea' WHERE id_item = '".$is_in['id_item']."';");
    }
    $f .= 'вы одели '.$is_in['name'].'!';
  }
  
  add_journal ($f, $LOGIN);
  $_GET['type'] = 3;
  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>