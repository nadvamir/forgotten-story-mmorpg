<?php
  // chinim veshi
  $f = '';

  if (isset ($_GET['item']))
  {
    $item = preg_replace ('/[^a-z0-9_\.]/i', '', $_GET['item']);
    include_once ('modules/f_repair_item.php');
    $cost = repair_item ($item, $LOGIN);
    $f .= 'вещь починена. Починка стоила '.$cost.' серебра<br/>';
  }

  include 'modules/f_get_damaged_items.php';
  $di = get_damaged_items ($LOGIN);

  if (!is_array ($di)) 
    exit_msg ('починка вещи', $f);

  foreach ($di as $key => $val)
  {
    $q = do_mysql ("SELECT name FROM items WHERE fullname = '".$key."';");
    $name = mysql_result ($q, 0);
    $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=repair&item='.$key.'">'.$name.'</a><br/>';
  }
  exit_msg ('починка вещи', $f);
?>