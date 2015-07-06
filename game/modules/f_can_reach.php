<?php
  // mozhno li projti do etoj lokacii:
  function can_reach ($from, $to, $depth)
  {
    $map = substr ($from, 0, 4);
    if ($map != substr ($to, 0, 4)) put_error ('raznye karty');
    include 'modules/loc/'.$map.'.php';
    $fromi = substr ($from, 5);
    $toi = substr ($to, 5);
    if (!isset($l[$fromi]) || !isset ($l[$toi])) put_error ('нет таких лок');
    
  }
  // pokazyvaet kartu shematicheskuju
  $depth = 1;
  $edepth = 1;
  $ploc = explode ('|', $p['location']);
  $pkey = explode ('x', $ploc[1]);
  $pX = $pkey[0];
  $pY = $pkey[1];
  $mapname = substr ($p['location'], 0, 4);
  include 'modules/loc/'.$mapname.'.php';
  $left = $right = 0; // samaja vysokaja tochka, samaja pravaja tochka (ploshjadq = left * right)
  $map = '';
  foreach ($l as $key => $val)
  {
    $loc = explode ('~', $l[$key]);
    $key = explode ('x', $key);
    $x = $key[0] * 2 - 1;
    $y = $key[1] * 2 - 1;
    if (!need_show ($pX, $pY, $key[0], $key[1], $depth)) continue;
    if ($loc[6] == 1) $map[$y][$x] = '<span class="blue">o</span>';
    if (!$loc[6]) $map[$y][$x] = '<span style="color:#258025">x</span>';
    if ($p['location'] == $mapname.'|'.$key[0].'x'.$key[1]) $map[$y][$x] = '<b><u>'.$map[$y][$x].'</u></b>';
    
    $c = strlen ($loc[4]);
    for ($i = 0; $i < $c; $i++)
    {
      $map = add_map ($map, $loc[4][$i], $x, $y);
    }
    if ($loc[7])
    {
      $loc[7] = explode (':', $loc[7]);
      $map = add_map ($map, $loc[7][1], $x, $y);
    }
    if ($y > $left) $left = $y;
    if ($x > $right) $right = $x;
  }
  function add_map ($map, $i, $x, $y)
  {
    if ($i == 1) { $x--; $y++; $s = '&#92;'; }
    elseif ($i == 2) { $y++; $s = '|'; }
    elseif ($i == 3) { $x++; $y++; $s = '/'; }
    elseif ($i == 4) { $x--; $s = '-'; }
    elseif ($i == 5) { $x++; $s = '-'; }
    elseif ($i == 6) { $x--; $y--; $s = '/'; }
    elseif ($i == 7) { $y--; $s = '|'; }
    else { $x++; $y--; $s = '&#92;'; }
    $map[$y][$x] = $s;
    return $map;
  }
  function need_show ($pX, $pY, $x, $y, $depth)
  {
    $yFar = $pY - $y;
    $xFar = $pX - $x;
    if ($yFar < 0) $yFar *= -1;
    if ($xFar < 0) $xFar *= -1;
    if ($xFar > $depth || $yFar > $depth) return 0;
    return 1;
  }

  // teperq vid karty:
  $f = '<table cellpadding="0" cellspasing="0" style="font-size:small">';
  $down = $pY - $depth - 1;
  if ($down < -1) $down = -1;
  $st = $pX - $depth;
  if ($st < 0) $st = 0;
  for ($i = $left + 1; $i > $down; $i--)
  {
    if (!isset($map[$i]) || !$map[$i]) continue;
    $f .= '<tr>';
    // perebiraem s verhu v niz (0x0 samyj nizkij element)
    for ($a = $st; $a < $right + 2; $a++)
    {
      $f .= '<td>';
      if (!isset($map[$i][$a]) || !$map[$i][$a]) $f .= '&nbsp;';
      else $f .= ''.$map[$i][$a].'';
      $f .= '</td>';
    }
    $f .= '</tr>';
  }
  $f .= '</table>';
  exit_msg ('карта местности', $f);
?>