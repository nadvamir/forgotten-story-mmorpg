<?php
  if ($p['admin'] > 1)
  {
    if (isset ($_GET['letter']))
    {
      $login = preg_replace ('/[^a-z0-9_]/i', '', $_GET['login']);
      $letter = preg_replace ('/[^абвгдеёжзийклмнопрстуфхцчшщьыъэюяa-z0-9_\.]/i', '', $_GET['letter']);
      $id = is_player ($login);
      do_mysql ("UPDATE anketa SET letter = '".$letter."' WHERE id_player = '".$id."';");
      exit_msg ('letters', 'you have just set '.$login.' letter as '.$letter);
    }
    else
    {
      $f = '<form action="game.php" method="get">';
      $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
      $f .= '<input type="hidden" name="action" value="a_letter"/>';
      $f .= 'login:<br/><input type="text" name="login"/>';
      $f .= '<br/>letter:<br/><input type="text" name="letter"/>';
      $f .= '<input type="submit" value="add it!"/>';
      $f .= '</form>';
      exit_msg ('letters', $f);
    }
  }
?>