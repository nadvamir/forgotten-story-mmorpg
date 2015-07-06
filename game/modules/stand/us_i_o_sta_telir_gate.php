<?php
  // vorota zamka telir
  if (!$p['clan'][0]) put_g_error ('безклановым тут делать нечего');
  $q = do_mysql ("SELECT * FROM castle WHERE name = 'telir';");
  $castle = mysql_fetch_assoc ($q);
  if ($p['clan'][0] == $castle['belongs'] || $castle['doorhp'] == 0)
  {
    include_once ('modules/f_teleport.php');
    teleport ($LOGIN, 'telc|3x1');
  }
  else
  {
    $q = do_mysql ("SELECT politics FROM clans WHERE clanname = '".$p['clan'][0]."' AND politics LIKE '%".$clan['belongs']."%|%';");
    if (!mysql_num_rows ($q) && $castle['belongs']) put_g_error ('вход воспрешен!');
    // kto ostalsja mogut napadatq

    include_once ('modules/f_get_dmg.php');
    $dmg = get_dmg ($LOGIN);
    // vyberem sami nomer:
    do 
    {
      $arr = array ('rez', 'kol', 'drob', 'rub');
      if (!$dmg[0][0] && !$dmg[1][0] && !$dmg[2][0] && !$dmg[3][0]) { $num = 4; $type = 'mag'; break; }
      $num = array_rand ($arr);
      $type = $arr[$num];
    }
    while (!$dmg[$num][1]);
    $castle['doorhp'] -= $dmg[$num][1];
    if ($castle['doorhp'] < 0) $castle['doorhp'] = 0;
    do_mysql ("UPDATE castle SET doorhp = '".$castle['doorhp']."' WHERE name = 'Telir';");
    add_journal ('ворота -'.$dmg[$num][1].' ('.$p['name'].') ['.$castle['doorhp'].']', 'l.'.$p['location']);
  }
?>