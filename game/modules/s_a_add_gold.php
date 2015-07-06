<?php
  if ($p['admin'] > 1)
  {
    $f = '';
    if (isset ($_GET['login']))
    {
      $wmz = preg_replace ('/[^0-9]/', '', $_GET['wmz']);
      $id = is_player ($_GET['login']);
      if (!$id) put_g_error ('bad login');
      do_mysql ("UPDATE players SET gold = gold + ".($wmz * 10)." WHERE id_player = '".$id."';");
      $f .= '<b>added '.$wmz.'wmz eqv. to '.$id.' </b><br/>';
    }

    $f .= '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="a_add_gold"/>';
    $f .= 'login:<br/><input type="text" name="login"/><br/>';
    $f .= 'wmz payed:<br/><input type="text" name="wmz"/><br/>';
    $f .= '<input type="submit" value="add!"/>';
    $f .= '</form>';
    exit_msg ('add_gold', $f);
  }
?>