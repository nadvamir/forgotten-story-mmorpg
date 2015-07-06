<?php
//stime();
  // statusy
  $f .= '<div class="y" id="status"><b>состояние:</b></div><p>';

  // voina
  if ($p['clan'][0])
  {
    $q = do_mysql ("SELECT clanname FROM clans WHERE politics LIKE '%".$p['clan'][0]."%|%';");
    if (mysql_num_rows ($q)) $f .= '<b>вы в войне!</b><br/>';
  }

  $pl_map = substr ($p['location'], 0, 4);
  $wea = do_mysql ("SELECT weather FROM maps WHERE map = '".$pl_map."';");
  $wea = mysql_result ($wea, 0);
  if ($loc[0][6] != 1)
  {
    switch ($wea)
    {
      case 0: $f .= 'сухой мороз<br/>'; break;
      case 0.5: $f .= 'морозик<br/>'; break;
      case 1: $f .= 'падает снег<br/>'; break;
      case 2: $f .= 'идет дождь<br/>'; break;
      case 3: $f .= 'туман<br/>'; break;
      case 4: $f .= 'ветренно<br/>'; break;
      case 5: $f .= 'тихая погода<br/>'; break;
      case 6: $f .= 'жара<br/>'; break;
    }
  }
  switch ($p['status1'][0])
  {
    case 0: break;
    case 1: $f .= '<b>вы преступник!<br/></b>'; break;
    case 2: $f .= '<b>вы убийца!</b><br/>'; break;
  }
  switch ($p['status1'][1])
  {
    case 0: $f .= 'вам холодно<br/>'; break;
    case 1: break;
    case 2: $f .= 'вам жарко!<br/>'; break;
  }
  if ($p['status1'][2] == 1) $f .= 'у вас кровотечение!<br/>';
  if ($p['status1'][3] == 1) $f .= 'вы отравлены!<br/>';
  if ($p['status1'][4] == 1) $f .= 'вы горите!<br/>';
  // GLAVE KLANA I ZAMAM:
  if ($p['clan'][0] && $p['clan'][1] > 5)
  {
    $q = do_mysql ("SELECT newcomers FROM clans WHERE clanname = '".$p['clan'][0]."';");
    $ncm = mysql_result ($q, 0);
    if ($ncm) $f .= '<small>получены новые заявки на вступление в клан!</small><br/>';
  }

  if ($p['marry'])
    include 'modules/sp/sp_marry.php';

  // ostolqnye effekty:
  $pl_eff = get_affected ($LOGIN);
  if ($pl_eff)
  {
    $pl_eff = implode ('|', $pl_eff);
    include_once ('modules/f_translit.php');
    $pl_eff = translit ($pl_eff);
    $pl_eff = str_replace ('|', '<br/>', $pl_eff);
    $f .= $pl_eff;
  }
  $f .= '</p></div>';
  // ssylka izmenitq na chat mode i nazvanie loki
  // esli estq opisanie, to vyyvedem ssylku na nego
  $lcd = str_replace ('|', '_', $loc[0][0]);
  $need2show = false;
  if (file_exists ('modules/loc_desc/'.$lcd.'.php'))
  {
    $need2show = true;
    $link1 = '<a class="blue" href="game.php?sid='.$sid.'&action=locinfo">';
    $link2 = '</a>';
  }
  else
  {
    $link1 = '';
    $link2 = '';
  }
//etime ('sostojanie');
  ///////////////////////////////////////////////////////////////
  // BD:
//stime();
  if ($p['settings'][8])
    include 'modules/sp/sp_bd.php';
//etime('bd');
  ///////////////////////////////////////////////////////////////
//stime();
  // esli vedetsja bitva to podkljuchim okno bitv
  if ($p['in_battle'] == 1 || $p['in_battle'] == 2) include 'modules/sp/sp_battle_window.php';
