<?php
  // vostochnaja doroga (eway)
  $locmap = 'cway';
  $w = do_mysql ("SELEcT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;
  $l['1x5'] = 'cway|1x5~У моcта~к моcту~'.$temperature.'~5~0~0~';
  $l['2x5'] = 'cway|2x5~Дорога~Дорога~'.$temperature.'~48~0~0~';
  $l['3x4'] = 'cway|3x4~Дорога~Дорога~'.$temperature.'~18~0~0~';
  $l['4x3'] = 'cway|4x3~Дорога~Дорога~'.$temperature.'~13~0~0~prf3|7x5:8';
  $l['5x4'] = 'cway|5x4~Дорога~Дорога~'.$temperature.'~36~0~0~';
  $l['6x5'] = 'cway|6x5~Дорога~Дорога~'.$temperature.'~56~0~0~';
  $l['7x5'] = 'cway|7x5~Дорога~Дорога~'.$temperature.'~48~0~0~';
  $l['8x4'] = 'cway|8x4~Дорога~Дорога~'.$temperature.'~18~0~0~';
  $l['9x3'] = 'cway|9x3~Дорога~Дорога~'.$temperature.'~15~0~0~';
  $l['10x3'] = 'cway|10x3~Дорога~Дорога~'.$temperature.'~45~0~0~';
  $l['11x3'] = 'cway|11x3~Дорога~Дорога~'.$temperature.'~48~0~0~prf2|4x5:7';
  $l['12x2'] = 'cway|12x2~Дорога~Дорога~'.$temperature.'~15~0~0~';
  $l['13x2'] = 'cway|13x2~Дорога~Дорога~'.$temperature.'~48~0~0~';
  $l['14x1'] = 'cway|14x1~Дорога~Дорога~'.$temperature.'~13~0~0~prf1|1x4:5';
  $l['15x2'] = 'cway|15x2~Дорога~Дорога~'.$temperature.'~56~0~0~';
  $l['16x2'] = 'cway|16x2~Дорога~Дорога~'.$temperature.'~34~0~0~';
  $l['17x3'] = 'cway|17x3~Дорога~Дорога~'.$temperature.'~36~0~0~prf1|4x5:8';
  $l['18x4'] = 'cway|18x4~Дорога~Дорога~'.$temperature.'~56~0~0~';
  $l['19x4'] = 'cway|19x4~Дорога~Дорога~'.$temperature.'~45~0~0~';
  $l['20x4'] = 'cway|20x4~Дорога~Дорога~'.$temperature.'~45~0~0~';
  $l['21x4'] = 'cway|21x4~Дорога~Дорога~'.$temperature.'~4~0~0~rele|1x8:5';
?>