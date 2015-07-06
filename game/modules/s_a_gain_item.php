<?php
  if ($p['admin'] > 1)
  {
    if (isset ($_GET['item']))
    {
      $item = mysql_real_escape_string ($_GET['item']);
      $count = preg_replace ('/[^0-9]/', '', $_GET['count']);
      $login = preg_replace ('/[^a-z_0-9]/', '', $_GET['login']);
      if (!$login) $login = $LOGIN;
      if (!$count) $count = 1;
      include_once ('modules/f_gain_item.php');
      gain_item ($item, $count, $login);
    }
    else
    {
      $f = '<form action="game.php" method="get">';
      $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
      $f .= '<input type="hidden" name="action" value="a_gain_item"/>';
      $f .= 'login(or nothing):<br/><input type="text" name="login"/>';
      $f .= '<br/>item:<br/><input type="text" name="item"/>';
      $f .= '<br/>count:<br/><input type="text" name="count"/>';
      $f .= '<input type="submit" value="get it!"/>';
      $f .= '</form>';
      exit_msg ('get item', $f);
    }
  }
?>