//etime ('battle');
//stime();
  ///////////////////////////////////////////////////////////////
  $a = '<a class="blue" href="game.php?sid='.$sid.'&action=minimap">?</a>';

  $f .= '<div class="y" id="locname">';
  $f .= '<a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=pgmode&set=0">-</a>';
  $f .= '<b>'.$link1.''.$loc[0][1].''.$link2.'</b> : '.$a.'</div><p>';

  ///////////////////////////////////////////////////////////////
  // INLOC //////////////////////////////////////////////////////
  $show = 1000;
  $c = 0;
  $cc = count ($INL_P);
  $cc--;
  if ($cc) include 'modules/sp/sp_inl_p.php';
  $c += $cc;

  $cc = count ($INL_N);
  $cc--;
  if ($cc) include 'modules/sp/sp_inl_n.php';
  $c += $cc;

  $cc = count ($INL_I);
  $cc--;
  $showed = array();
  if ($cc) include 'modules/sp/sp_inl_i.php';
  $c += count ($showed);

  $cc = count ($INL_D);
  $cc--;
  if ($cc) include 'modules/sp/sp_inl_d.php';
  $c += $cc;
//etime('inloc show');
  if ($c < 0) $c = 0;

  $nw = floor ($c / $show);
  for ($i = 0; $i <= $nw; $i++)
  {
    if ($i * $show == $start) $f .= ($i + 1).' : ';
    elseif ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&start='.($i * $show).'">'.($i + 1).'</a> : ';
  }
  $f .= '<span class="gray">('.$c.')</span>';
  $f .= '</p>';

