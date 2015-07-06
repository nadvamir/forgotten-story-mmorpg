<?php
  if ($p['admin'] > 1)
  {
    if (isset ($_GET['clan_name']))
    {
      $clan_name = preg_replace ('/[^a-z0-9_]/i', '', $_GET['clan_name']);
      $clan_lord = preg_replace ('/[^a-z0-9_]/i', '', $_GET['clan_lord']);
      $id = is_player ($clan_lord);
      $q = do_mysql ("SELECT stats, clan FROM players WHERE id_player = '".$id."';");
      if (!mysql_num_rows ($q)) put_g_error ('Lord you specified just does not exist.');
      $lord = mysql_fetch_assoc ($q);
      $stats = explode ('|', $lord['stats']);
      if ($stats[0] < 7) put_g_error ('that lord is not noble enough to be a Clan Lord. He could be a baker.'); 
      if (strlen ($clan_name) < 3) put_g_error ('clan name should be at least 3 characters. Game does not support chinease clan names');
      if ($lord['clan']) put_g_error ('this Lord already belongs to some clan.');
      $q = do_mysql ("SELECT money FROM clans WHERE clanname LIKE '".$clan_name."';");
      if (mysql_num_rows ($q)) put_g_error ('there is another clan with similar name');
      do_mysql ("INSERT INTO clans VALUES ('".$clan_name."', '0', '', '', '', '', '', '', '', '', '', '', '');");
      do_mysql ("UPDATE players SET clan = '".$clan_name."|7' WHERE id_player = '".$id."';");
      exit_msg ('Creating clan', 'you have just created the clan for '.$clan_lord);
    }
    else
    {
      $f = '<form action="game.php" method="get">';
      $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
      $f .= '<input type="hidden" name="action" value="a_create_clan"/>';
      $f .= 'clan name:<br/><input type="text" name="clan_name"/>';
      $f .= '<br/>clan_lord:<br/><input type="text" name="clan_lord"/>';
      $f .= '<input type="submit" value="create it!"/>';
      $f .= '</form>';
      exit_msg ('create clan', $f);
    }
  }
?>