<?php
  $locmap = 'tun6';
  /*$w = do_mysql ("SELECT weather FROM maps WHERE map = '".$locmap."';");
  $w = mysql_result ($w, 0);
  if ($w == 0 || $w == 1 || $w == 0.5) $temperature = -1;
  if ($w == 2 || $w == 3 || $w == 4 || $w == 5) $temperature = 0;
  if ($w == 6) $temperature = 1;*/
  global $UND;
  $UND = 1;
  $temperature = -1;
  $l['1x5'] = 'tun6|1x5~подземный ручей~подземный ручей~'.$temperature.'~3~0~1~tun7|8x4:6';
  $l['2x4'] = 'tun6|2x4~тоннель~тоннель~'.$temperature.'~38~0~1~';
  $l['2x6'] = 'tun6|2x6~подземный ручей~подземный ручей~'.$temperature.'~368~0~1~';
  $l['3x1'] = 'tun6|3x1~тупик~тоннель~'.$temperature.'~2~0~1~';
  $l['3x2'] = 'tun6|3x2~тоннель~тоннель~'.$temperature.'~27~0~1~';
  $l['3x3'] = 'tun6|3x3~тоннель~тоннель~'.$temperature.'~17~0~1~';
  $l['3x5'] = 'tun6|3x5~тоннель~тоннель~'.$temperature.'~16~0~1~';
  $l['3x7'] = 'tun6|3x7~подземный ручей~подземный ручей~'.$temperature.'~68~0~1~tun2|4x1:3';
  $l['4x3'] = 'tun6|4x3~тупик~тоннель~'.$temperature.'~3~0~1~';
  $l['4x6'] = 'tun6|4x6~тоннель~тоннель~'.$temperature.'~18~0~1~';
  $l['5x4'] = 'tun6|5x4~тоннель~тоннель~'.$temperature.'~268~0~1~';
  $l['5x5'] = 'tun6|5x5~тоннель~тоннель~'.$temperature.'~137~0~1~';
  $l['6x3'] = 'tun6|6x3~тоннель~тоннель~'.$temperature.'~15~0~1~';
  $l['6x6'] = 'tun6|6x6~тоннель~тоннель~'.$temperature.'~56~0~1~';
  $l['7x2'] = 'tun6|7x2~тупик~тоннель~'.$temperature.'~2~0~1~';
  $l['7x3'] = 'tun6|7x3~тоннель~тоннель~'.$temperature.'~457~0~1~';
  $l['7x6'] = 'tun6|7x6~тоннель~тоннель~'.$temperature.'~45~0~1~';
  $l['8x3'] = 'tun6|8x3~тоннель~тоннель~'.$temperature.'~4~0~1~tun5|1x4:3';
  $l['8x6'] = 'tun6|8x6~тупик~тоннель~'.$temperature.'~4~0~1~';
?>