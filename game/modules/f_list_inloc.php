<?php
  // funkcija vybora celi: (action zapishet v aktion, vyborka - to
  function list_inloc ($pl, $action, $s = 0)
  {
    global $sid;
    global $LOGIN;
    global $p;
    //$pl = preg_replace ('/[^a-z0-9_]/i', '', $pl);
    $action = preg_replace ('/[^a-z0-9_&=\.]/i', '', $action);
    
    $loc = $p['location'];
    // snachala igrokov: vyvedem
    $q = do_mysql ("SELECT login, life, name FROM players WHERE location = '".$loc."' AND active = '1' AND id_player <> '".$p['id_player']."' AND hidden = '0';");
    $inl = '<a class="blue" href="game.php?sid='.$sid.'&action='.$action.'&to='.$LOGIN.'">на себя</a><br/>';
    while ($pp = mysql_fetch_assoc ($q))
    {
      $pp['life'] = explode ('|', $pp['life']);
      $inl .= '<a class="blue" href="game.php?sid='.$sid.'&action='.$action.'&to='.$pp['login'].'">';
      $inl .= $pp['name'].'</a>['.(round($pp['life'][0] / $pp['life'][1] * 100)).'%]<br/>';
    }
    $q = do_mysql ("SELECT name, fullname, life, type FROM npc WHERE location = '".$loc."' AND (hidden = '0' OR hidden = '');");
    while ($n = mysql_fetch_assoc ($q))
    {
      if (!$s)
      {
        // znachit nelzja piokazyvatq govorjashih npc i torgovcev:
        if ($n['type'] == 's' || $n['type'] == 't') continue;
      }
      $n['life'] = explode ('|', $n['life']);
      $inl .= '<a class="blue" href="game.php?sid='.$sid.'&action='.$action.'&to='.$n['fullname'].'">';
      $inl .= $n['name'].'</a>['.(round($n['life'][0] / $n['life'][1] * 100)).'%]<br/>';
    }
    return $inl;
  }
?>