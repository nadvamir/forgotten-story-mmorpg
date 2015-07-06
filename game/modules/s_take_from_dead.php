<?php
  // vzjatq veshq s trupa
  $dead = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['dead']);
  $item = preg_replace ('/[^a-z0-9\._]/i', '', $_GET['item']);
  if (!$dead) put_error ('а с какого трупа то брать!!?');
  if (!isset ($f)) $f = '';

  $q = do_mysql ("SELECT name, weight, on_take FROM items WHERE fullname = '".$item."' AND belongs = '".$dead."';");
  if (!mysql_num_rows ($q)) put_g_error ('на трупе нету этой вещи');
  $it = mysql_fetch_assoc ($q);

  // estq li rjadom trup:
  $q = do_mysql ("SELECT name FROM dead WHERE location = '".$p['location']."' AND fullname = '".$dead."';");
  if (!mysql_num_rows ($q)) put_g_error ('нету oткуда брать');
  $di['name'] = mysql_result ($q, 0);

  include_once ('modules/f_add_item_to_pl.php');

  // smotrja kakoj tip veshi:
  if (substr ($item, 2, 1) == 'm')
  {
    $count = $it['on_take'];
    // melkaja veshq:
    // estq li takaja v inventare
    include_once ('modules/f_real_name.php');
    $rn = real_name ($item);
    $q = do_mysql ("SELECT fullname, on_take FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND realname = '".$rn."';");
    if (!mysql_num_rows ($q))
    {
      // v inventare net takoj, poetomu prosto perekinem veshq:
      add_item_to_pl ($LOGIN, $item);
    }
    else
    {
      // v inventare estq takaja veshq, posemu budem razbiratsja
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
  }
  else
  {
    // veshq normalqnaja, posemu prosto perelozhim:
    add_item_to_pl ($LOGIN, $item);
  }

  $dead2 = $dead;
  // nu a teperq razberemsja, mozhno li tak:
  if (substr ($dead, 0, 4) == 'd.n.')
  {
    $dead = explode ('.', $dead);
    if ($dead[2] != $p['id_player'])
    {
      $q = do_mysql ("SELECT login, clan FROM players WHERE id_player = '".$dead[2]."';");
      $cl = mysql_fetch_assoc ($q); 
      $clan = explode ('|', $cl['clan']);
      if ($p['clan'][0] != $clan[0])
      {
        if ($p['marry'] != $cl['login'])
        {
          // ne ty, ne zhena i ne soklanovec.
          // maroder tobishq
          $p['status1'][0] = 1;
          $p['last'][4] = time();
          include_once ('modules/f_decrease_karma.php');
          decrease_karma ($LOGIN, 1);
          $last = implode ('|', $p['last']);
          do_mysql ("UPDATE players SET last = '".$last."', status1 = '".$p['status1']."' WHERE id_player = '".$p['id_player']."';");
        }
      }
    }
  }

  $f .= 'вы взяли '.$it['name'].'!';
  $q = do_mysql ("SELECT fullname FROM items WHERE belongs = '".$dead2."';");
  if (!mysql_num_rows ($q)) include 'modules/s_main.php';
  $SYSMSG = $f;
  $_GET['dead'] = $dead2;
  include 'modules/s_take_dead.php';
?>