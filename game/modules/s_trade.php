<?php
  // fail torgovli
  // imja veshi
  include_once ('modules/f_trade_param.php');
  ///////////////////////////////////////
  // npc
  $npc = preg_replace ('/[^a-z0-9:\._]/i', '', $_GET['npc']);
  $nid = is_npc ($npc);
  include_once ('modules/f_real_name.php');
  $rn = real_name ($npc);
  $file_name = str_replace ('.', '_', $rn);
  if (!file_exists ('modules/npc/t/t_'.$file_name.'.php')) put_g_error ('no trade file');
  include ('modules/npc/t/t_'.$file_name.'.php');
  $tr = do_mysql ("SELECT name, drop2, location FROM npc WHERE id_npc = '".$nid."';");
  $tr = mysql_fetch_assoc ($tr);
  if ($tr['location'] != $p['location']) put_g_error ('рядом твкого нету');
  $trade = explode ('|', $tr['drop2']);
  ///////////////////////////////////////
  $show = 15;
  $f = gen_header ('торг');
  // osnovnaja
  if ($trade[0] == '*') $trade[0] = '%';
  $q = do_mysql ("SELECT COUNT(*) FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND type LIKE '".$trade[0]."';");
  $c = mysql_result ($q, 0);
  $c2 = count ($torg);
  // start
  if (!isset ($_GET['start'])) $start = 0;
  else $start = $_GET['start'];
  if ($start >= $c) $start = $c - $show;
  if ($start < 0) $start = 0;
  // start 2
  if (!isset ($_GET['start2'])) $start2 = 0;
  else $start2 = $_GET['start2'];
  if ($start2 >= $c2) $start2 = $c2 - $show;
  if ($start2 < 3) $start2 = 0;
  // sunduk
  $f .= '<div class="y" id="osnovn1">';
  $f .= '<b>торговец:</b></div><p>';
  if (!$c2) $f .= '<p>пусто</p>';
  else
  {
    for ($i = $start2; $i < $start2 + $show; $i++)
    {
      if (!isset ($torg[$i])) continue;
      $pos = strpos ($torg[$i], ':');
      $it = $torg[$i];
      if ($pos !== false)
      {
        $numb = substr ($torg[$i], 0, $pos);
        $torg[$i] = substr ($torg[$i], ($pos + 1));
      }
      // nomer veshi
      if (!isset($torg[$i])) continue;
      if (!$torg[$i]) continue;
      $param = trade_param($torg[$i]);
      $name = $param[0];
      $cost = round ($param[6] * $trade[1]);
      if (isset ($numb)) $cost *= $numb;
      if (substr ($torg[$i], 2, 1) == 'm')
      {
        $f .= ($i + 1).'. <a class="blue" href="game.php?sid='.$sid.'&action=buy_misc&item='.$torg[$i].'&npc='.$npc.'&start='.$start.'&start2='.$start2.'">';
        $f .= $name.'</a>';
      }
      else
      {
        $f .= ($i + 1).'. <a class="blue" href="game.php?sid='.$sid.'&action=buy&item='.$it.'&count=1&npc='.$npc.'&start='.$start.'&start2='.$start2.'">';
        $f .= $name.'</a>';
        // dobavljaem ssylku na pokupku ukazanogo kolichestva
        $f .= ' (<a class="blue" href="game.php?sid='.$sid.'&action=buy_c&item='.$it.'&npc='.$npc.'&start='.$start.'&start2='.$start2.'">опт.</a>)';
      }
      if (is_in ('~', $param[3])) $f .= '['.$param[3].']';
      if (isset ($numb)) $f .= '['.$numb.']';
      unset ($numb);
      $f .= ' (ц: '.$cost.') | <a class="blue" href="game.php?sid='.$sid.'&action=show_trade_i&item='.$torg[$i].'&npc='.$npc.'&start='.$start.'&start2='.$start2.'">?</a><br/>';
    }
    // teperq md'shnye ssylki dlja prosmotra
    $nw = floor ($c2 / $show);
    for ($i = 0; $i <= $nw; $i++)
    {
      if ($i * $show == $start2) $f .= ($i + 1).' : ';
      elseif ($i * $show < $c2) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$npc.'&start='.$start.'&start2='.($i * $show).'">'.($i + 1).'</a> : ';
    }
    $f .= '<span class="gray">('.($c2).')</span>';
    $f .= '</p>';
  }

  //////////////////////// inventarq //////////////////////////////
  $f .= '<div class="y" id="inv5">';
  $f .= '<b>инвентарь:</b></div>';
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
  $f .= 'серебрo: <b>'.$p['money'].'</b></p>';
  if (!$c) $f .= '<p>нету интересующих товаров</p>';
  else
  {
    $f .= '<p>';
    // pereberem
    // start
    if (!isset ($_GET['start'])) $start = 0;
    else $start = $_GET['start'];
    if ($start >= $c) $start = $c - $show;
    if ($start < 0) $start = 0;
    $to = $start + $show;
    if ($to > $c) $to = $c;
    $i = $start + 1;

    unset ($numb);
    $q = do_mysql ("SELECT fullname, name, on_take, on_drop, price FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'inv' AND type LIKE '".$trade[0]."' LIMIT ".$start.", ".$show.";");
    while ($it = mysql_fetch_assoc ($q))
    {
      $qua = substr ($it['fullname'], 8, 3);
      $qlist = '.bas.nor.fur.tun.bet.rar.eli.epi.leg.';
      if (strpos ($qlist, $qua) === false) $qua = 'blue';
      if (substr ($it['fullname'], 2, 1) == 'f' && $it['on_take'] > 1) $numb = $it['on_take'];
      $f .= $i.'. ';
      if (substr ($it['fullname'], 0, 7) == 'i.f.tra' && $p['skills'][6]) $name = $it['on_drop'];
      else $name = $it['name'];
      if (substr ($it['fullname'], 2, 1) == 'm')
      {
        $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=sell_misc&item='.$it['fullname'].'&npc='.$npc.'&start='.$start.'&start2='.$start2.'">';
        $f .= $name.'</a> ('.$it['on_take'].')';
        $f .= ' <a class="blue" href="game.php?sid='.$sid.'&action=sell_misc2&item='.$it['fullname'].'&npc='.$npc.'&start='.$start.'&start2='.$start2.'&count=1000">*</a>';
      }
      else
      {
        $f .= '<a class="'.$qua.'" href="game.php?sid='.$sid.'&action=sell&item='.$it['fullname'].'&npc='.$npc.'&start='.$start.'&start2='.$start2.'">';
        $f .= $name.'</a>';
      }
      $cost = round ($it['price'] * $trade[2]);
      if (isset ($numb))
      {
        $f .= '['.$numb.']';
        $cost *= $numb;
        unset ($numb);
      }
      $f .= ' (ц: '.$cost.') | <a class="blue" href="game.php?sid='.$sid.'&action=showinfo&to='.$it['fullname'].'&npc='.$npc.'&start='.$start.'&start2='.$start2.'">?</a><br/>';
      $i++;
    }
    // teperq md'shnye ssylki dlja prosmotra
    $nw = floor ($c / $show);
    for ($i = 0; $i <= $nw; $i++)
    {
      if ($i * $show == $start) $f .= ($i + 1).' : ';
      elseif ($i * $show < $c) $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=trade&npc='.$npc.'&start2='.$start2.'&start='.($i * $show).'">'.($i + 1).'</a> : ';
    }
    $f .= '<span class="gray">('.$c.')</span>';
    $f .= '</p>';
  }

  $f .= '<p><a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>