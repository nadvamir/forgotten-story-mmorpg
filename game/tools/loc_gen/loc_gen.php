<?php
  include '../../site_header.php';
  include '../../site_footer.php';
  if (!isset ($_GET['map']))
  {
    $f = gen_sheader ('map');
    $f .= '<div clas="n" id="asfda">enter the map:<br/>';
    $f .= '<form action="loc_gen.php" method="get">';
    $f .= '<input type="text" name="map"/><br/>';
    $f .= '<input type="submit" value="generate!"/>';
    $f .= '</form>';
    $f .= gen_sfooter();
    exit ($f);
  }

  $map = preg_replace ('/[^a-z]/', '', $_GET['map']);
  if (!file_exists ('source/source_'.$map.'.php')) exit ('source not found!');
  include 'source/source_'.$map.'.php';
  exit ();


  // pokazyvaet kartu shematicheskuju
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

  // teperq vid karty:
  $f = '<table cellpadding="0" cellspasing="0" style="font-size:small">';
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