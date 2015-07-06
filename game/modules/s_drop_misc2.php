<?php
  // brositq melkuju veshq v lokaciju:
  // dlja etogo prosto peremestim iz inventarja v lokaciju esli kidaetsja vse, ili zhe sozdadim novuju, esli ne vse:
  $item = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['item']);
  $count = preg_replace ('/[^0-9]/', '', $_GET['count']);
  $q = do_mysql ("SELECT on_take FROM items WHERE belongs = '".$LOGIN."' AND fullname = '".$item."' AND is_in <> 'ban';");
  if (!mysql_num_rows ($q)) put_g_error ('у вас нету этой вещи!');
  $count_i = mysql_result ($q, 0);
  if ($count > $count_i) $count = $count_i;
  if (!$count) $count = 1;
  $iq = do_mysql ("SELECT name FROM items WHERE fullname = '".$item."';");
  $itname = mysql_result ($iq, 0);

  include_once ('modules/f_add_item_to_loc.php');
  // esli kidaetsja vse:
  if ($count == $count_i)
  {
    add_item_to_loc ($p['location'], $item);
  }
  else
  {
    include_once ('modules/f_decrease_misc.php');
    include_once ('modules/f_create_item_m.php');
    include_once ('modules/f_real_name.php');
    $rn = real_name ($item);
    $nitem = create_item_m ($rn, $count);
    decrease_misc ($item, $count);
    add_item_to_loc ($p['location'], $nitem);
  }

  if ($p['gender'] == 'male')
  {
    $vz = 'бросил';
  }
  else
  {
    $vz = 'бросила';
  }
  add_journal ('<p>'.$p['name'].' '.$vz.' '.$itname.' ('.$count.')</p>', 'l.'.$p['location']);
  $NO_CONTINUE = 1;
  include 'modules/s_journal.php';
?>