<?php
  // podnjatq ukazanoe kolichestvo veshej
  $item = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['item']);
  $count = preg_replace ('/[^0-9]/', '', $_GET['count']);
  include_once ('modules/f_add_item_to_pl.php');
  if (!$count) $count = 1;
  // proverka, estq li takaja veshq v lokacii
  $q = do_mysql ("SELECT name, on_take, fullname, location, weight FROM items WHERE location = '".$p['location']."' AND fullname = '".$item."';");
  if (!mysql_num_rows($q)) ('такой веши рядом нет');
  $it = mysql_fetch_assoc ($q);
  if ($count > $it['on_take']) $count = $it['on_take'];
  if ($count > $MAX_MISC) $count = $MAX_MISC;

  // kolichestvo:
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
  $c = mysql_result ($q, 0);
  if ($c > $I_SEP_C)  put_g_error('в рюгзаке нехватает места');
  // ves:
  $weight = $it['weight'];
  $q = do_mysql ("SELECT carry FROM players WHERE id_player = '".$p['id_player']."';");
  $pc = mysql_result ($q, 0);
  include_once ('modules/f_get_pl_weight.php');
  $pw = get_pl_weight ($LOGIN);
  if ($pw + $weight > $pc) put_g_error ('<p>вы не можете поднести так много</p>');

  // estq li takaja veshq v inventare:
  include_once ('modules/f_real_name.php');
  $rn = real_name ($item);
  $q = do_mysql ("SELECT fullname, on_take FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND realname = '".$rn."';");
  if (!mysql_num_rows ($q))
  {
    // v banke net takoj, poetomu prosto perekinem veshq:
    if ($count == $it['on_take']) do_mysql ("UPDATE items SET is_in = 'inv', belongs = '".$LOGIN."', map = '', location = '' WHERE fullname = '".$item."';");
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
    // vinventare estq takaja veshq, posemu budem razbiratsja
    $b = mysql_fetch_assoc ($q);
    if ($b['on_take'] + $count > $MAX_MISC) $count = $MAX_MISC - $b['on_take'];
    if (!$count) put_g_error ('больше этой веши взять нелзя');
    include_once ('modules/f_increase_misc.php');
    if ($count == $it['on_take'])
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

  $iname = $it['name'];
  // vzjal ili vzjala
  if ($p['gender'] == 'male')
  {
    $vz = 'поднял';
  }
  else
  {
    $vz = 'подняла';
  }
  add_journal ($p['name'].' '.$vz.' '.$iname.' ('.$count.')', 'l.'.$p['location']);

  $rfn = $rn;
  if (array_key_exists ($rfn, $items))
  {
    // $items podkljuchen v faile s_loadmaps.php
    // znachit nado vernutq
    $time = time();
    $time += 600;
    $nacti = 'item|'.$rfn.'|'.$time;
    $act = do_mysql ("SELECT actions FROM maps WHERE map = '".$pl_map."';");
    $act = mysql_result ($act, 0);
    if (!is_in ($rfn, $act))
    {
      $subc = substr_count ($act, $rfn);
      $itmp = explode (':', $items[$rfn]);
      if ($itmp[2] > $subc)
      {
        if (!$act) $act = $nacti;
        else $act .= '~'.$nacti;
        do_mysql ("UPDATE maps SET actions = '".$act."' WHERE map = '".$pl_map."';");
      }
    }
  }
  $NO_CONTINUE = 1;
  include 'modules/s_journal.php';
?>