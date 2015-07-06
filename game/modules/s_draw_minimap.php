<?php
  // pokazyvaet kartu shematicheskuju
  // nachalqnye dannye
  $map = substr ($p['location'], 0, 4);
  include 'modules/loc/'.$map.'.php';
  $p_key = substr ($p['location'], 5);
  $l[$p_key] = explode ('~', $l[$p_key]);
  if (!isset ($tileset)) $tileset = 'main';
  include 'modules/mapinfo/tileset_'.$tileset.'.php';
  if (!array_key_exists ($l[$p_key][6], $tile)) $tile[$l[$p_key][6]] = '~2';
  $tile[$l[$p_key][6]] = explode ('~', $tile[$l[$p_key][6]]);
  $depth = $tile[$l[$p_key][6]][1];
  $l[$p_key] = implode ('~', $l[$p_key]);
  $p_key2 = explode ('x', $p_key);
  $p_x = $p_key2[0];
  $p_y = $p_key2[1];
  // ustanovka pustogo mira
  // razmer ego
  $xm = 0 - ($p_x * 2 - 1) + ($depth * 2 + 1);
  $ym = 0 - ($p_y * 2 - 1) + ($depth * 2 + 1);
  //$xm = 0 - $p_x + $depth;
  //$ym = 0 - $p_y + $depth;
  $size = $depth * 5 + 1;
  //$size = $depth * 2 + 1;
  $map = array();
  for ($i = 0; $i < $size; $i++)
    for ($j = 0; $j < $size; $j++)
      $map[$i][$j] = '&nbsp;';

  $mas = connected_locs ($p_x, $p_y, $depth);
  // teperq pereobrazuem eto v kartu:
  $map = draw_map ($map, $mas, $tile);

  $fm = '<table border=1px>';
  for ($i = $size - 1; $i > -1; $i--)
  {
    $fm .= '<tr>';
    for ($j = 0; $j < $size; $j++)
      $fm .= '<td>'.$map[$i][$j].'</td>';
    $fm .= '</tr>';
  }
  $fm .= '</table>';
echo $fm;
  
  function draw_map ($map, $mas, $tile)
  {
    global $xm;
    global $ym;
    global $sid;
    // $tile dlja kartinok potom
    foreach ($mas as $key => $val)
    {
      // dostaem x i y
      $key2 = $key;
      $key = explode ('x', $key);
      // map nachinaetsja s 0x0 a ne 1x1
      $stag = $etag = '';
      if (isset ($mas[$key2][8]))
      {
        $stag = '<a class="blue" href="game.php?sid='.$sid.'&action=go_to_loc&loc_go='.$mas[$key2][0].'&stor='.$mas[$key2][8].'"><b>';
        $etag = '</b></a>';
      }
      $map[($key[1]) * 2 - 1 + $ym][($key[0]) * 2 - 1 + $xm] = $stag.$mas[$key2][6].$etag;
      //$map[($key[1]+$ym)][($key[0]+$xm)] = $stag.$mas[$key2][6].$etag;
      $c = strlen ($mas[$key2][4]);
      for ($i = 0; $i < $c; $i++) $map = add_map ($map, $mas[$key2][4][$i], (($key[0]) * 2 - 1 + $xm), (($key[1]) * 2 - 1 + $ym));
    }
    return $map;
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
echo $map[$y][$s];
    return $map;
  }

  // funkcija vozvrashjaet massiv lokacij, do kotoryh mozhno dojti
  function connected_locs ($x, $y, $depth)
  {
    global $p_x;
    global $p_y;
    $mas = array (); // massiv perehodov
    // stolqko raz skolqko ukazano v depth
    for ($i = 0; $i < $depth; $i++)
    {
      if ($i == 0) { $mas = add_entrances ($mas, $p_x, $p_y, 1); continue; }
      // zanosim verhnij krug
      for ($x = $p_x - $i, $y = $p_y + $i; $x <= $p_x + $i; $x++) if ($i > 0 && isset ($mas[$x.'x'.$y])) $mas = add_entrances ($mas, $x, $y);
      // zanosim pravyj krug
      for ($x = $p_x + $i, $y = $p_y + $i; $y >= $p_y - $i; $y--) if ($i > 0 && isset ($mas[$x.'x'.$y])) $mas = add_entrances ($mas, $x, $y);
      // zanosim nihzhnij krug
      for ($x = $p_x - $i, $y = $p_y - $i; $x <= $p_x + $i; $x++) if ($i > 0 && isset ($mas[$x.'x'.$y])) $mas = add_entrances ($mas, $x, $y);
      // zanosim verhnij krug
      for ($x = $p_x - $i, $y = $p_y + $i; $y >= $p_y - $i; $y--) if ($i > 0 && isset ($mas[$x.'x'.$y])) $mas = add_entrances ($mas, $x, $y);
    }
    return $mas;
  }

  // funkcija zanosit vse perehody v massiv
  function add_entrances ($mas, $x, $y, $go = 0)
  {
    global $l;
    // sodrano iz loc() ^^
          // teperq nado najti lokaciju igroka ($r[0]) i lokacii okruzhajushie ih
      $r[0] = explode ('~', $l[$x.'x'.$y]);
      // teperq algoritm koordinat okruzhenija ;)
      // snachala zapisyvajutsja vse vozmozhnye loki vokrug
      $loc[1][0] = $x;
      $loc[1][1] = $y;
      $a[1] = ($loc[1][0] - 1)."x".($loc[1][1] + 1);
      $a[2] = $loc[1][0]."x".($loc[1][1] + 1);
      $a[3] = ($loc[1][0] + 1)."x".($loc[1][1] + 1);
      $a[4] = ($loc[1][0] - 1)."x".$loc[1][1];
      $a[5] = ($loc[1][0] + 1)."x".$loc[1][1];
      $a[6] = ($loc[1][0] - 1)."x".($loc[1][1] - 1);
      $a[7] = $loc[1][0]."x".($loc[1][1] - 1);
      $a[8] = ($loc[1][0] + 1)."x".($loc[1][1] - 1);
      // teperq proverim kakie iz nih ukazany v faile
      // ukazano v r[0][4]
      // dlina stroki
      $len = strlen ($r[0][4]);
      for ($i = 0; $i < $len; $i++)
      {
        // v $r budet zapolnjatsja tolqko ukazanye tam
        // OBXJASNENIE V HELPE
        if (!array_key_exists ($a[$r[0][4][$i]], $mas))
        {
          $mas[$a[$r[0][4][$i]]] = explode ('~', $l[$a[$r[0][4][$i]]]);
          if ($go) $mas[$a[$r[0][4][$i]]][8] = $r[0][4][$i];
        }
      }
      /*if ($r[0][7])
      {
        $r[0][7] = explode (':', $r[0][7]);
        //if (!array_key_exists ($r[0][7][0]
      }*/
    return $mas;
  }
?>