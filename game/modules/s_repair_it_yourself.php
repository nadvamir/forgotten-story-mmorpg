<?php
  // chinim veshi
  if (!$p['skills'][34]) put_g_error ('нету навыка');
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE  realname = 'i.o.sta.nakovalqnja';");
  $c = mysql_result ($q, 0);
  if (!$c) put_g_error ('где ковать?');

  $f = '';

  if (isset ($_GET['item']))
  {
    $item = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['item']);
    include_once ('modules/f_repair_item.php');
    $cost = repair_item ($item, $LOGIN, $p['skills'][34]);
    $f .= 'вещь починена на '.$cost.' единиц<br/>';
  }

  include 'modules/f_get_damaged_items.php';
  $di = get_damaged_items ($LOGIN);

  if (!is_array ($di)) 
    exit_msg ('починка вещи', $f);

  foreach ($di as $key => $val)
  {
    $q = do_mysql ("SELECT name FROM items WHERE fullname = '".$key."';");
    $name = mysql_result ($q, 0);
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=repair_it_yourself&item='.$key.'">'.$name.'</a><br/>';
  }
  exit_msg ('починка вещи', $f);
?>