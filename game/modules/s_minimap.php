<?php
  // pokazyvaet kartu shematicheskuju
  // tolqko administracii, do 3lvl, ilizhe v gorode
  $mapname = substr ($p['location'], 0, 4);
  include_once ('modules/f_has_count.php');
  if (($p['admin'] < 2 && $p['stats'][0] > 2 ) && $mapname != 'rele' && $mapname != 'verg' && $mapname != 'elfc' && $mapname != 'orcc' && !has_count ('i.q.que.map_'.$mapname, 1, $LOGIN)) put_g_error ('карта недоступна');

  include 'modules/loc/'.$mapname.'.php';
  $left = $right = 0; // samaja vysokaja tochka, samaja pravaja tochka (ploshjadq = left * right)
  $map = '';
  foreach ($l as $key => $val)
  {
    $a1 = '';
    $a2 = '';
    if (file_exists ('modules/loc_desc/'.$mapname.'_'.$key.'.php'))
    {
      $a1 = '<big><a class="blue" href="game.php?sid='.$sid.'&action=locinfo&loc='.$mapname.'_'.$key.'">';
      $a2 = '</a></big>';
    }
    $loc = explode ('~', $l[$key]);
    $key = explode ('x', $key);
    $x = $key[0] * 2 - 1;
    $y = $key[1] * 2 - 1;
    if ($loc[6] == 1) $map[$y][$x] = $a1.'<span class="blue">o</span>'.$a2;
    if (!$loc[6]) $map[$y][$x] = $a1.'<span style="color:#258025">x</span>'.$a2;
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

  // teperq vid karty:
  $f = '<table cellpadding="0" cellspasing="0" style="font-size:small" id="minimap_table">';
  for ($i = $left + 1; $i > -1; $i--)
  {
    if (!isset($map[$i]) || !$map[$i]) continue;
    $f .= '<tr>';
    // perebiraem s verhu v niz (0x0 samyj nizkij element)
    for ($a = 0; $a < $right + 2; $a++)
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