//stime();
  //////////////////////////////////////////////////////////////////
  // posle inloc idut perehody
  // tut razvetvlenie, snachala sdelaem chtoby polnostqju perehody pokazali, potom chastichno (tolqko storony)
  if ($p['settings'][2] == 1) $f .= '<div class="y" id="path"><a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=locmode&set=0">-</a>';
  else $f .= '<div class="y" id="path"><a class="red" href="game.php?sid='.$sid.'&action=mod_settings&change=locmode&set=1">+</a>';
  $f .= '<b>путь:</b></div><p>';

  // pereberem vse vozmozhnye
  include_once ('modules/f_get_loc.php');
  $stl = strlen ($loc[0][4]);
  for ($i = 0; $i < $stl; $i++)
  {
    $ac = $loc[0][4][$i];
    if ($ac > 4) $ac++;
    // proverka, estq li tam ktoto
    $cinl = do_mysql ("SELECT COUNT(*) FROM players WHERE location = '".$loc[$loc[0][4][$i]][0]."' AND active = '1' AND hidden = '0';");
    $cinl = mysql_result ($cinl, 0);
    $cinl2 = do_mysql ("SELECT COUNT(*) FROM npc WHERE location = '".$loc[$loc[0][4][$i]][0]."' AND hidden = '0';");
    $cinl2 = mysql_result ($cinl2, 0);
    unset ($color);
    if (!$cinl && !$cinl2) $color = 'blue';
    else
    {
      if (substr ($p['weapon'], 4, 3) == 'bow' || substr ($p['weapon'], 4, 3) == 'arb') $ARCHER = 1;
      else $ARCHER = 0;
      $color = 'red';
    }
    // storona perehoda
    if ($p['settings'][6] == 1)
    {
      $in = substr ($color, 0, 1);
      switch ($loc[0][4][$i])
      {
        case 1: $st = '<img src="smile/'.$in.'1.png" alt="."/>'; break;
        case 2: $st = '<img src="smile/'.$in.'2.png" alt="."/>'; break;
        case 3: $st = '<img src="smile/'.$in.'3.png" alt="."/>'; break;
        case 4: $st = '<img src="smile/'.$in.'4.png" alt="."/>'; break;
        case 5: $st = '<img src="smile/'.$in.'5.png" alt="."/>'; break;
        case 6: $st = '<img src="smile/'.$in.'6.png" alt="."/>'; break;
        case 7: $st = '<img src="smile/'.$in.'7.png" alt="."/>'; break;
        case 8: $st = '<img src="smile/'.$in.'8.png" alt="."/>'; break;
      }
    }
    else
    {
      switch ($loc[0][4][$i])
      {
        case 1: $st = 'сз'; break;
        case 2: $st = 'с'; break;
        case 3: $st = 'св'; break;
        case 4: $st = 'з'; break;
        case 5: $st = 'в'; break;
        case 6: $st = 'юз'; break;
        case 7: $st = 'ю'; break;
        case 8: $st = 'юв'; break;
      }
    }
    if ($p['settings'][2] == 2) $f .= '['.$st.']';
    else
    {
      $f .= '<a class="'.$color.'" href="game.php?sid='.$sid.'&action=go_to_loc&loc_go='.$loc[$loc[0][4][$i]][0].'&stor='.$loc[0][4][$i].'" accesskey="'.$ac.'">';
      $f .= $st.'</a>';
    }
    if ($p['settings'][2] > 0)
    {
      if ($p['settings'][2] == 2)
      {
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=go_to_loc&loc_go='.$loc[$loc[0][4][$i]][0].'&stor='.$loc[0][4][$i].'" accesskey="'.$ac.'">'.$loc[$loc[0][4][$i]][2].'</a>';
        if ($color == 'red') $f .= ' <b>!</b>';
      }
      else $f .= ' - '.$loc[$loc[0][4][$i]][2];

      // esli mozhno letatq ili prygatq, ili verhom, to togda pokazhem ssylku vpered
      if ($p['walking'] > 0)
      {
        $loc2go = get_loc ($LOGIN, $loc[0][4][$i], 2);
        if ($loc2go) $f .= ' <a class="blue" href="game.php?sid='.$sid.'&action=go_to_loc&loc_go='.$loc2go.'&stor='.$loc[0][4][$i].'&jump=1">*</a>';
      }

      $f .= '<br/>';
      if ($color == 'red' && $ARCHER)
      {
        $f .= '<small>';
        $q = do_mysql ("SELECT login FROM players WHERE location = '".$loc[$loc[0][4][$i]][0]."' AND active = '1' AND hidden = '0';");
        while ($pla = mysql_fetch_assoc ($q))
        {
          $f .= '>'.$pla['login'];
          $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=attack&to='.$pla['login'].'&near='.$loc[$loc[0][4][$i]][0].'">x</a><br/>';
        }
        $q = do_mysql ("SELECT fullname, name FROM npc WHERE location = '".$loc[$loc[0][4][$i]][0]."' AND type != 's' AND type != 't' AND hidden = '0';");
        while ($pla = mysql_fetch_assoc ($q))
        {
          $f .= '>'.$pla['name'];
          $f .= ' : <a class="red" href="game.php?sid='.$sid.'&action=attack&to='.$pla['fullname'].'&near='.$loc[$loc[0][4][$i]][0].'">x</a><br/>';
        }
        $f .= '</small>';
      }
    }
    elseif ($p['settings'][2] == 0)
    {
      // esli mozhno letatq ili prygatq, ili verhom, to togda pokazhem ssylku vpered
      if ($p['walking'] > 0)
      {
        $loc2go = get_loc ($LOGIN, $loc[0][4][$i], 2);
        if ($loc2go) $f .= ' <a class="blue" href="game.php?sid='.$sid.'&action=go_to_loc&loc_go='.$loc2go.'&stor='.$loc[0][4][$i].'&jump=1">*</a>';
      }

      $f .= ' | ';
    }
  }
//etime ('perehody');
  // adminka
  if ($p['admin'] > 1) $f .= '&#187;<a class="red" href="game.php?sid='.$sid.'&action=admin">админка</a><br/>';
  // ssylka osmotretsja
  if ($need2show)
    $f .= '»<a class="blue" href="game.php?sid='.$sid.'&action=locinfo">осмотреться</a><br/>';
  $f .= '&#187;<a class="blue" href="game.php?sid='.$sid.'" accesskey="5">обновить</a></p>';
?>