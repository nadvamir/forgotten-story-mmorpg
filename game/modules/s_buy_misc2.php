<?php
  // kupitq melkuju veshq
  $item = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['item']);
  $npc = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['npc']);
  $nid = is_npc ($npc);
  $count = preg_replace ('/[^0-9]/i', '', $_GET['count']);
  if (!$count) $count = 1;
  if (substr ($item, 2, 1) != 'm') put_error ('это не мелкая вещь');
  ////////////////////////////
  function trade_param ($item)
  {
    $item = preg_replace ('/[^a-z0-9\._]/i', '', $item);
    $cl = substr ($item, 2, 1);
    $tp = substr ($item, 4, 3);
    if (!file_exists ('modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php')) put_error ('<p>нету такого файла для создания веши: modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php</p>');
    include ('modules/items/items_'.$cl.'/items_'.$cl.'_'.$tp.'.php');
    if (!isset($it[$item])) put_error ('<p>такой веши нету в файлах: '.$item.'</p>');
    $it[$item] = explode('|', $it[$item]);
    return $it[$item];
  }
  ///////////////////////////
  include_once ('modules/f_real_name.php');
  $rnn = real_name ($npc);
  $file_name = str_replace ('.', '_', $rnn);
  include ('modules/npc/t/t_'.$file_name.'.php');
  if (!is_in ($item, $torg)) put_error ('no such item with trader');
  if ($count > $MAX_MISC) $count = $MAX_MISC;

  // esli hvatit deneg
  $ip = trade_param ($item);
  $tr = do_mysql ("SELECT drop2 FROM npc WHERE id_npc = '".$nid."';");
  $tr = mysql_result ($tr, 0);
  $tr = explode ('|', $tr);
  $cost = round($ip[6] * $count * $tr[1]);
  if ($cost > $p['money']) put_g_error ('у вас недостаточно денег, чтобы купить '.$count.' '.$ip[0].' - надо '.$cost.' серебра');

  // kolichestvo:
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
  $c = mysql_result ($q, 0);
  if ($c > $I_SEP_C)  put_g_error('в рюгзаке нехватает места');

  //---------------------------------
  // teperq proverim estq li takaja veshq v inventare:
  $q = do_mysql ("SELECT fullname, on_take FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND realname = '".$item."';");
  if (!mysql_num_rows ($q))
  {
    include_once ('modules/f_create_item_m.php');
    include_once ('modules/f_add_item_to_pl.php');
    $nitem = create_item_m ($item, $count);
    add_item_to_pl ($LOGIN, $nitem);
  }
  else
  {
    $ii = mysql_fetch_assoc ($q);
    if ($ii['on_take'] + $count > $MAX_MISC) $count = $MAX_MISC - $ii['on_take'];
    do_mysql ("UPDATE items SET on_take = on_take + ".$count." WHERE fullname = '".$ii['fullname']."';");
  }

  // snimem cenu, no pereschitaem tak kak ona menqshe mogla statq
  $cost = round($ip[6] * $count * $tr[1]);
  do_mysql ("UPDATE players SET money = money - ".$cost." WHERE id_player = '".$p['id_player']."';");
  
  $f = gen_header ('торг');
  $f .= '<div class="y" id="oaidy"><b>купля:</b></div><p>';
  $f .= 'вы купили '.$count.' '.$ip[0].' за '.$cost.' серебра!<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$npc.'&start='.$_GET['start'].'&start2='.$_GET['start2'].'">торг</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer ();
  exit ($f);
?>