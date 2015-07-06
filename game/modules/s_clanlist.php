<?php
  // spisok klanov
  $show = 20;
  $f = gen_header ('кланы');
  $f .= '<div class="y" id="aeifa5f"><b>кланы:</b></div>';
  if (isset ($_GET['clan']))
  {
    $clan = preg_replace ('/[^a-z_0-9]/i', '', $_GET['clan']);
    if (!$clan) put_error ('X_x');
    $q = do_mysql ("SELECT * FROM clans WHERE clanname = '".$clan."';");
    $clan = mysql_fetch_assoc ($q);
    if (!$clan['clanname']) put_error ('X_x');
    $q2 = do_mysql ("SELECT COUNT(*) FROM players WHERE clan LIKE '".$clan['clanname']."%';");
    $c = mysql_result ($q2, 0);
    $f .= '<div class="y" id="aeifa5f"><b>'.$clan['clanname'].'</b></div>';
    $f .= '<div class="n" id="ssad5f">';
    $f .= $c.' игроков в составе<br/>';
    
    $q = do_mysql ("SELECT belongs FROM castle WHERE name = 'telir';");
    $bel = mysql_result ($q, 0);
    if (strtolower($bel) == strtolower($clan['clanname'])) $f .= 'владельцы замка <b>Телир</b><br/>';

    $f .= '<b>'.$clan['money'].'</b> серебра на счету<br/>';
    $f .= 'cайт клана: <a class="red" href="'.$clan['clansite'].'">'.$clan['clansite'].'</a><br/>';
    $f .= 'суть клана: <i>"'.$clan['task'].'"</i><br/>';
    // berem spisok politiki
    $pol = $clan['politics'];
    $f .= '<b>политика:</b><br/>';
    if ($pol == '') $f .= 'нейтралитет<br/>';
    else
    {
      $pol = explode ('|', $pol);
      // voina
      $f .= '<b>война</b><br/>';
      $pol[0] = explode ('~', $pol[0]);
      $c = count ($pol[0]);
      for ($i = 0; $i < $c; $i++) $f .= $pol[0][$i].'<br/>';
      // mir
      $f .= '<b>союз</b><br/>';
      $pol[1] = explode ('~', $pol[1]);
      $c = count ($pol[1]);
      for ($i = 0; $i < $c; $i++) $f .= $pol[1][$i].'<br/>';
    }

    // spisok soklanovcev:
    if (!isset ($_GET['start'])) $start = 0;
    else $start = preg_replace ('/[^0-9]/', '', $_GET['start']);
    if ($start > $c)
    {
      $start = floor ($c / $show);
      $start *= $show;
      if ($start == $c) $start -= $show;
    }
    $f .= '<b>в составе:</b><br/>';
    $q = do_mysql ("SELECT login, clan, name, active FROM players WHERE clan LIKE '".$clan['clanname']."%' ORDER BY clan DESC LIMIT ".$start.", ".$show.";");
    while ($cm = mysql_fetch_assoc ($q))
    {
      $cm['clan'] = explode ('|', $cm['clan']);
      if ($cm['active'] == 1) $f .= '<b>';
      $f .= $cm['clan'][1].': <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$cm['login'].'">'.$cm['name'].'</a><br/>';
      if ($cm['active'] == 1) $f .= '</b>';
    }
    // teperq md'shnye ssylki dlja prosmotra
    $nw = floor ($c / $show);
    for ($i = 0; $i <= $nw; $i++)
    {
      if ($i * $show == $start) $f .= ($i + 1).' : ';
      else if ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=clanlist&start='.($i * $show).'&clan='.$clan['clanname'].'">'.($i + 1).'</a> : ';
    }
    $f .= '<span class="gray">('.$c.')</span>';

    $f .= '<br/>&#171;<a class="blue" href="game.php?sid='.$sid.'&action=clanlist">к списку</a>';
    $f .= '</div>';
  }
  else
  {
    $f .= '<div class="n" id="aclanf">';
    $q = do_mysql ("SELECT * FROM clans ORDER BY money DESC;");
    while ($clan = mysql_fetch_assoc ($q))
    {
      $q2 = do_mysql ("SELECT COUNT(*) FROM players WHERE clan LIKE '".$clan['clanname']."%';");
      $c = mysql_result ($q2, 0);
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=clanlist&clan='.$clan['clanname'].'">'.$clan['clanname'].'</a>: '.$c.' Игр. : '.$clan['money'].' серебра<br/>';
    }
    $f .= '</div>';
  }
  $f .= '<div class="n" id="adi45f">';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=mir_igry">мир игры</a><br />';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'">в игру</a><br />';
  $f .= '</div>';
  $f .= gen_footer ();
  exit ($f);
?>