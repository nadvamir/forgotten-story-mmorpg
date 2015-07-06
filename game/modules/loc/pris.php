<?php
  // TJURMA
  $locmap = 'eway';
  $w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  // vyhod: 
  global $LOGIN;
  $q = do_mysql ("SELECT rase, qlvl, id_player, karma FROM players WHERE login = '".$LOGIN."';");
  $pp = mysql_fetch_assoc ($q);
  if ($pp['karma'] < -99) $out = '';
  else
  {
    // nuzhno datq vyhod:
    if ($pp['qlvl'] < 2)
    {
      if ($pp['rase'] == 1) $out = 'rele|8x8:4';
      elseif ($pp['rase'] == 2) $out = 'elfc|5x1:4';
      else $out = 'verg|4x1:4';
    }
    else
      $out = 'mva1|7x1:4'; // adres tropinki v gorah
  }
  $l['1x1'] = 'pris|1x1~Тюрьма~тюрьма~'.$temperature.'~5~0~0~'.$out;
  $l['1x2'] = 'pris|1x2~Бараки~Бараки~'.$temperature.'~5~0~0~';
  $l['1x3'] = 'pris|1x3~бараки~бараки~'.$temperature.'~5~0~0~';
  $l['2x1'] = 'pris|2x1~тюрьма~тюрьма~'.$temperature.'~245~0~0~';
  $l['2x2'] = 'pris|2x2~бараки~бараки~'.$temperature.'~2457~0~0~';
  $l['2x3'] = 'pris|2x3~бараки~бараки~'.$temperature.'~457~0~0~';
  $l['3x1'] = 'pris|3x1~тюрьма~тюрьма~'.$temperature.'~45~0~0~';
  $l['3x2'] = 'pris|3x2~бараки~бараки~'.$temperature.'~4~0~0~';
  $l['3x3'] = 'pris|3x3~бараки~бараки~'.$temperature.'~4~0~0~';
  $l['4x1'] = 'pris|4x1~камнеломня~камнеломня~'.$temperature.'~245~0~0~';
  $l['4x2'] = 'pris|4x2~камнеломня~камнеломня~'.$temperature.'~2357~0~0~';
  $l['4x3'] = 'pris|4x3~камнеломня~камнеломня~'.$temperature.'~7~0~0~';
  $l['5x1'] = 'pris|5x1~камнеломня~камнеломня~'.$temperature.'~4~0~0~';
  $l['5x2'] = 'pris|5x2~камнеломня~камнеломня~'.$temperature.'~4~0~0~';
  $l['5x3'] = 'pris|5x3~камнеломня~камнеломня~'.$temperature.'~6~0~0~';
?>