<?php
  if ($p['admin'] > 1)
  {
    if (isset ($_GET['loc']))
    {
      include_once ('modules/f_teleport.php');
      $loc = preg_replace ('/[^a-z_0-9\|]/i', '', $_GET['loc']);
      $login = preg_replace ('/[^a-z_0-9]/', '', $_GET['login']);
      if (!$login) $login = $LOGIN;
      teleport ($login, $loc);
    }
    else
    {
      $f = '<form action="game.php" method="get">';
      $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
      $f .= '<input type="hidden" name="action" value="a_teleport"/>';
      $f .= 'login(or nothing):<br/><input type="text" name="login"/><br/>';
      $f .= 'location:<br/><input type="text" name="loc"/>';
      $f .= '<input type="submit" value="teleport!"/>';
      $f .= '</form>';
      exit_msg ('teleport', $f);
    }
  }
?>