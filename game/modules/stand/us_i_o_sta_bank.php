<?php
  // sunduk (bank)
  // dve chasti okna, odna otvechaet za sunduk, drugaja za inventarq
  $show = 5;
  $f = gen_header ('игрок');

  // estq li rjadom bank?
  $q = do_mysql ("SELECT name FROM items WHERE fullname = '".$item."' AND location = '".$p['location']."';");
  if (!mysql_num_rows ($q)) put_g_error ('рядом объекта нету');
  else $bname = mysql_result ($q, 0);

  // osnovnaja
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv';");
  $c = mysql_result ($q, 0);
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'ban';");
  $c2 = mysql_result ($q, 0);

  // start
  if (!isset ($_GET['start'])) $start = 0;
  else $start = $_GET['start'];
  if ($start >= $c) $start = $c - $show;
  if ($start < 0) $start = 0;
  $to = $show;
  $i = $start;
  // start 2
  if (!isset ($_GET['start2'])) $start2 = 0;
  else $start2 = $_GET['start2'];
  if ($start2 >= $c2) $start2 = $c2 - $show;
  if ($start2 < 0) $start2 = 0;
  $to2 = $show;
  $i2 = $start2;


  ///////////////////////// SUNDUK ///////////////////////////
  $f .= '<div class="y" id="oai385e"><b>'.$bname.':</b></div><p>';

  // esli estq soobshenie:
  if (isset ($SYSMSG)) $f .= '<b>'.$SYSMSG.'</b><br/>';
  $BIT = array();
  $ci = 0;

  $q = do_mysql ("SELECT id_item, name, fullname, on_take, on_drop, realname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'ban';");
  while ($it = mysql_fetch_assoc ($q))
  {
    //if ($ci > $show) break;
    if (!isset ($BIT[$it['realname']]))
    {
      $q2 = do_mysql ("SELECT COUNT(*) FROM items WHERE realname = '".$it['realname']."' AND belongs = '".$LOGIN."' AND is_in = 'ban';");
      $cb = mysql_result ($q2, 0);
      $BIT[$it['realname']] = $cb;
      $ci++;
    }
    else continue;
    $qua = substr ($it['fullname'], 8, 3);
    $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
    if (strpos ($qlist, $qua) === false) $qua = 'blue';
    $name = $it['name'];
    if (substr ($it['fullname'], 0, 7) == 'i.f.tra' && $p['skills'][6]) $name = $it['on_drop'];
    if (substr ($it['fullname'], 2, 1) == 'm')
    {
      $cmi = $it['on_take'];
      $f .= ($i2 + 1).'. <a class="blue" href="game.php?sid='.$sid.'&action=take_misc_from_bank_c&item='.$it['fullname'].'&bank='.$item.'&start='.$start.'&start2='.$start2.'">';
      $f .= $name.'</a> ';
      $f .= '(<a class="blue" href="game.php?sid='.$sid.'&action=take_misc_from_bank&count=1000&item='.$it['fullname'].'&bank='.$item.'&start='.$start.'&start2='.$start2.'">'.$cmi.'</a>)';
      $f .= ' : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$it['fullname'].'">?</a><br/>';
    }
    else
    {
      $f .= ($i2 + 1).'. <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=take_from_bank&item='.$it['fullname'].'&bank='.$item.'&start='.$start.'&start2='.$start2.'">';
      $f .= $name.'</a> (<a class="'.$qua.'" href="game.php?sid='.$sid.'&action=take_from_bank&item='.$it['fullname'].'&bank='.$item.'&start='.$start.'&start2='.$start2.'&all=1">'.$cb.'</a>) : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$it['fullname'].'">?</a><br/>';
    }
    $i2++;
  }
  // teperq md'shnye ssylki dlja prosmotra
  /*$nw = floor ($c2 / $show);
  for ($i = 0; $i <= $nw; $i++)
  {
    if ($i * 5 == $start2) $f .= ($i + 1).' : ';
    elseif ($i * 5 < $c2) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&start='.$start.'&start2='.($i * $show).'">'.($i + 1).'</a> : ';
  }*/
  $f .= '<span class="gray">('.$c2.')</span>';
  $f .= '</p>';

  ///////////////////////////// INVENTARQ /////////////////////////////
  $f .= '<div class="y" id="oai385e"><b>инвентарь:</b></div><p>';

  include_once ('modules/f_get_pl_weight.php');
  $pw = get_pl_weight ($LOGIN);
  $f .= '<p><small>вес: '.$pw.'/'.$p['carry'].'</small>';
  // sloty
  $f .= '<small>(';
  switch ($p['settings'][5])
  {
    case 1: $f .= '30слот.'; break;
    case 2: $f .= '35слот.'; break;
    case 3: $f .= '40слот.'; break;
    case 4: $f .= '30слот. маг.'; break;
    case 5: $f .= '35слот. маг.'; break;
  }
  $f .= ')</small><br/>';

  $BIT = array();
  $ci = 0;
  $i = $start;
  $q = do_mysql ("SELECT name, fullname, on_take, on_drop, realname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv';");
  while ($it = mysql_fetch_assoc ($q))
  {
    //if ($ci > $show) break;
    if (!isset ($BIT[$it['realname']]))
    {
      $q2 = do_mysql ("SELECT COUNT(*) FROM items WHERE realname = '".$it['realname']."' AND belongs = '".$LOGIN."' AND is_in = 'inv';");
      $cb = mysql_result ($q2, 0);
      $BIT[$it['realname']] = $cb;
      $ci++;
    }
    else continue;
    $qua = substr ($it['fullname'], 8, 3);
    $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
    if (strpos ($qlist, $qua) === false) $qua = 'blue';
    $name = $it['name'];
    if (substr ($it['fullname'], 0, 7) == 'i.f.tra' && $p['skills'][6]) $name = $it['on_drop'];
    if (substr ($it['fullname'], 2, 1) == 'm')
    {
      $cmi = $it['on_take'];
      $f .= ($i + 1).'. <a class="blue" href="game.php?sid='.$sid.'&action=put_misc_to_bank_c&item='.$it['fullname'].'&bank='.$item.'&start='.$start.'&start2='.$start2.'">';
      $f .= $name.'</a> ';
      $f .= '(<a class="blue" href="game.php?sid='.$sid.'&action=put_misc_to_bank&item='.$it['fullname'].'&bank='.$item.'&count=1000&start='.$start.'&start2='.$start2.'">'.$cmi.'</a>)';
      $f .= ' : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$it['fullname'].'">?</a><br/>';
    }
    else
    {
      $f .= ($i + 1).'. <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=put_to_bank&item='.$it['fullname'].'&bank='.$item.'&start='.$start.'&start2='.$start2.'">';
      $f .= $name.'</a> (<a class="'.$qua.'" href="game.php?sid='.$sid.'&action=put_to_bank&item='.$it['fullname'].'&bank='.$item.'&start='.$start.'&start2='.$start2.'&all=1">'.$cb.'</a>) : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$it['fullname'].'">?</a><br/>';
    }
    $i++;
  }
  // teperq md'shnye ssylki dlja prosmotra
  /*$nw = floor ($c / $show);
  for ($i = 0; $i <= $nw; $i++)
  {
    if ($i * 5 == $start) $f .= ($i + 1).' : ';
    elseif ($i * 5 < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=use_stand&item='.$item.'&start2='.$start2.'&start='.($i * $show).'">'.($i + 1).'</a> : ';
  }*/
  $f .= '<span class="gray">('.$c.')</span>';
  $f .= '</p>';

  ////////////////////////////////////////////////////////////////////////////////

  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>