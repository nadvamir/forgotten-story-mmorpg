<?php
  // ispolqzovatq bronju (ili snjatq esli odeto)
  // kakoj tip:
  $f = '';
  $tp = substr ($item, 4, 3);
  switch ($tp)
  {
    case 'hea': $numb = 0; break;
    case 'bo1': $numb = 1; break;
    case 'bo2': $numb = 2; break;
    case 'sho': $numb = 3; break;
    case 'glo': $numb = 4; break;
    case 'bel': $numb = 5; break;
    case 'leg': $numb = 6; break;
    case 'pon': $numb = 7; break;
    case 'bot': $numb = 8; break;
    case 'amu': $numb = 9; break;
    case 'rin': $numb = 10; break;
    default: put_error ('ne bronja eto');
  }
  //
  $q = do_mysql ("SELECT id_item, name, is_in FROM items WHERE fullname = '".$item."';");
  $is_in = mysql_fetch_assoc ($q);

  if ($is_in['is_in'] == 'a'.$numb)
  {
    // mesto:
    $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
    $c = mysql_result ($q, 0);
    if ($c > $I_SEP_C)  put_g_error('в рюгзаке нехватает места');
    // snimem
    do_mysql ("UPDATE items SET is_in = 'inv' WHERE id_item = '".$is_in['id_item']."';");
    $f .= 'вы сняли '.$is_in['name'].'!';
    if ($numb == 9 || $numb == 10)
    {
      $jew = do_mysql ("SELECT on_use FROM items WHERE id_item = '".$is_in['id_item']."';");
      $jew = mysql_result ($jew, 0);
      $jew = explode ('~', $jew);
      $p['skills'][0] -= $jew[0];
      $p['skills'][1] -= $jew[1];
      $p['skills'][2] -= $jew[2];
      $p['skills'][3] -= $jew[3];
      $sk = implode ('|', $p['skills']);
      do_mysql ("UPDATE players SET skills = '".$sk."' WHERE id_player = '".$p['id_player']."';");
    }
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

    // togda chto tam?
    $q = do_mysql ("SELECT id_item FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a".$numb."';");
    if (!mysql_num_rows ($q))
    {
      do_mysql ("UPDATE items SET is_in = 'a".$numb."' WHERE id_item = '".$is_in['id_item']."';");
      if ($numb == 9 || $numb == 10)
      {
        $jew = do_mysql ("SELECT on_use FROM items WHERE id_item = '".$is_in['id_item']."';");
        $jew = mysql_result ($jew, 0);
        $jew = explode ('~', $jew);
        $p['skills'][0] += $jew[0];
        $p['skills'][1] += $jew[1];
        $p['skills'][2] += $jew[2];
        $p['skills'][3] += $jew[3];
        $sk = implode ('|', $p['skills']);
        do_mysql ("UPDATE players SET skills = '".$sk."' WHERE id_player = '".$p['id_player']."';");
      }
    }
    else
    {
      // mestami menjaem
      $fn = mysql_result ($q, 0);
      if ($numb == 9 || $numb == 10)
      {
        $jew2 = do_mysql ("SELECT on_use FROM items WHERE id_item = '".$fn."';");
        $jew2 = mysql_result ($jew2, 0);
        $jew2 = explode ('~', $jew2);
        $p['skills'][0] -= $jew2[0];
        $p['skills'][1] -= $jew2[1];
        $p['skills'][2] -= $jew2[2];
        $p['skills'][3] -= $jew2[3];

        if ($p['skills'][0] < $itinf[0] || $p['skills'][1] < $itinf[1] || $p['skills'][2] < $itinf[2] || $p['skills'][3] < $itinf[3])
        {
          put_g_error ('вы не можете одеть вещь, у нее слишком высокие характеристики');
        }

        $jew = do_mysql ("SELECT on_use FROM items WHERE id_item = '".$is_in['id_item']."';");
        $jew = mysql_result ($jew, 0);
        $jew = explode ('~', $jew);
        $p['skills'][0] += $jew[0];
        $p['skills'][1] += $jew[1];
        $p['skills'][2] += $jew[2];
        $p['skills'][3] += $jew[3];
        $sk = implode ('|', $p['skills']);
        do_mysql ("UPDATE players SET skills = '".$sk."' WHERE id_player = '".$p['id_player']."';");
      }
      do_mysql ("UPDATE items SET is_in = 'inv' WHERE id_item = '".$fn."';");
      do_mysql ("UPDATE items SET is_in = 'a".$numb."' WHERE id_item = '".$is_in['id_item']."';");
    }
    $f .= 'вы одели '.$is_in['name'].'!';
  }
  
  add_journal ($f, $LOGIN);
  $_GET['type'] = 4;
  include 'modules/s_journal.php'; // zhurnal na posledok
  include 'modules/s_showinventory.php'; 
?>