<?php
  // pokaz offlain kontaktov
  $f = gen_header ('друзья оффлайн');
  //////////////////////////////////////////////////////
  // udalenie ls kotorym za 10 minut i chitany
  $dls = "DELETE FROM ls WHERE readed = 'yes' AND senttime < NOW() - INTERVAL '1440' MINUTE;";
  do_mysql ($dls);
  // start
  $show = 25;
  if (isset ($_GET['start'])) $start = preg_replace('/[^0-9]/', '', $_GET['start']);
  else $start = 0;
  // esli starta net on raven 0
  if (empty($start))
  {
    $start = 0;
  }
  ///////////
  $f .= '<div class="y" id="kon8"><b>друзья оффлайн:</b></div>';
  // na etoj strannice tolqko offlain
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
        $off[$num_off] = $con[$i];
        $num_off += 1;
        continue;
      }
    }
    // dokonchim start
    if ($start > $num_off)
    {
      $start = $num_off - $show;
    }
    // menqshe nulja bytq nemozhet
    if ($start < 0)
    {
      $start = 0;
    }
    // vtoroj perebor :(
    for ($i = $start; $i < ($start + $show); $i++)
    {
      if ($i >= $num_off)
          break;
      // ssylka napisatq i udalitq
      $id = is_player ($off[$i]);
      $a = do_mysql("SELECT name FROM players WHERE id_player = '".$id."';");
      if (!mysql_num_rows ($a))
      {
        $p['contacts'] = string_drop ($p['contacts'], $off[$i]);
        do_mysql ("UPDATE players SET contacts = '".$p['contacts']."' WHERE id_player = '".$p['id_player']."';");
        continue;
      }
      $cont = mysql_result($a,0);
      $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=wls&to='.$off[$i].'">';
      $f .= $cont.'</a> (<a class="red" href="game.php?sid='.$sid.'&action=delcontact&to='.$off[$i].'">';
      $f .= 'x</a>)<br/>';
    }
    $f .= '</p>';
  }
  //--
  // listanie
  $f .= '<div class="y" id="s1">';
  if ($start > 0)
  {
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showcontoffline&start='.($start - $show).'">';
    $f .= '&#171;</a>';
  }
  else
  {
    $f .= '&#171;';
  }
  $f .= ' | ';
  if ($num_off > $start + $show)
  {
    $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showcontoffline&start='.($start + $show).'">';
    $f .= '&#187;</a>';
  }
  else
  {
    $f .= '&#187;';
  }
  $f .= '</div>';
  //////////////////////////////////////////////////////
  $f .= '<p>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showcontacts">друзья</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>