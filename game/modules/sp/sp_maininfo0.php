<?php
  // chastq stranicy main
  // statusy
  // EKONOMNAJA VERSIJA
  //////////////////////
  /*// zhiznq mana 
  // esli zhizni malo, to po krasnomu ee
  if ($p['life'][0] * 4 < $p['life'][1])
  {
    $redl1 = '<span class="red">';
    $redl2 = '</span>';
  }
  else
  {
    $redl1 = '';
    $redl2 = '';
  }
  $f .= '<div class="y" id="sadas">';
  $f .= 'HP: '.$redl1.''.$p['life'][0].''.$redl2.' | MP: '.$p['mana'][0].'</div>';*/
  // teperq ssylki
  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'&action=showinventory" accesskey="*">';
  $f .= 'и</a> | <a class="blue" href="game.php?sid='.$sid.'&action=showcontacts" accesskey="0">';
  $f .= 'д</a> | ';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=forum" accesskey="#">ф</a>';
  if (!$p['clan'][0]) $clan = 'not';
  else $clan = $p['clan'][0];
  $qtotth = do_mysql ("SELECT id_chat FROM chat WHERE msgto = '".$LOGIN."' OR msgto = '".$clan."' OR msgfrom = '".$LOGIN."' OR  map <> '' ORDER BY puttime DESC LIMIT 0, 1;");
  if (!mysql_num_rows ($qtotth)) $lastchat = 0;
  else
    $lastchat = mysql_result($qtotth,0);
  if ($p['last'][7] > 1000000000) $p['last'][7] = 0;
  if ($lastchat > $p['last'][7]) $lc = 'red';
  else $lc = 'blue';
  $f .= ' | <a class="'.$lc.'" href="game.php?sid='.$sid.'&action=chat">ч</a>';
  $f .= ' | <a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=maininfo&set=1">+</a>';
  // kolichestvo nechitanyh ls
  $qrl = "SELECT COUNT(*) FROM ls WHERE sentfor = '".$p['id_player']."' AND readed = 'no';";
  $arl = do_mysql($qrl);
  $ls = mysql_result($arl,0);
  if ($ls > 0)
  {
    $f .= ' | лс: ';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">'.$ls.'</a>';
  }
  $f .= '</p>';
?>