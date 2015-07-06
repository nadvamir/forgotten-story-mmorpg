<?php
  // pokazyvaet navyki i staty
  $f = gen_header ('навыки');
  $f .= '<div class="y" id="skli5"><b>статы:</b></div><p>';
  $f .= 'уровень: '.$p['stats'][0].'<br/>';
  $f .= 'опыт навыка: '.$p['stats'][1].'/'.$p['stats'][2].'<br/>';
  $f .= 'очки навыка: '.$p['stats'][3].'<br/>';
  $f .= 'опыт: '.$p['stats'][4].'/'.$p['stats'][5].'<br/>';
  $f .= 'очки опыта: '.$p['stats'][6];
  if ($p['stats'][6] > 0)
  {
    $sum = array_sum ($p['skills']);
    if ($sum == 6) $price = 0;
    else $price = $sum * $sum * 1; 
    //else $price = $sum * 100;
    $f .= '<br/><small>цена поднятия: '.$price.' серебра<br/></small>';
  } 
  $f .= '</p>';
  $f .= '<p>';
  // pereberem, esli estq vstavim nazvanie, ukazhim naskolqko prokachen
  include 'modules/sp/sp_skillnames.php'; // nazvanija
  $c = count ($p['skills']);
  // limit
  $stn = $skc = 0;
  for ($i = 0; $i < 4; $i++) $stn += $p['skills'][$i];
  for ($i = 4; $i < $c; $i++) $skc += $p['skills'][$i];
  // vychitaem pljusy kolec i amuletov
  $jew = do_mysql ("SELECT on_use FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a9';");
  if (mysql_num_rows ($jew))
  {
    $jew = mysql_result ($jew, 0);
    $jew = explode ('~', $jew);
    $stn -= $jew[0];
    $stn -= $jew[1];
    $stn -= $jew[2];
    $stn -= $jew[3];
  }
  $jew = do_mysql ("SELECT on_use FROM items WHERE belongs = '".$LOGIN."' AND is_in = 'a10';");
  if (mysql_num_rows ($jew))
  {
    $jew = mysql_result ($jew, 0);
    $jew = explode ('~', $jew);
    $stn -= $jew[0];
    $stn -= $jew[1];
    $stn -= $jew[2];
    $stn -= $jew[3];
  }
  $stn -= 4; // nachalqnye
  $stn -= $p['stats'][0] * 2; // urovnevye
  
  $skc += $p['stats'][6];

  for ($i = 0; $i < 4; $i++)
  {
    ###  proverku na prjamoe ispolqzovanie navyka budem delatq potom
    if (!$p['skills'][$i]) continue;
    $cl = 'black';
    if ($i == 0 && is_in ('jarostq', $AFF) ||
        $i == 1 && is_in ('skorostq', $AFF) ||
        $i == 2 && is_in ('prosvetlenie', $AFF) ||
        $i == 3 && is_in ('koordinacija', $AFF)) $cl = 'blue';
    $f .= $skn[$i].': <span class="'.$cl.'">'.$p['skills'][$i].'</span>';
    $nop = 0;
    //if ((($stn - ($p['stats'][0] * 2)) * 4 > ($skc * 5)) && $p['stats'][0] > 1) $nop = 1;
    if ($p['stats'][0] > 1 && ($stn / $skc) > (4/5)) $nop = 1;
    if ($p['stats'][6] && !$nop) $f .= ' <a class="red" href="game.php?sid='.$sid.'&action=incr_skill&skill='.$i.'">+</a>';
    if ($p['skills'][$i] > 1) $f .= ' <a class="red" href="game.php?sid='.$sid.'&action=decr_skill&skill='.$i.'">-</a>';
    if (file_exists ('modules/skills/sk_'.$i.'.php')) $f .= ' <a class="blue" href="game.php?sid='.$sid.'&action=use_skill&skill='.$i.'">></a>';
    $f .= '<br/>';
  }
  $f .= '</p><div class="y" id="aodf"><b>навыки:</b></div><p>';
  for ($i = 4; $i < $c; $i++)
  {
    ###  proverku na prjamoe ispolqzovanie navyka budem delatq potom
    if (!$p['skills'][$i]) continue;
    $f .= $skn[$i].': '.$p['skills'][$i];
    if ($p['stats'][6]) $f .= ' <a class="red" href="game.php?sid='.$sid.'&action=incr_skill&skill='.$i.'">+</a>';
    if ($p['skills'][$i] > 1) $f .= ' <a class="red" href="game.php?sid='.$sid.'&action=decr_skill&skill='.$i.'">-</a>';
    if (file_exists ('modules/skills/sk_'.$i.'.php')) $f .= ' <a class="blue" href="game.php?sid='.$sid.'&action=use_skill&skill='.$i.'">></a>';
    $f .= '<br/>';
  }
  $f .= '<a class="blue" href="game.php?sid='.$sid.'&action=showinventory">в инвентарь</a><br/>';
  $f .= '<a class="blue" href="game.php?sid='.$sid.'">в игру</a></p>';
  $f .= gen_footer();
  exit ($f);
?>