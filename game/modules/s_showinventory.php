<?php
  // pokazyvaet inventarq
  // i informaciju igroka
  // na vsjakij sluchaj :
  $show = 10;
  include_once ('modules/f_get_it_name.php'); // nazvanie
  $f = gen_header ('игрок');
  // osnovnaja
  $f .= '<div class="y" id="osnovn1">';
  $f .= '<b>основное:</b></div><p>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$LOGIN.'">';
  $f .= 'инфо</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=showskills">';
  $f .= 'навыки</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_quest_log">';
  $f .= 'квесты</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=showkombo">';
  $f .= 'приемы</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_magic">';
  $f .= 'магия</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_bd">';
  $f .= 'быстр. действия</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_hara">';
  $f .= 'характеристика</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=show_equipment">';
  $f .= 'одето</a><br/>';
  if ($p['marry']) $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=marry_menu">вторая половинка</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=mir_igry">';
  $f .= 'мир игры</a><br/>';
  if ($p['clan'][0]) $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'&action=clan_menu">клан</a><br/>';
  //if ($p['stats'][0] < 2 && $p['admin'] < 1) $f .= 'форум<br/>';
  $qco = mysql_query ("SELECT COUNT(*) FROM session;", $dbcnx);
  $on = mysql_result ($qco, 0);
  $f .= 'онлайн: <a class="blue" href="game.php?sid='.$sid.'&action=online">'.$on.'</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=gold">золото</a>:<b> '.$p['gold'].'</b><br/>';
  $f .= '<b>серебро:</b> '.$p['money'].'<br/>';
  $f .= '<b>карма:</b> '.$p['karma'].'<br/>';
  $f .= '<b>гл. квест:</b> '.$p['qlvl'].'</p>';



  //////////////////////// inventarq //////////////////////////////
  $f .= '<div class="y" id="inv5">';
  $f .= '<b>инвентарь:</b></div>';
  include_once ('modules/f_get_pl_weight.php');
  $pw = get_pl_weight ($LOGIN);
  $f .= '<p><small>вес: '.$pw.'/'.$p['carry'].'</small>';
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND weight > 0;");
  $count_all = mysql_result ($q, 0);
  // sloty
  $f .= '<small>('.$count_all.' из ';
  switch ($p['settings'][5])
  {
    case 1: $f .= '30слот.'; break;
    case 2: $f .= '35слот.'; break;
    case 3: $f .= '40слот.'; break;
    case 4: $f .= '35слот. маг.'; break;
    case 5: $f .= '40слот. маг.'; break;
  }
  $f .= ')</small></p>';

  // TABS
  if (!isset ($_GET['type']))
  {
    if ($p['settings'][9] == 1) $type = 6;
    else $type = 1;
  }
  else $type = preg_replace ('/[^0-9]/', '', $_GET['type']);

  if ($type == 1) { $prt = "AND type = 'f'"; $tab = 'сьедобное'; }
  else if ($type == 2) { $prt = "AND (type = 'q' OR type = 'm')"; $tab = 'разное'; }
  else if ($type == 3) { $prt = "AND type = 'w'"; $tab = 'оружие'; }
  else if ($type == 4) { $prt = "AND (type = 'a' OR type = 'x')"; $tab = 'защита'; }
  else if ($type == 5) { $prt = "AND (type = 's' OR type = 'b')"; $tab = 'магия'; }
  else { $prt = ''; $tab = 'все'; }
  $f .= '<div class="p" id="oisdgr"><a class="blue" href="game.php?sid='.$sid.'&action=showinventory&type=1">1</a> - <a class="blue" href="game.php?sid='.$sid.'&action=showinventory&type=2">2</a> - <a class="blue" href="game.php?sid='.$sid.'&action=showinventory&type=3">3</a> - <a class="blue" href="game.php?sid='.$sid.'&action=showinventory&type=4">4</a> - <a class="blue" href="game.php?sid='.$sid.'&action=showinventory&type=5">5</a> - <a class="blue" href="game.php?sid='.$sid.'&action=showinventory&type=6">*</a></div>';
  $f .= '<p><b>'.$tab.'</b>:</p>';

  // estq li lopata
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE realname = 'i.q.que.lopata' AND belongs = '".$LOGIN."' AND is_in = 'inv';");
  $LOPATA = mysql_result ($q, 0);

  $q = do_mysql ("SELECT cOUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' ".$prt.";");
  $c = mysql_result ($q, 0);
  if (!$c) $f .= '<p>пусто</p>';
  else
  {
    $f .= '<p>';
    // pereberem
    // start
    if (!isset ($_GET['start'])) $start = 0;
    else $start = preg_replace ('/[^0-9]/', '', $_GET['start']);
    if ($start >= $c) $start = $c - $show;
    if ($start < 0) $start = 0;
    $to = $start + $show;
    if ($to > $c) $to = $c;
    $i = $start;

    $ita = array(); // massiv kuda budut pisatq veshi kotorye v rjukzake
    $q = do_mysql ("SELECT fullname, name, on_take, on_drop, realname FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' ".$prt." ORDER BY id_item;");
    while ($it = mysql_fetch_assoc ($q))
    {
      if (is_in ($it['realname'], $ita)) continue;
      $ita[] = $it['realname'];
      $qfc = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND realname = '".$it['realname']."';");
      $cmi = mysql_result ($qfc, 0);
      $qua = substr ($it['realname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      $f .= ($i + 1).'. <a class="'.$qua.'" href="game.php?sid='.$sid.'&action=use_item&item='.$it['fullname'].'">';
      $name = $it['name'];
      if (substr ($it['fullname'], 2, 1) == 'm')
      {
        $cmi = $it['on_take'];
        $f .= $name.'</a> ('.$cmi.') : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$it['fullname'].'">?</a>';
        $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=drop_misc1&item='.$it['fullname'].'">></a> : <a class="red" href="game.php?sid='.$sid.'&action=drop_misc2&item='.$it['fullname'].'&count=1000">&#187;</a>';
      }
      elseif (substr ($it['fullname'], 0, 7) == 'i.f.tra' && $p['skills'][6]) // trava
      {
        // mtrava glazami celitelja
        $f .= $it['on_drop'].'</a>['.$it['on_take'].'] ('.$cmi.')';
        $f .= ' : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$it['fullname'].'">?</a>';
        $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=drop_item&item='.$it['fullname'].'">></a>';
        $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=drop_item&item='.$it['fullname'].'&all=1">&#187;</a>';
        $f .= ' : <a class="blue" href="game.php?sid='.$sid.'&action=take_food_to&food='.$it['fullname'].'">^</a>';
      }
      else
      {
        // esli oruzhie i estq mesta na tele, mozhno pustitq povesitq ego na pojas
        $lin = '';
        if (substr ($it['fullname'], 2, 1) == 'w' && !isset ($wst))
          $lin .= ' : <a class="blue"  href="game.php?sid='.$sid.'&action=put_on_belt&weapon='.$it['fullname'].'">^</a>';
        if (substr ($it['fullname'], 2, 1) == 'w' && $p['skills'][41] && strpos ($it['fullname'], '.2h.') === false)
          $lin .= ' : <a class="blue"  href="game.php?sid='.$sid.'&action=take_2w&weapon='.$it['fullname'].'">2</a>';
        $f .= $name.'</a> ('.$cmi.') ';
        $f .= ' : <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$it['fullname'].'">?</a>';
        $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=drop_item&item='.$it['fullname'].'">></a>';
        $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=drop_item&item='.$it['fullname'].'&all=1">&#187;</a>'.$lin;
        if (substr ($it['fullname'], 2, 1) == 'b') $f .= ' : <a class="blue" href="game.php?sid='.$sid.'&action=take_mbook_to&book='.$it['fullname'].'">^</a>';
        if (substr ($it['fullname'], 2, 1) == 'f') $f .= ' : <a class="blue" href="game.php?sid='.$sid.'&action=take_food_to&food='.$it['fullname'].'">^</a>';
      }
      // shoronitq
      if ($LOPATA) $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=dig_item&item='.$it['fullname'].'">V</a>';
      $f .= '<br/>';
      $i++;
    }
    // teperq md'shnye ssylki dlja prosmotra
    /*$nw = floor ($c / $show);
    for ($i = 0; $i <= $nw; $i++)
    {
      if ($i * $show == $start) $f .= ($i + 1).' : ';
      elseif ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showinventory&start='.($i * $show).'&type='.$type.'">'.($i + 1).'</a> : ';
    }*/
    $f .= '<span class="gray">('.$c.')</span>';
    $f .= '</p>';
  }
  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>