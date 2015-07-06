<?php
  // vzjatq melkuju veshq iz banka
  $item = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['item']);
  $count = preg_replace ('/[^0-9]/', '', $_GET['count']);
  $bank2 = preg_replace ('/[^a-z-0-9\._]/i', '', $_GET['bank']);
  if (!$count) $count = 1;

  // estq li rjadom bank:
  $q = do_mysql ("SELECT name FROM items WHERE location = '".$p['location']."' AND fullname = '".$bank2."';");
  if (!mysql_num_rows ($q)) put_g_error ('нету куда ложить');
  $bname = mysql_result ($q, 0);

  // estq li veshq:
  $q = do_mysql ("SELECT on_take FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'ban' AND fullname = '".$item."';");
  if (!mysql_num_rows ($q)) put_g_error ('в банке нету этой вещи');
  $count_b = mysql_result ($q, 0);
  $q = do_mysql ("SELECT name FROM items WHERE fullname = '".$item."';");
  $name = mysql_result ($q, 0);

  // hvataet li v inventare mesta:
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
  $c = mysql_result ($q, 0);
  if ($c > $I_SEP_C) put_g_error ('нехватает места');

  if ($count_b < $count) $count = $count_b;

  // estq li takaja v inventare:
  include_once ('modules/f_real_name.php');
  $rn = real_name ($item);
  $q = do_mysql ("SELECT fullname, on_take FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND realname = '".$rn."';");
  if (!mysql_num_rows ($q))
  {
    // v banke net takoj, poetomu prosto perekinem veshq:
    if ($count_b == $count) do_mysql ("UPDATE items SET is_in = 'inv' WHERE fullname = '".$item."';");
    else
    {
      // ne vse lozhatsja, tak umenqshim kol-vo
      include_once ('modules/f_decrease_misc.php');
      include_once ('modules/f_create_item_m.php');
      $nitem = create_item_m ($rn, $count);
      do_mysql ("UPDATE items SET belongs = '".$LOGIN."', is_in = 'inv' WHERE fullname = '".$nitem."';");
      decrease_misc ($item, $count);
    }
  }
  else
  {
    // v inventare estq takaja veshq, posemu budem razbiratsja
    $b = mysql_fetch_assoc ($q);
    if ($b['on_take'] + $count > $MAX_MISC) $count = $MAX_MISC - $b['on_take'];
    if (!$count) put_g_error ('больше этой веши взять нелзя');
    include_once ('modules/f_increase_misc.php');
    if ($count == $count_b)
    {
      include_once ('modules/f_delete_item.php');
      delete_item ($item);
      increase_misc ($b['fullname'], $count);
    }
    else
    {
      include_once ('modules/f_decrease_misc.php');
      decrease_misc ($item, $count);
      increase_misc ($b['fullname'], $count);
    }
  }

  //$f = gen_header ($bname);
  //$f .= '<div class="y" id="f"><b>'.$bname.':</b></div><p>';
  $f = 'вы взяли ';
  $f .= $name.' ('.$count.') из '.$bname.'!<br/>';
  //$f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$bank.'">'.$bname.'</a><br/>';
  //$f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  //$f .= gen_footer();
  //exit($f)
  $SYSMSG = $f;
  $p = get_pl_info ($LOGIN, 'all');
  $_GET['item'] = $bank2;
  include ('modules/s_use_stand.php');
?>