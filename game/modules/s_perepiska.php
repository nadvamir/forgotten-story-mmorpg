<?php
  // pokaz kontaktov
  $f = gen_header ('переписка');
  //////////////////////////////////////////////////////
  // start
  $show = 10;
  if (!isset ($_GET['start'])) $start = 0;
  else $start = preg_replace('/[^0-9]/', '', $_GET['start']);
  // s kem perepiska
  $to = preg_replace('/[^0-9]/', '', $_GET['to']);
  //---------------------------------------------------------------
  // esli nado ochistitq, ochistim
  if (isset ($_GET['subaction']) && $_GET['subaction'] == 'clear')
    do_mysql ("DELETE FROM ls WHERE (sentfor = '".$p['id_player']."' AND sender = '".$to."') OR (sender = '".$p['id_player']."' AND sentfor = '".$to."');");
  // qtotp zaprashivaem kolichestvo ls
  $qtotp = do_mysql("SELECT COUNT(*) FROM ls WHERE (sentfor = '".$p['id_player']."' AND sender = '".$to."') OR (sender = '".$p['id_player']."' AND sentfor = '".$to."');");
  // totp poluchjaem kolichestvo tem
  $totp = mysql_result($qtotp,0);
  if ($start > $totp)
  {
    $start = $totp - $show;
  }
  // menqshe nulja bytq nemozhet
  if ($start < 0)
  {
    $start = 0;
  }
  //--
  // kolichestvo nechitanyh ls
  $qrl = "SELECT COUNT(*) FROM ls WHERE sentfor = '".$p['id_player']."' AND sender <> '".$to."' AND readed = 'no';";
  $arl = do_mysql($qrl);
  $ls = mysql_result($arl,0);
  if ($ls > 0)
  {
    $f .= 'нов. сообщений: ';
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">'.$ls.'</a><br/>';
  }

  $f .= '<div class="y" id="ls"><b>';
  $f .= 'переписка: ('.$start.'-'.($start+$show).'/'.$totp.')</b></div>';
  if (isset ($ADDED_MSG)) $f .= '<p><b>сообщение отослано!</b></p>';
  //--
  // imena drugogo
  $a = do_mysql("SELECT login FROM players WHERE id_player = '".$to."';");
  $sender = mysql_result($a,0);
  $a = do_mysql("SELECT name FROM players WHERE id_player = '".$to."';");
  $sendern = mysql_result($a,0);


  // vyvod
  $qls = "SELECT * FROM ls WHERE (sentfor = '".$p['id_player']."' AND sender = '".$to."') OR (sender = '".$p['id_player']."' AND sentfor = '".$to."') ORDER BY senttime DESC LIMIT ".$start.", ".$show.";";
  $als = do_mysql ($qls);
  // vyvedem
  while ($ls = mysql_fetch_assoc($als))
  {
    // zapros na imja slavshego
    if ($ls['sender'] != $p['id_player'])
    {
      $l = $sender; $n = $sendern;
      $cl = 'bas';
    }
    else
    {
      $l = $p['login']; $n = $p['name'];
      $cl = 'mine';
    }
    $f .= '<p>';
    $f .=  '<b>'.$n.'</b>: '.$ls['senttime'].'<br/>';
    $fr = fopen ('modules/ls/ls_'.$ls['id_ls'].'.txt', 'r');
    $txt = fread ($fr, filesize('modules/ls/ls_'.$ls['id_ls'].'.txt'));
    fclose ($fr);
    $f .= '<span class="'.$cl.'">'.$txt.'</span><br/>';
    // reply
    if ($cl == 'bas')
    {
      $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=wls&to='.$sender.'&p=1">';
      $f .= 'ответить</a>';
      // izmenim read na yes
      $cr = "UPDATE ls SET readed = 'yes' WHERE id_ls = '".$ls['id_ls']."';";
      do_mysql ($cr);
    }
    $f .= '</p>';
    //--
  }
  //--
  // listanie
  $f .= '<div class="y" id="s1">';
  if ($start > 0)
  {
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=perepiska&to='.$to.'&start='.($start - $show).'">';
    $f .= '&#171;</a>';
  }
  else
  {
    $f .= '&#171;';
  }
  $f .= ' | ';
  if ($totp > $start + $show)
  {
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=perepiska&to='.$to.'&start='.($start + $show).'">';
    $f .= '&#187;</a>';
  }
  else
  {
    $f .= '&#187;';
  }
  $f .= ' <a class="blue" href="game.php?sid='.$sid.'&action=perepiska&to='.$to.'&start='.$start.'">обновить</a>';
  $f .= ' | <a class="blue" href="game.php?sid='.$sid.'&action=perepiska&to='.$to.'&start='.$start.'&subaction=clear">очистить</a>';
  $f .= '</div>';
  //////////////////////////////////////////////////////
  $f .= '<div class="y" id="kon8"><b>друзья:</b></div>';
  // na etoj strannice tolqko onlain druzqja i chislo offlain
  if (!$p['contacts']) $f .= '<p>ваши контакты пусты!</p>';
  else
  {
    // o chuchutq pereberem vseh
    $f .= '<p>';
    $con = explode ('|', $p['contacts']);
    $c = count ($con);
    $num_off = 0; // flag
    for ($i = 0; $i < $c; $i++)
    {
      // pustyh gljukov nenado
      if (!$con[$i]) continue;
      // zapros na online
      $on = do_mysql ("SELECT sid FROM session WHERE login = '".$con[$i]."';");
      if (!mysql_num_rows($on))
      {
        $num_off += 1;
        continue;
      }
      // kolq prodolzhaetsja chel onlain
      // ssylka napisatq i udalitq
      $id = is_player ($con[$i]);
      $a = do_mysql("SELECT name FROM players WHERE id_player = '".$id."';");
      $cont = mysql_result($a,0);
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=wls&to='.$con[$i].'&p=1">';
      $f .= $cont.'</a> (<a class="red" href="game.php?sid='.$sid.'&action=delcontact&to='.$con[$i].'">';
      $f .= 'x</a>)<br/>';
    }
    $f .= '</p>';
  }
  // esli estq offlajn to pokazhem
  if (isset($num_off))
  {
    $f .= '<div class="y" id="agio3"><b>оффлайн</b>:</div>';
    $f .= '<p>оффлайн: <a class="blue" href="game.php?sid='.$sid.'&action=showcontoffline">';
    $f .= $num_off.'</a></p>';
  }
  $f .= '<p>';
  //if ($p['stats'][0] < 2 && $p['admin'] < 1) $f .= 'форум<br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">вернутся</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=forum">форум</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>