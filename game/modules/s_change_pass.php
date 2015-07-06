<?php
  if (isset ($_GET['pass']))
  {
    $pass = preg_replace('/[^a-z0-9]/i', '', $_GET['pass']);
    $pass2 = $_GET['pass2'];
    $old_pass = preg_replace('/[^a-z0-9]/i', '', $_GET['old_pass']);
    if ($pass !== $pass2) put_g_error ('пароли не совпадают либо вы используете запрещеные символы в них. a-Z0-9 и все ;)');
    $pass = md5 ($pass);
    $old_pass = md5 ($old_pass);
    $q = do_mysql ("SELECT email FROM players WHERE id_player = '".$p['id_player']."' AND pass = '".$old_pass."';");
    if (!mysql_num_rows ($q)) put_g_error ('пароль не верен!');
    // menjaem - 
    do_mysql ("UPDATE players SET pass = '".$pass."' WHERE id_player = '".$p['id_player']."';");
    do_mysql ("DELETE FROM session WHERE login = '".$LOGIN."';");
    $f = gen_header ('смена пароля');
    $f .= '<div class="y" id="yyy"><b>вы сменили!</b></div><div class="n">';
    $f .= 'Поздравляю! А теперь идите входите заного, раз уж сменили...<br/><a class="blue" href="index.php">главная</a></div>';
    $f .= gen_footer();
    exit ($f);
  }
  else
  {
    $f = '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="change_pass"/>';
    $f .= 'старый пароль:<br/><input type="password" name="old_pass"/><br/>';
    $f .= 'новый пароль:<br/><input type="password" name="pass"/><br/>';
    $f .= 'еще раз:<br/><input type="password" name="pass2"/><br/>';
    $f .= '<input type="submit" value="сменить"/>';
    $f .= '</form>';
    exit_msg ('пароли', $f);
  }
?>