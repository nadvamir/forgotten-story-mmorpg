<?php
  // izmenitq zadachu klana:
  if ($p['clan'][0] && $p['clan'][1] > 6)
  {
    // berem spisok politiki
    $q = do_mysql ("SELECT politics FROM clans WHERE clanname = '".$p['clan'][0]."';");
    $pol = mysql_result ($q, 0);

    if (isset ($_GET['sa']))
    {
      $w = preg_replace ('/[^0-1]/', '', $_GET['w']);
      $i = preg_replace ('/[^0-9]/', '', $_GET['i']);
      $poll = explode ('|', $pol);
      if (!isset ($poll[$w])) put_g_error ('че?O_o');
      $poll[$w] = explode ('~', $poll[$w]);
      if (!isset ($poll[$w][$i]) || !$poll[$w][$i]) put_g_error ('че?O_o');
      $clan = $poll[$w][$i];
      $pol = string_drop ($pol, $clan);
      if ($pol == '|') $pol = '';
      do_mysql ("UPDATE clans SET politics = '".$pol."' WHERE clanname = '".$p['clan'][0]."';");
    }
    else if (isset ($_GET['clan']))
    {
      if (is_in ($_GET['clan'], $pol)) put_g_error ('такое имеется...');
      $clan = preg_replace ('/[^a-z_0-9]/i', '', $_GET['clan']);
      $q = do_mysql ("SELECT clanname FROM clans WHERE clanname = '".$clan."';");
      if (!mysql_num_rows ($q)) put_g_error ('несущетвует сей клан');
      $a = preg_replace ('/[^0-1]/', '', $_GET['alianse']);
      if (!$pol)
      {
        if ($a) $pol = '|'.$clan;
        else $pol = $clan.'|';
      }
      else
      {
        $pol = explode ('|', $pol);
        if ($pol[$a]) $pol[$a] .= '~'.$clan;
        else $pol[$a] = $clan;
        $pol = $pol[0].'|'.$pol[1];
      }
      do_mysql ("UPDATE clans SET politics = '".$pol."' WHERE clanname = '".$p['clan'][0]."';");
      if (!$a)
      {
        // soobshim o voine:
        $q = do_mysql ("SELECT login FROM players WHERE clan LIKE '".$clan."%' OR clan LIKE '".$p['clan'][0]."%';");
        $to = '';
        while ($tmp = mysql_fetch_assoc ($q)) $to .= $tmp['login'].'|';
        add_journal ('[green][clan]'.$p['clan'][0].' обьявил войну '.$clan.'!!![/end]', $to);
      }
    }

    $f = '<b>политика:</b><br/>';
    if ($pol == '') $f .= 'нейтралитет<br/>';
    else
    {
      $pol = explode ('|', $pol);
      // voina
      $f .= '<b>война</b><br/>';
      $pol[0] = explode ('~', $pol[0]);
      $c = count ($pol[0]);
      for ($i = 0; $i < $c; $i++) $f .= '<a class="red" href="game.php?sid='.$sid.'&action=change_clan_politics&sa=change&w=0&i='.$i.'">-</a> '.$pol[0][$i].'<br/>';
      // mir
      $f .= '<b>союз</b><br/>';
      $pol[1] = explode ('~', $pol[1]);
      $c = count ($pol[1]);
      for ($i = 0; $i < $c; $i++) $f .= '<a class="red" href="game.php?sid='.$sid.'&action=change_clan_politics&sa=change&w=1&i='.$i.'">-</a> '.$pol[1][$i].'<br/>';
    }

    // vrag ili alijans
    $f .= '<form action="game.php" method="get">';
    $f .= '<input type="hidden" name="sid" value="'.$sid.'"/>';
    $f .= '<input type="hidden" name="action" value="change_clan_politics"/>';
    $f .= 'клан:<br/><input type="text" name="clan"/><br/>';
    $f .= '<select name="alianse"><option value="1">союз!</option><option value="0">на кол!</option></select><br/>';
    $f .= '<input type="submit" value="записать!"/>';
    exit_msg ('политика', $f);
  }
?>